<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\CountryModel;
use App\Models\ProductsDetailModel;
use App\Models\ProductsModel;
use App\Models\OrderModel;
use App\Models\Setting;
use App\Models\RegisterModel;

use Stripe\Stripe;


class Cart extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Cart';
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        return view('site/cart/index',$data);
    }

    public function checkCoupon()
    {
        $db = \Config\Database::connect();
        $coupon_code = $this->request->getVar('coupon');
        $coupon_data = $db->table("coupons")->where(['coupon_code' => $coupon_code, 'user_id' => getUserId(), 'is_used' => 0])->get()->getResult();
        if( count($coupon_data) > 0){
            $products = $db->table("spree")->where(['com_id' => $coupon_data[0]->com_id, 'store_id' => $coupon_data[0]->vendor_id, 'user_id' => getUserId()])->get()->getResult();
            foreach ($products as $key => $prod) {
                $arr = (new ProductsModel)-> getProductById($prod->pid);
                $this->addFromCoupon($arr);
            }
            return redirect()->to('cart/checkout?coupon_code='.$coupon_code);
        }else{
            return redirect()->back();
        }
    }
    
    public function checkout()
    {
        $db = \Config\Database::connect();
        if ( is_array(get_cart_contents()) && count(get_cart_contents()) > 0 ) {
            $data['pagetitle'] = 'Checkout';
            $allCoupons = [];
            $vendors = [];
            foreach (get_cart_contents() as $key => $value) {
                $arr = $db->table('products')->where('id', $value['id'])->get()->getResult();
                $vendor_id = $arr[0]->store_id;
                if(!in_array($vendor_id, $vendors)){
                    array_push($vendors, $vendor_id);
                    $coupons = $db->table('coupons')->where(['vendor_id' => $vendor_id, 'user_id' => getUserId(), 'is_used' => 0])->get()->getResult();
                    foreach ($coupons as $key => $coup) {
                    $store = $db->table('vendor')->where(['id' => $vendor_id])->get()->getResult();
                        $temp = [
                            'id' => $coup->id,
                            'coupon_code' => $coup->coupon_code,
                            'coupon_price' => $coup->coupon_price,
                            'vendor' => $store[0]->store_name
                        ];
                        array_push($allCoupons, $temp);
                    }
                }
            }
            $data['coupons'] = $allCoupons;
            $data['country'] = (new CountryModel())->getAll();
            $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
            $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
            return view('site/cart/checkout',$data);
        } else {
            return redirect()->to('/');
        }
    }

    public function address()
    {
        if ( is_array(get_cart_contents()) && count(get_cart_contents()) > 0 ) {
            $postdata = $this->request->getPost();
            $ip = $this->request->getIPAddress();
            $orderCart = get_cart_contents();
            if($postdata['gateway'] == 'coupon_code'){
                $db = \Config\Database::connect();
                $coupon_data = $db->table("coupons")->where(['coupon_code' => $postdata['coupon_code'], 'user_id' => getUserId(), 'is_used' => 0])->get()->getResultArray();
                if( count($coupon_data) > 0){
                   foreach ($orderCart as $key => $order) {
                        $p = $db->table("products")->where(['id'=>$order['id']])->get()->getRowArray();
                        if($p['store_id'] != $coupon_data[0]['vendor_id']){
                            echo "<script>alert('Invalid Coupon code.')</script>";
                            return redirect()->back();        
                        }
                   }
                   
                }else{
                    echo "<script>alert('Invalid Coupon code.')</script>";
                    return redirect()->back();
                }
            }
            $ord = (new OrderModel())->insertOrder($ip,$postdata,$orderCart);
            if($postdata['gateway'] == 'coupon_code'){
                $db = \Config\Database::connect();
                $db->table("coupons")->set('is_used', 1)->set('used_at', date('Y-m-d H:i:s'))->where('coupon_code', $postdata['coupon_code'])->update();
                $db->table("spree")->where(['com_id' => $coupon_data[0]['com_id'], 'store_id' => $coupon_data[0]['vendor_id'] ])->delete();
            }
            if ( $postdata['gateway'] == 'creditcard') {
                get_cart_destroy();
                return redirect()->to('/cart/payments/'.my_encrypt($ord));        
            } else {
                echo "<script>alert('Invalid Request.')</script>"; // COD disabled from now on.
                return redirect()->back()->with('error', 'Invalid Request.');      
                // get_cart_destroy();
                // $this->setCheckoutSession();
                // return redirect()->to('/cart/thankyou');
            }
            // return redirect()->to('/dashboard');
        } else {
            return redirect()->to('/');
        }
    }

    public function setCheckoutSession()
    {
        session()->setFlashdata('checkout_success', true);
    }

    public function payments()
    {
        $user_email = (new RegisterModel())->getByIdResult(getUserId());
        $order_id = my_decrypt($this->request->getUri()->getSegment(3));
        $ord = (new OrderModel())->getCheckoutUserSingleOrder($order_id);
        $product = [];

        if ( is_array($ord) && count($ord) > 0 ) {
            foreach ( $ord['items'] as $od ) {
                $price = explode('.',$od['price']);
                if ( is_array($price) && count($price) > 0 ) {
                    $stripe_price = $price[0];
                    $second_price = isset($price[1]) ? $price[1] : 0;
                    $len = strlen($second_price);
                    if ( $len == 2 ) {
                        $stripe_price .= $second_price;
                    } else {
                        $stripe_price .= $second_price.'0';
                    }
                } else {
                    $stripe_price = $price[0].'00';
                }
                $product[] = [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $od['item_name'],
                                'images' => [ $od['item_image'] ],
                            ],
                            'unit_amount' => $stripe_price,
                        ],
                        'quantity' => $od['qty'],
                    ];
            }
        }

        $shipping = explode('.',$ord['order']['shipping']);
        if ( is_array($shipping) && count($shipping) > 0 ) {
            $stripe_shipping = $shipping[0];
            $second_shipping = isset($shipping[1]) ? $shipping[1] : 0;
            $len_shipping = strlen($second_shipping);
            if ( $len_shipping == 2 ) {
                $stripe_shipping .= $second_shipping;
            } else {
                $stripe_shipping .= $second_shipping.'0';
            }
        } else {
            $stripe_shipping = $shipping[0].'00';
        }

        // print '<pre>';
        // print_r($ord);
        // print '</pre>';

        // die();
        \Stripe\Stripe::setApiKey( getenv('STRIPE_TEST_SERVER') );
        $session = \Stripe\Checkout\Session::create([
            'customer_email' => $user_email['email'],
            'payment_method_types' => ['card'],
            'shipping_options' => [
                [
                    'shipping_rate_data' => [
                      'type' => 'fixed_amount',
                      'fixed_amount' => [
                        'amount' => $stripe_shipping,
                        'currency' => 'usd',
                      ],
                      'display_name' => 'Shipping',
                      // Delivers between 5-7 business days
                      'delivery_estimate' => [
                        'minimum' => [
                          'unit' => 'business_day',
                          'value' => 5,
                        ],
                        'maximum' => [
                          'unit' => 'business_day',
                          'value' => 7,
                        ],
                      ]
                    ]
                ],
            ],
            'line_items' => [$product],
            'mode' => 'payment',
            'success_url' => base_url().'/payments/success?order='.$this->request->getUri()->getSegment(3).'&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => base_url().'/payments/cancel?order='.$this->request->getUri()->getSegment(3).'&session_id={CHECKOUT_SESSION_ID}',
        ]);
        return redirect()->to( $session->url );
    }

    public function paysuccess()
    {
        $session_id = $this->request->getVar('session_id');
        $order = my_decrypt($this->request->getVar('order'));
        $stripe = new \Stripe\StripeClient( getenv('STRIPE_TEST_SERVER') );
        $session = $stripe->checkout->sessions->retrieve($session_id);
        $payment_response = serialize($session);
        $payment_confirmation = $session->payment_status;
        $payment_intent = $stripe->paymentIntents->retrieve($session->payment_intent);
        switch ($payment_intent->status) {
            case 'succeeded':
                    (new OrderModel())->add(['id' => filtreData($order), 'status' => 1, 'payment_confirmation' => $payment_intent->status , 'payment_response' => $payment_response]);
                    (new OrderModel())->updateItemOrderStatus(filtreData($order),1);
                break;
            
            case 'processing':
                    (new OrderModel())->add(['id' => filtreData($order), 'status' => 0, 'payment_confirmation' => $payment_intent->status , 'payment_response' => $payment_response]);
                break;

            default:
                    (new OrderModel())->add(['id' => filtreData($order), 'status' => 0, 'payment_confirmation' => $payment_intent->status , 'payment_response' => 'Your payment was not successful, please try again']);
                break;
        }
        $this->setCheckoutSession();
        return redirect()->to('/cart/thankyou?order_msg='.urlencode($payment_intent->status));
        // return redirect()->to('/dashboard?order_msg='.urlencode($payment_intent->status));
    }

    public function paycancel()
    {
        $session_id = $this->request->getVar('session_id');
        $order = my_decrypt($this->request->getVar('order'));
        \Stripe\Stripe::setApiKey( getenv('STRIPE_TEST_SERVER') );
        $session = \Stripe\Checkout\Session::retrieve($session_id);
        $payment_response = serialize($session);
        $payment_confirmation = $session->payment_status;
        (new OrderModel())->add(['id' => filtreData($order), 'status' => 0, 'payment_confirmation' => $payment_confirmation , 'payment_response' => $payment_response]);
        (new OrderModel())->updateItemOrderStatus(filtreData($order),0);
        return redirect()->to('/dashboard');
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            // get_cart_destroy();
            // $postdata = json_decode($this->request->getPost());
            $single = filtreData($this->request->getVar('single'));
            $id = filtreData(my_decrypt($this->request->getVar('pid')));
            $pname = filtreData($this->request->getVar('pname'));
            $qtycart = filtreData($this->request->getVar('qtycart'));
            $itemprice = filtreData($this->request->getVar('itemprice'));
            $item_image = filtreData($this->request->getVar('item_image'));
            $item_handle = filtreData($this->request->getVar('item_handle'));
            $item_transfer = filtreData($this->request->getVar('item_transfer'));
            $givewaytags = filtreData($this->request->getVar('givewaytags'));
            $attr = $this->request->getVar('attr');
            $datacart = [];
            $result = [];
            if ( $single == 1 ) {
                $datacart['id'] = $id;
                $datacart['qty'] = $qtycart;
                $datacart['name'] = $pname;
                $datacart['price'] = number_format((float)$itemprice, 2, '.', '');
                $datacart['subtotal'] = number_format((float)$itemprice, 2, '.', '') * $qtycart;
                $datacart['item_image'] = $item_image;
                $datacart['item_handle'] = $item_handle;
                $datacart['item_transfer'] = $item_transfer;
                $datacart['givewaytags'] = $givewaytags;
                if ( !empty($attr) && is_array($attr) && count($attr) > 0 ) {
                    foreach( $attr as $rattribute ) {
                        $explode_attr = explode('_',$rattribute);
                        if ( is_array($explode_attr) && count($explode_attr) > 0 ) {
                            if ( count($explode_attr) > 0 ) {
                                if ( !is_numeric($explode_attr[0]) ) {
                                    $new_attr = my_decrypt($explode_attr[0]);
                                } else {
                                    $new_attr = $explode_attr[0];
                                }
                            } else {
                                $new_attr = '';
                            }
                            if ( count($explode_attr) > 1 ) {
                                if ( !is_numeric($explode_attr[1]) ) {
                                    $new_value_id = my_decrypt($explode_attr[1]);
                                } else {
                                    $new_value_id = $explode_attr[1];
                                }
                            } else {
                                $new_value_id = '';
                            }
                            if ( count($explode_attr) > 2 ) {
                                $atte_price_new = $explode_attr[2];
                            } else {
                                $atte_price_new = 0;
                            }
                        } else {
                            $atte_price_new = 0;
                            $new_value_id = '';
                            $new_attr = '';
                        }
                        $result[] = [
                                        'attribute_id' => $new_attr,
                                        'value_id' => $new_value_id,
                                        'attr_price' => $atte_price_new,
                                        'value_name' => (new \App\Models\AttributeValueModel())->getValueNameWithAttr($new_value_id)
                                    ];
                    }
                }
            } else {
                $datacart['id'] = $id;
                $datacart['qty'] = $qtycart;
                $datacart['name'] = $pname;
                $datacart['price'] = number_format((float)$itemprice, 2, '.', '');
                $datacart['subtotal'] = number_format((float)$itemprice, 2, '.', '') * $qtycart;
                $datacart['item_image'] = $item_image;
                $datacart['item_handle'] = $item_handle;
                $datacart['item_transfer'] = $item_transfer;
                $datacart['givewaytags'] = $givewaytags;
                if ( !empty($attr) && is_array($attr) && count($attr) > 0 ) {
                    foreach( $attr as $rattribute ) {
                        $explode_attr = explode('_',$rattribute);
                        if ( is_array($explode_attr) && count($explode_attr) > 0 ) {
                            if ( count($explode_attr) > 0 ) {
                                if ( !is_numeric($explode_attr[0]) ) {
                                    $new_attr = my_decrypt($explode_attr[0]);
                                } else {
                                    $new_attr = $explode_attr[0];
                                }
                            } else {
                                $new_attr = '';
                            }
                            if ( count($explode_attr) > 1 ) {
                                if ( !is_numeric($explode_attr[1]) ) {
                                    $new_value_id = my_decrypt($explode_attr[1]);
                                } else {
                                    $new_value_id = $explode_attr[1];
                                }
                            } else {
                                $new_value_id = '';
                            }
                            if ( count($explode_attr) > 2 ) {
                                $atte_price_new = $explode_attr[2];
                            } else {
                                $atte_price_new = 0;
                            }
                        } else {
                            $atte_price_new = 0;
                            $new_value_id = '';
                            $new_attr = '';
                        }
                        $result[] = [
                                        'attribute_id' => $new_attr,
                                        'value_id' => $new_value_id,
                                        'attr_price' => $atte_price_new,
                                        'value_name' => (new \App\Models\AttributeValueModel())->getValueNameWithAttr($new_value_id)
                                    ];
                    }
                }
            }
            $datacart['options'] = $result;
            if ( in_array($datacart['id'],checkItemCart()) ) {
                $rowid = GetCartRowId($datacart['id']);
                if ( $single == 1 ) {
                    $datacart['qty'] = $rowid[0][1] + 1;
                }
                $datacart['rowid'] = $rowid[0][0];
                update_cart_contents($datacart);
            } else {
                insert_cart_contents($datacart);
            }
            return $this->response->setJSON(count(get_cart_contents()));
        
        } else {
            return redirect()->to('/');
        }
    }


    public function addFromCoupon($product)
    {
        
            get_cart_destroy();
                if ( !empty($product->cover) ) {
                    $value_img_ext_product = explode('.', $product->cover);
                    $cover = base_url().'/images/product/'.$value_img_ext_product[0].'/'.end($value_img_ext_product).'/250';
                } else { 
                    $cover = base_url().'/images/product/img-not-found/jpg/100';
                }
            $datacart = [];
            $result = [];
            $datacart['id'] = $product['id'];
            $datacart['qty'] = 1;
            $datacart['name'] = $product['name'];
            $datacart['price'] = number_format((float)$product['deal_final_price'], 2, '.', '');
            $datacart['subtotal'] = number_format((float)$product['deal_final_price'], 2, '.', '') * 1;
            $datacart['item_image'] = $cover;
            $datacart['item_handle'] = $product['handlingcharges'];
            $datacart['item_transfer'] = $product['freeshipat'];
            $datacart['givewaytags'] = 0;
            $datacart['options'] = $result;
            insert_cart_contents($datacart);
    }
    
    public function update_cart()
    {
        $post = $this->request->getPost();
        $datacart = [
                    'rowid' => filtreData($post['rowid']),
                    'qty' => filtreData($post['qty']),
                ];
        update_cart_contents($datacart);
        print json_encode(count(get_cart_contents()));
    }
    
    public function delete_item_cart()
    {
        $post = $this->request->getPost();
        $datacart = filtreData($post['rowid']);
        get_cart_remove_item($datacart);
        print json_encode(count(get_cart_contents()));
    }

    public function useCoupon()
    {
        $db = \Config\Database::connect();
        $post = $this->request->getPost();
        $coupon = $post['coupon'];
        $couponArr = explode(',', $coupon);
        $coupon_data = $db->table('coupons')->whereIn('coupon_code', $couponArr)->get()->getResult();
        if($coupon_data){
            $html = $this->generateHtmlForOrder($coupon_data);
            return json_encode(['success'=>true, 'html' => $html, '_cc' => csrf_hash()]);
        }else{  
            return json_encode(['success'=>false, 'message' => 'Invalid coupon code!', '_cc' => csrf_hash()]);
        }
        
    }

    private function generateHtmlForOrder($coupons)
    {
        if ( is_array(get_cart_contents()) && count(get_cart_contents()) > 0 ) { 
            $html = '
                <h3>Your order</h3>
                <div class="order_list_checkout checkout-border d-flex">
                    <div class="left title">Product</div>
                    <div class="right title">Sub-total</div>
                </div>
                <div class="order_list_checkout checkout-border mt-3">';  
                    $grand_sub_total = [];
                    $grand_shipp_total = [];
                    foreach( get_cart_contents() as $cart ) {
                        $total_attr_price = [];
                        if ( is_array($cart['options']) && count($cart['options']) > 0 ) {
                            foreach ( $cart['options'] as $option ) {
                                $total_attr_price[] = $option['attr_price'];
                            }
                        }
                        $single_item = (new \App\Models\ProductsDetailModel())->getById($cart['id']);
                        if ( $single_item['deal_enable'] > 0 ) {
                            $new_total_price = ( $single_item['deal_final_price'] + array_sum($total_attr_price) );
                        } else {
                            $new_total_price = ( $single_item['final_price'] + array_sum($total_attr_price) );
                        }


                        $item_add_ship = ( $new_total_price * $cart['qty'] );
                        for ($i=0; $i < count($coupons); $i++) { 
                            $coupon = $coupons[$i];
                            if($single_item['store_id'] == $coupon->vendor_id && $coupon->coupon_price > 0){
                                if($coupon->coupon_price >= $item_add_ship){
                                    $coupon->coupon_price = $coupon->coupon_price - $item_add_ship;
                                    $item_add_ship = 0;
                                }else if($item_add_ship > $coupon->coupon_price) {
                                    $item_add_ship = $item_add_ship - $coupon->coupon_price;
                                    $coupon->coupon_price = 0;
                                }
                            }
                            $coupons[$i] = $coupon;
                        }
                        $handle_ship = $cart['item_handle'];
                        if ( !empty($single_item['shipping_cost']) && strlen($single_item['shipping_cost']) > 0 ) {
                            $handle_ship = $single_item['shipping_cost'];
                        }

                        if ( $item_add_ship >= $cart['item_transfer'] ) {
                            $handle_ship = 0;
                        }

                        $sub_total_price = ( $item_add_ship ) + $handle_ship;
                        $grand_sub_total[] = $item_add_ship;//( $new_total_price * $cart['qty'] );
                        $grand_shipp_total[] = $handle_ship;
            $html .= '<div class="items d-flex">
                        <div class="left">'.ucfirst($cart['name']).'</div>
                        <div class="right">$'.number_format($sub_total_price,2).'</div>
                    </div>';
        }
        $html .= '</div>
                <div class="order_list_checkout mt-3 d-flex">
                    <div class="left">Sub-total</div>
                    <div class="right">$'.number_format(array_sum($grand_sub_total),2).'</div>
                </div>
                <div class="order_list_checkout checkout-border d-flex">
                    <div class="left">Shipping</div>';
        if ( is_array($grand_shipp_total) && count($grand_shipp_total) > 0 ) { 
            $html.='<div class="right">$'.number_format(array_sum($grand_shipp_total),2).'</div>';
        } else {
            $html .= '<div class="right">Free Shipping</div>';
        } 
        $html .= '</div>
                <div class="order_list_checkout mt-3 d-flex">
                    <div class="left"><b>Total</b></div>
                    <div class="right">
                        <span id="shippingTotal"><b>$'.number_format(array_sum($grand_sub_total) + array_sum($grand_shipp_total),2).'</b></span>
                        <div class="price-zaptta d-flex">
                            <span>Earn</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="20" viewBox="0 0 9 20">
                                  <g id="Group_667" data-name="Group 667" transform="translate(-1129 -531)">
                                    <text id="Z" transform="translate(1129 547)" fill="#1f961b" font-size="15" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>
                                    <g id="Rectangle_4131" data-name="Rectangle 4131" transform="translate(1133 546.5)" fill="none" stroke="#1f961b" stroke-width="1">
                                      <rect width="1.2" height="2" stroke="none"/>
                                      <rect x="0.5" y="0.5" width="0.2" height="1" fill="none"/>
                                    </g>
                                    <g id="Rectangle_4132" data-name="Rectangle 4132" transform="translate(1133 535)" fill="none" stroke="#1f961b" stroke-width="1">
                                      <rect width="1.2" height="2" stroke="none"/>
                                      <rect x="0.5" y="0.5" width="0.2" height="1" fill="none"/>
                                    </g>
                                  </g>
                                </svg>
                            </span>
                            <span>per $1 spent</span>
                        </div>
                    </div>';
            return $html;
        }
    }

    /**
     * Cart checkout thankyou page
     * @return view
     */
    public function thankyou() {
        if ( session()->has('checkout_success')  ) {
            session()->remove('checkout_success');
            $data['title'] = 'Thank You';
            $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
            $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
            return view('site/cart/thankyou',$data);
        }
        return redirect()->to('/');
    }


}

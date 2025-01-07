<?php
namespace App\Traits;

use App\Models\OrderModel;
use App\Models\RegisterModel;

trait CartTrait
{
    /**
     * Add to cart
     */
    public function addToCart($cart) : array {
         // get_cart_destroy();
            // $postdata = json_decode($this->request->getPost());
            $single = filtreData($cart['single']??null);
            $id = filtreData(my_decrypt($cart['pid']));
            $pname = filtreData($cart['pname']);
            $qtycart = filtreData($cart['qtycart']);
            $itemprice = filtreData($cart['itemprice']);
            $item_image = filtreData($cart['item_image']);
            $item_handle = filtreData($cart['item_handle']);
            $item_transfer = filtreData($cart['item_transfer']);
            $givewaytags = filtreData($cart['givewaytags']);
            $attr = $cart['attr'];
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
            return get_cart_contents();
    }


    /**
     * Checkout trait
     * @param array $postData
     * @return array
     * @author 
     */
    public static function checkoutTrait($postdata) : array {
        $db = \Config\Database::connect();
        if ( is_array(get_cart_contents()) && count(get_cart_contents()) > 0 ) {
            $ip = request()->getIPAddress();
            $orderCart = get_cart_contents();
            if($postdata['gateway'] == 'coupon_code'){
                $coupon_data = $db->table("coupons")->where(['coupon_code' => $postdata['coupon_code'], 'user_id' => getUserId(), 'is_used' => 0])->get()->getResultArray();
                if( count($coupon_data) > 0){
                   foreach ($orderCart as $key => $order) {
                        $p = $db->table("products")->where(['id'=>$order['id']])->get()->getRowArray();
                        if($p['store_id'] != $coupon_data[0]['vendor_id']){
                            return ['success' => false, 'message' => 'Invalid Coupon code', 'order_id' => null];
                        }
                   }
                }else{
                    return ['success' => false, 'message' => 'Invalid Coupon code', 'order_id' => null];
                }
            }
            $response = (new OrderModel())->insertOrder($ip,$postdata,$orderCart);
            $ord = $response['order_id'];
            session()->set('order_metadata', $response);
            if($postdata['gateway'] == 'coupon_code'){
                $db->table("coupons")->set('is_used', 1)->set('used_at', date('Y-m-d H:i:s'))->where('coupon_code', $postdata['coupon_code'])->update();
                $db->table("spree")->where(['com_id' => $coupon_data[0]['com_id'], 'store_id' => $coupon_data[0]['vendor_id'] ])->delete();
            }
            if ( $postdata['gateway'] == 'creditcard') {
                get_cart_destroy();
                return ['success' => true, 'message' => 'Proceed to payment!', 'order_id' => $ord];        
            } else {
                return ['success' => false, 'message' => 'Invalid Request.', 'order_id' => null]; // COD disabled from now on.
                      
                // get_cart_destroy();
                // $this->setCheckoutSession();
                // return redirect()->to('/cart/thankyou');
            }
            // return redirect()->to('/dashboard');
        } else {
            return ['success' => false, 'message' => 'Cart is empty!'];
        }
    }

    /**
     * create intent for stripe payment
     * need to compelte
     */
    
     public function createPaymentIntent($order_id)
    {
        $user_email = (new RegisterModel())->getByIdResult(getUserId());
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
            'success_url' => base_url().'payments/success?order='.$this->request->getUri()->getSegment(3).'&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => base_url().'payments/cancel?order='.$this->request->getUri()->getSegment(3).'&session_id={CHECKOUT_SESSION_ID}',
            'metadata' => [
                'order' => json_encode(session()->get('order_metadata'))
            ],
        ]);
        return redirect()->to( $session->url );
    }
}

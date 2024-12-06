<?php
namespace App\Traits;
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
}

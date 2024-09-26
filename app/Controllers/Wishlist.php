<?php

namespace App\Controllers;

use App\Models\WishlistModel;

class Wishlist extends BaseController
{
    public function index()
    {
        // $data['homeslider'] = (new SliderModel())->getAllResult();
        // return view('site/home',$data);
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            if ( getUserId() == 0 ) {
                $data = ['error' => 1, 'msg' => 'Please login your account', '_cc' => csrf_hash()];
                return json_encode($data);
            } else {
                $wishlist = new WishlistModel();
                $post = $this->request->getPost();
                if ( my_decrypt($post['ss']) == 1 ) {
                    $store_id = my_decrypt($post['ss']);
                } else {
                    $store_id = uuid_decode(my_decrypt($post['ss']));
                    $store_id = $store_id['valueId'];
                }
                // print_r($wishlist->checkWishList( $store_id,my_decrypt($post['dd']),getUserId() ));
                // die();
                if ( $wishlist->checkWishList( $store_id,my_decrypt($post['dd']),getUserId() ) == false ) {
                    $wishlist->add(['product_id' => my_decrypt($post['dd']),'store_id' => $store_id,'user_id' => getUserId() , 'created_at' => date('Y-m-d H:i:s')]);
                    $data = ['error' => 2, 'msg' => 'Product successfully added in your wishlist', '_cc' => csrf_hash()];
                    return json_encode($data);
                } else {
                    $data = ['error' => 3, 'msg' => 'Product already Added in your wishlist', '_cc' => csrf_hash()];
                    return json_encode($data);
                }
            }
        } else {
            return redirect()->to('/');
        }
    }
    
}

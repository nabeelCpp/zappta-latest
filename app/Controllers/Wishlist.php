<?php

namespace App\Controllers;

use App\Models\WishlistModel;
use App\Traits\CustomerTrait;

class Wishlist extends BaseController
{
    use CustomerTrait;
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
                $product_id = my_decrypt($post['dd']);
                return json_encode(CustomerTrait::addItemToWishList($store_id, $product_id));
            }
        } else {
            return redirect()->to('/');
        }
    }
    
}

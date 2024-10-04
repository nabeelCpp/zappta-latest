<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\WishlistModel;
use App\Traits\CustomerTrait;

class Wishlist extends BaseController
{
    use CustomerTrait;
    
    public function index()
    {
        $data = CustomerTrait::wishlist();
        $data['pagetitle'] = 'List';
        $data['pager'] = service('pager');
        return view('dashboard/wishlist/index',$data);
        // print '<pre>';
        // print_r($data['wishlist']);
        // print '</pre>';
    }
    
    public function remove()
    {
        $id = my_decrypt($this->request->getUri()->getSegment(4));
        $response = CustomerTrait::removeWishlist($id);
        $this->session->setFlashdata('error', $response['msg']);
        return redirect()->to('/dashboard/wishlist'); 
    }

}

<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\WishlistModel;

class Wishlist extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'List';
        $data['total_list'] = (new WishlistModel())->getUserTotalList();
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['wishlist'] = (new WishlistModel())->getUserOrderList($data['page']);
        $data['pager'] = service('pager');
        return view('dashboard/wishlist/index',$data);
        // print '<pre>';
        // print_r($data['wishlist']);
        // print '</pre>';
    }
    
    public function remove()
    {
        $ids = my_decrypt($this->request->getUri()->getSegment(4));
        (new WishlistModel())->deleteR($ids);
        $this->session->setFlashdata('error', 'Product successfully delete from wishlist');
        return redirect()->to('/dashboard/wishlist'); 
    }

}

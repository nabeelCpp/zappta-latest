<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
class Spree extends BaseController
{
    
    public function index()
    {
        $db = \Config\Database::connect();
        $data['pagetitle'] = 'Spree';
        $sprees = (new ProductsModel())->getUserSprees();
        $arr = [];
        foreach ($sprees as $key => $value) {
            $arr[$value['compain_name']]['compain_s_date'] = $value['compain_s_date'];
            $arr[$value['compain_name']]['compain_e_date'] = $value['compain_e_date'];
            $arr[$value['compain_name']]['stores'][$value['store_name']][] = $value;
        }
        $data['sprees'] = $arr;
        $data['coupons'] = $db->table("coupons")->where(['user_id' => getUserId()])->get()->getResult();
        // dd($data);
        return view('dashboard/giveaway/spree',$data);
    }

    public function remove()
    {
        if(!isset($_GET['id'])){
            return redirect()->to(base_url('dashboard/spree'));
        }
        $id = my_decrypt($_GET['id']);
        $spree = (new ProductsModel())->removeProductFromSpree($id);
        if($spree){
            $this->session->setFlashdata('success', 'Product deleted from spree successfully!');
        }else{
            $this->session->setFlashdata('error', 'Error while deleting product from spree!');
        }
        return redirect()->to(base_url('dashboard/spree'));
    }
    
}

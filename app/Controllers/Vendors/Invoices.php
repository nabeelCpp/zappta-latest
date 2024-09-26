<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use App\Models\VendorModel;

class Invoices extends BaseController
{
    public function index()
    {
        $data['pagetitle'] = 'Dashboard';
        $data['getTotalAccount'] = (new VendorModel())->getTotalAccount();
        // echo '<pre>';
        // print_r($data['getTotalAccount']);
        // echo '</pre>App';
        // die();
        return view('vendors/invoices/index',$data);
    } 
       
}
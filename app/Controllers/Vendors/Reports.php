<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use App\Models\VendorModel;

class Reports extends BaseController
{
    // public function index()
    // {
    //     $data['pagetitle'] = 'Dashboard';
    //     return view('vendors/reports/index',$data);
    // }    
     public function index()
    {
        $data['pagetitle'] = 'Dashboard';
        $data['getTotalAccount'] = (new VendorModel())->getTotalAccountForReport();
        // echo '<pre>';
        // print_r($data['getTotalAccount']);
        // echo '</pre>App';
        // die();
        return view('vendors/reports/index',$data);
    }    
}
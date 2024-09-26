<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;

use App\Models\VendorModel;

class Home extends BaseController
{
    public function index()
    {
        $data['pagetitle'] = 'Dashboard';
        $data['stats'] = (new VendorModel())->getOrderStats();
        $data['getChartData'] = (new VendorModel())->getChartData();
        $data['getSalesData'] = (new VendorModel())->getsalesData();
        return view('vendors/index',$data);
    }    
}
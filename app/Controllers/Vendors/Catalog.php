<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;

class Catalog extends BaseController
{
    public function index()
    {
        $data['pagetitle'] = 'Dashboard';
        return view('vendors/index',$data);
    }    
}
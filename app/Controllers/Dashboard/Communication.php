<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Communication extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Communication';
        return view('dashboard/communication/index',$data);
    }
    
}

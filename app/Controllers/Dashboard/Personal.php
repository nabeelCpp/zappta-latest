<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Personal extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Personal';
        return view('dashboard/personal/index',$data);
    }
    
}

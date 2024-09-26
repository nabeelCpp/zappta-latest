<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Terms extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Terms';
        return view('dashboard/terms/index',$data);
    }
    
}

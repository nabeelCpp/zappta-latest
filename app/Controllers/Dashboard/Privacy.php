<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Privacy extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Privacy';
        return view('dashboard/privacy/index',$data);
    }
    
}

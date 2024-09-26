<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Help extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Help';
        return view('dashboard/help/index',$data);
    }
    
}

<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Reorder extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Reorder';
        return view('dashboard/reorder/index',$data);
    }
    
    
}

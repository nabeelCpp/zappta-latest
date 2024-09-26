<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Giveaway extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Registries';
        return view('dashboard/giveaway/index',$data);
    }
    
}

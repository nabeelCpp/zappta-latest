<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Traits\ZapptaTrait;

class Help extends BaseController
{
    use ZapptaTrait;
    
    public function index()
    {
        $data['pagetitle'] = 'Help';
        $data['faqs'] = ZapptaTrait::getFaqs();
        return view('dashboard/help/index',$data);
    }
    
}

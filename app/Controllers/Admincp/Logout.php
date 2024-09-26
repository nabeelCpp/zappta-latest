<?php

namespace App\Controllers\Admincp;

use App\Controllers\BaseController;

class Logout extends BaseController
{
    
	public function index()
	{
    	$session = \Config\Services::session();
    	$session->destroy();
    	return redirect()->to('/admincp/login');    
	}

}

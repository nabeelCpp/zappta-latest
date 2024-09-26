<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;

class Logout extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();
        unset($_SESSION['vendorIsLoggedIn']);
        session_destroy();
        return redirect()->to('/vendor-login');
    }    
}
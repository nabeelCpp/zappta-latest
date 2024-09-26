<?php

namespace App\Controllers\Admincp;

use App\Models\UsersModel;

class Login extends BaseController
{
    
    public function index()
    {
        return view('admin/login');
    }    

    public function auth()
    {
        $email = $this->request->getVar('user_email');
        $password = $this->request->getVar('user_password');
        $_redirect_url = $this->request->getVar('_redirect_url');
        if ( $email == "" || $password == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to('/admincp/login?red='.$_redirect_url);
        }
        if ( !valid_email($email) ) {
            $this->session->setFlashdata('error', 'Please enter valid email');
            return redirect()->to('/admincp/login?red='.$_redirect_url);
        }

        (new UsersModel())->login_verify($email,$password);
        if( session()->get('isLoggedIn') ) {
            return redirect()->to($_redirect_url);
        } else {
            $this->session->setFlashdata('error', 'Invalid Email / Password');
            return redirect()->to('/admincp/login?red='.$_redirect_url);
        }
    }

}

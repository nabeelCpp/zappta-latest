<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use App\Models\ContactModel;

class Contact extends BaseController
{

    protected $ContactModel;

    public function index()
    {
       $data['pagetitle'] = 'Dashboard';
        return view('vendors/contact/index' ,$data);
    }
        public function ajaxcontact(){
        $this->ContactModel = new ContactModel();
         if ($this->request->isAJAX()) {
         $name = filtreData($this->request->getVar('name'));
         $email = filtreData($this->request->getVar('email'));
         $message = filtreData($this->request->getVar('message'));
        echo $id = $this->ContactModel->AddContactDetails($name,$email,$message);
         }
        
        
    }


}
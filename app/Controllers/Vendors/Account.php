<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;

use App\Models\VendorModel;

class Account extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Dashboard';
        $data['user_data'] = (new VendorModel())->findByUserId();
        return view('vendors/account/index',$data);
    }    

    public function save()
    {
        $store_name = filtreData($this->request->getVar('store_name'));
        $store_link = filtreData($this->request->getVar('store_link'));
        $store_order_email = filtreData($this->request->getVar('store_order_email'));
        $paypal_email = filtreData($this->request->getVar('paypal_email'));
        $store_status = filtreData($this->request->getVar('store_status'));
        (new VendorModel())->add(['id' => getVendorUserId() , 'store_name' => $store_name, 'store_link' => $store_link, 'store_order_email' => $store_order_email, 'store_status' => $store_status, 'paypal_email' => $paypal_email]);
        if ( $_FILES['store_logo']['size'] != 0 ) {
            $file = $this->request->getFile('store_logo');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            (new VendorModel())->add(['id' => getVendorUserId(),'store_logo' => $newName]);
        }
        $this->session->setFlashdata('success', 'Store detail successfully update');
        return redirect()->to('/vendors/account');
    }


    public function update()
    {
        $password = filtreData($this->request->getVar('password'));
        if ( !empty($password) ) {
            (new VendorModel())->add(['id' => getVendorUserId(),'password' => $password]);
            $this->session->setFlashdata('success', 'Password successfully update');
            return redirect()->to('/vendors/account');
        } else {
            $this->session->setFlashdata('error', 'Please enter password');
            return redirect()->to('/vendors/account');
        }
    }

}
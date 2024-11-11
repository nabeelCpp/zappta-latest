<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use App\Models\CarriersPreferenceModel;

class Shipping extends BaseController
{

    public function index()
    {
        $data['pagetitle'] = 'Dashboard';
        $data['sql'] = (new CarriersPreferenceModel())->getById();
        return view('vendors/shipping/index',$data);
    }    

    public function update()
    {
        $id = my_decrypt($this->request->getVar('_id'));
        $handlingcharges = $this->request->getVar('handlingcharges');
        $freeshipat = $this->request->getVar('freeshipat');
        $freeshipatweight = $this->request->getVar('freeshipatweight');
        if ( $id == 0 ) {
            (new CarriersPreferenceModel())->add(['handlingcharges' => $handlingcharges,'freeshipat' => $freeshipat,'freeshipatweight' => $freeshipatweight,'store_id' => getVendorUserId(), 'shipping_returns_msg' => $this->request->getVar('shipping_returns_msg')??null]);
        } else {
            (new CarriersPreferenceModel())->add(['id' => $id,'handlingcharges' => $handlingcharges,'freeshipat' => $freeshipat,'freeshipatweight' => $freeshipatweight,'store_id' => getVendorUserId(), 'shipping_returns_msg' => $this->request->getVar('shipping_returns_msg')??null]);
        }
        $this->session->setFlashdata('success', 'Shipping successfully added.');
        return redirect()->to('/vendors/shipping');
    }

}
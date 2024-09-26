<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Address;
class Addresses extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Addresses';
        $data['address'] = (new Address())->getAllResultByUser(getUserId(),20,2);
        return view('dashboard/addresses/index',$data);
    }
    
    public function remove()
    {
        $ids = $this->request->getUri()->getSegment(4);
        (new Address())->deleteRecord(my_decrypt($ids));
        $this->session->setFlashdata('success', 'Address successfully deleted');
        return redirect()->to('dashboard/addresses');
    }

}

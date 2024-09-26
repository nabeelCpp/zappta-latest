<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use App\Models\VendorModel;
use App\Models\CompainModel;

class Spree extends BaseController
{

    public function index()
    {
        $data['pagetitle'] = 'Spree';
        $data['sprees'] = (new VendorModel())->getSprees();
        $data['total_orders'] = (new VendorModel())->getSpreesVendorsTotal();
        return view('vendors/spree/index',$data);
    }    

    public function add()
    {
        $data['pagetitle'] = 'Spree';
        $data['compaigns'] = (new CompainModel())->getUpcomingCompaigns();
        if(empty($data['compaigns'])){
            return redirect()->to('/vendors/spree');
        }
        return view('vendors/spree/add',$data);
    }

    public function edit()
    {
        $ids = my_decrypt($this->request->getUri()->getSegment(4));
        $data['pagetitle'] = 'Edit Spree';
        $data['spree'] = (new VendorModel())->getSpreeById($ids);
        $data['compaigns'] = (new CompainModel())->getUpcomingCompaigns();
        if(empty($data['compaigns'])){
            return redirect()->to('/vendors/spree');
        }
        return view('vendors/spree/add',$data);
    }

    public function insert()
    {
        if(!$this->request->getVar('com_id')){
            $this->session->setFlashdata('error', 'Select Compaign to continue!');
            return redirect()->to('/vendors/spree/add');
        }
        if(!$this->request->getVar('price') || $this->request->getVar('price') <= 0){
            $this->session->setFlashdata('error', 'Provide spree price greater than 0');
            return redirect()->to('/vendors/spree/add');
        }
        // check if spree already exists
        $checkSpree = (new VendorModel())->checkIfSpreeAlreadyExist(my_decrypt($this->request->getVar('com_id')));
        if($checkSpree){
            $this->session->setFlashdata('error', 'You already enrolled in spree. Edit spree either!');
            return redirect()->to('/vendors/spree/edit/'.my_encrypt($checkSpree->id));
        }
        if ( $_FILES['cover']['size'] != 0 ) {
            $file = $this->request->getFile('cover');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media/spree';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            // (new VendorModel())->add(['id' => getVendorUserId(),'cover' => $newName]);
        }else{
            $this->session->setFlashdata('error', 'Select Spree Cover to continue!');
            return redirect()->to('/vendors/spree/add');
        }
        (new VendorModel())->insertSpree([
            'com_id' => my_decrypt($this->request->getVar('com_id')),
            'price' => $this->request->getVar('price'),
            'percentage_to_participants' => $this->request->getVar('percentage_to_participants'),
            'vendor_id' => getVendorUserId(),
            'cover' => $newName,
        ]);
        $this->session->setFlashdata('Success', 'Spree saved successfully!');
        return redirect()->to('/vendors/spree');
    }

    public function update()
    {
        $id = $this->request->getVar('_id');
        if(!$id){
            $this->session->setFlashdata('error', 'Invalid request!');
            return redirect()->to('/vendors/spree');
        }
        $spree = (new VendorModel())->getSpreeById(my_decrypt($id));
        if(!$spree){
            $this->session->setFlashdata('error', 'Invalid request!');
            return redirect()->to('/vendors/spree');
        }

        // if(!$this->request->getVar('com_id')){
        //     $this->session->setFlashdata('error', 'Select Compaign to continue!');
        //     return redirect()->to('/vendors/spree/edit/'.$id);
        // }
        if(!$this->request->getVar('price') || $this->request->getVar('price') <= 0){
            $this->session->setFlashdata('error', 'Provide spree price greater than 0');
            return redirect()->to('/vendors/spree/add');
        }
        if ( $_FILES['cover']['size'] != 0 ) {
            $file = $this->request->getFile('cover');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media/spree';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $update['cover'] = $newName;
        }
        // $update['com_id'] =  my_decrypt($this->request->getVar('com_id'));
        $update['price'] = $this->request->getVar('price');
        $update['percentage_to_participants'] = $this->request->getVar('percentage_to_participants');
        $update['updated_at'] = date('Y-m-d H:i:s');
        (new VendorModel())->updateSpree($update, my_decrypt($id));
        $this->session->setFlashdata('success', 'Spree updated successfully!');
        return redirect()->to('/vendors/spree');
    }

    public function trash()
    {
        $id = $this->request->getUri()->getSegment(4);
        if(!$id){
            $this->session->setFlashdata('error', 'Invalid request!');
            return redirect()->to('/vendors/spree');
        }
        $spree = (new VendorModel())->getSpreeById(my_decrypt($id));
        if(!$spree){
            $this->session->setFlashdata('error', 'Invalid request!');
            return redirect()->to('/vendors/spree');
        }
        if((new VendorModel())->deleteSpree(my_decrypt($id))){
            $this->session->setFlashdata('success', 'Spree successfully deleted.');
        }else{
            $this->session->setFlashdata('error', 'Error while deleting spree.');
        }
        return redirect()->to('/vendors/spree');

        
    }

}
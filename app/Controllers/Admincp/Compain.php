<?php

namespace App\Controllers\Admincp;

use App\Models\CompainModel;
use App\Models\VendorModel;

class Compain extends BaseController
{
    
    public function index()
    {
        $data['perm'] = perm('compain');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['sql'] = (new CompainModel())->getAllResult($data['page']);
        $data['total_result'] = (new CompainModel())->getAdminTotalResult();
        if ( $data['total_result'] > 20 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/compain/index',$data);
    }    

    public function add()
    {
        $data['perm'] = perm('compain');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        return view('admin/compain/add');
    }    

    public function insert()
    {
        $data['perm'] = perm('compain');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $compain_name = filtreData($this->request->getVar('compain_name'));
        $compain_s_date = filtreData($this->request->getVar('compain_s_date'));
        $compain_e_date = filtreData($this->request->getVar('compain_e_date'));
        $compain_msg = filtreDataText($this->request->getVar('compain_msg'));
        $compain_terms = filtreDataText($this->request->getVar('compain_terms'));
        $status = filtreData($this->request->getVar('status'));
        $email_notify = filtreData($this->request->getVar('email_notify'));
        $notification = filtreData($this->request->getVar('notification'));

        if ( $compain_name == "" || $compain_s_date == "" || $compain_e_date == "" ) {
            $this->session->setFlashdata('error','Please fill all required fields(*)');
            return redirect()->to('/admincp/compain/add');
        }
        (new CompainModel())->add([
                                    'compain_name' => $compain_name,
                                    'compain_s_date' => date('Y-m-d', strtotime($compain_s_date)),
                                    'compain_e_date' => date('Y-m-d', strtotime($compain_e_date)),
                                    'compain_msg' => $compain_msg,
                                    'compain_terms' => $compain_terms,
                                    'status' => $status,
                                    'email_notify' => $email_notify,
                                    'notification' => $notification,
                                    'active' => 1
                                ]);
        $this->session->setFlashdata('success','New Compain Successfully Created');
        return redirect()->to('/admincp/compain');
    }    

    public function edit()
    {
        $data['perm'] = perm('compain');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->editp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $data['c_id'] = my_decrypt($this->request->getUri()->getSegment(4));
        $data['sql'] = (new CompainModel())->find($data['c_id']);
        return view('admin/compain/edit',$data);
    }    

    public function update()
    {
        $data['perm'] = perm('compain');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->editp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $id = filtreData($this->request->getVar('id'));
        $compain_name = filtreData($this->request->getVar('compain_name'));
        $compain_s_date = filtreData($this->request->getVar('compain_s_date'));
        $compain_e_date = filtreData($this->request->getVar('compain_e_date'));
        $compain_msg = filtreDataText($this->request->getVar('compain_msg'));
        $compain_terms = filtreDataText($this->request->getVar('compain_terms'));
        $status = filtreData($this->request->getVar('status'));
        $email_notify = filtreData($this->request->getVar('email_notify'));
        $notification = filtreData($this->request->getVar('notification'));

        if ( $compain_name == "" || $compain_s_date == "" || $compain_e_date == "" ) {
            $this->session->setFlashdata('error','Please fill all required fields(*)');
            return redirect()->to('/admincp/compain/edit/'.my_encrypt($id));
        }
        (new CompainModel())->add([
                                    'id' => $id,
                                    'compain_name' => $compain_name,
                                    'compain_s_date' => date('Y-m-d', strtotime($compain_s_date)),
                                    'compain_e_date' => date('Y-m-d', strtotime($compain_e_date)),
                                    'compain_msg' => $compain_msg,
                                    'compain_terms' => $compain_terms,
                                    'status' => $status,
                                    'email_notify' => $email_notify,
                                    'notification' => $notification,
                                ]);
        $this->session->setFlashdata('success','New Compain Successfully Update');
        return redirect()->to('/admincp/compain');
    }    

    public function delete()
    {
        $data['perm'] = perm('compain');
        if ( $data['perm']->deletep == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $ids = $this->request->getUri()->getSegment(4);
        (new CompainModel())->add(['id' => $ids,'deleteStatus' => 1,'status' => 2]);
        $this->session->setFlashdata('success', 'Compain Successfully deleted');
        return redirect()->to('admincp/compain');
    }

    public function products()
    {
        $data['perm'] = perm('compain');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->view == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $data['c_id'] = my_decrypt($this->request->getUri()->getSegment(4));
        $data['sql'] = (new CompainModel())->find($data['c_id']);
        return view('admin/compain/products',$data);
    }    

    public function stores()
    {
        $data['perm'] = perm('compain');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->view == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $store_id = my_decrypt($this->request->getUri()->getSegment(4));
        // $data['sql'] = (new \App\Models\VendorModel())->where('status',2)
        //                                               ->where('deleteStatus',0)
        //                                               ->findAll();
        $data['sprees'] = (new VendorModel())->getSpreesToDisplayOnAdminCp($store_id);
        
        return view('admin/compain/stores',$data);
    }    

    public function invite()
    {
        $data['perm'] = perm('compain');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->editp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $data['c_id'] = my_decrypt($this->request->getUri()->getSegment(4));
        $data['sql'] = (new \App\Models\VendorModel())->where('status',2)
                                                      ->where('deleteStatus',0)
                                                      ->findAll();
        return view('admin/compain/invite',$data);
    }    

    public function emailsent()
    {
        $data['perm'] = perm('compain');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->editp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }

        $email = filtreData($this->request->getVar('email'));
        $compaign_id = filtreData($this->request->getVar('compaign_id'));
        return (new CompainModel())->sendCompainEmail($email,$compaign_id);
    }

    /**
     * Change status of a spree
     * @return json
     * @author M Nabeel Arshad
     */
    public function spreeStatus() {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        (new VendorModel())->updateSpree(['status' => (int)$status ? 0 : 1], $id);
        $csrftoken = csrf_hash();
        $return = ['csrf_token' => $csrftoken, 'message' => 'Status changed to '.(!(int)$status?'Active':'Inactive').' Successfully!'];
        return $this->response->setJSON($return);
    }

    // /**
    //  * @author M Nabeel Arshad
    //  */
    // public function editSpree()
    // {
    //     $ids = my_decrypt($this->request->getUri()->getSegment(4));
    //     $data['pagetitle'] = 'Edit Spree';
    //     $data['spree'] = (new VendorModel())->getSpreeById($ids, true);
    //     return view('admin/vendors/spree/add',$data);
    // }

    /**
     * Delete a spree based on id
     * @author M Nabeel Arshad
     */
    public function trashSpree() {
        $id = $this->request->getUri()->getSegment(4);
        if(!$id){
            $this->session->setFlashdata('error', 'Invalid request!');
            return redirect()->back();
        }
        $spree = (new VendorModel())->getSpreeById(my_decrypt($id), true);
        if(!$spree){
            $this->session->setFlashdata('error', 'Invalid request!');
            return redirect()->back();
        }
        if((new VendorModel())->deleteSpree(my_decrypt($id))){
            $this->session->setFlashdata('success', 'Spree successfully deleted.');
        }else{
            $this->session->setFlashdata('error', 'Error while deleting spree.');
        }
        return redirect()->back();

    }

}

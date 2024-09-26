<?php

namespace App\Controllers\Admincp;

use App\Models\RegisterModel;
use App\Models\VendorModel;
class Newsletter extends BaseController
{
    
    public function index()
    {
        $data['perm'] = perm('pages');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp'); 
            }
            return redirect()->to('/admincp'); 
        }
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['sql'] = (new RegisterModel())->getAdminAllResult($data['page']);
        $data['vendorEmails'] = (new VendorModel())->GetEmailsOfVendors();
        $data['total_result'] = (new RegisterModel())->countAdminAllResult();
        if ( $data['total_result'] > 20 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/newsletter/index',$data);
    }

    // public function delete()
    // {
    //     $id = $this->request->getVar('id');
    //     $fimg = $this->request->getVar('fimg');
    //     (new ProductsGalleryModel())->deleteSingleImage($id,$fimg);
    //     $this->session->setFlashdata('success', 'Email Successfully deleted');
    //     return redirect()->to('/admincp/newsletter');
    // }

}

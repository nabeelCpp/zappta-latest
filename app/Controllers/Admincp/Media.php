<?php

namespace App\Controllers\Admincp;

use App\Models\ProductsGalleryModel;

class Media extends BaseController
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
        $data['sql'] = (new ProductsGalleryModel())->getAllResult($data['page']);
        $data['total_result'] = (new ProductsGalleryModel())->getAdminTotalResult();
        if ( $data['total_result'] > 20 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/media/index',$data);
    }    

    public function delete()
    {
        $id = $this->request->getVar('id');
        $fimg = $this->request->getVar('fimg');
        (new ProductsGalleryModel())->deleteSingleImage($id,$fimg);
        $this->session->setFlashdata('success', 'Image Successfully deleted');
        return redirect()->to('/admincp/media');
    }

}

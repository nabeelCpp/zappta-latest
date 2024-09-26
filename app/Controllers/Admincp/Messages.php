<?php

namespace App\Controllers\Admincp;

use App\Models\NotificationModel;
use App\Models\ContactModel;

class Messages extends BaseController
{
    
    // public function index()
    // {
    //     $data['perm'] = perm('pages');
    //     if ( $data['perm']->allview == 0 ) {
    //         if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
    //             return redirect()->to('/admincp'); 
    //         }
    //         return redirect()->to('/admincp'); 
    //     }
    //     $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    //     $data['sql'] = (new NotificationModel())->getAdminAllResult($data['page']);
    //     $data['total_result'] = (new NotificationModel())->countAdminAllResult();
    //     if ( $data['total_result'] > 20 ) {
    //         $data['pager'] = service('pager');
    //     }
    //     return view('admin/messages/index',$data);
    // }

    public function index(){
        $data['name'] = (new ContactModel())->GetMessagesOfUsers();
        $data['total_result'] = count($data['name']);
         if ( $data['total_result'] > 14 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/messages/index',$data);
    }

    public function view()
    {
        //$data['name'] = (new ContactModel())->GetMessagesOfUsers();
         $id = $this->request->getUri()->getSegment(4);
          (new ContactModel())->set('read', 1)->where('id' , $id)->update();
         $data['record'] = (new ContactModel())->GetMessageofspecificusers($id);
        return view('admin/messages/view',$data);
    }

    public function delete()
    {
        $id = $this->request->getUri()->getSegment(4);
        (new ContactModel())->deleteA($id);
        $this->session->setFlashdata('success', 'Messages Successfully deleted');
        return redirect()->to('/admincp/messages');
    }

}

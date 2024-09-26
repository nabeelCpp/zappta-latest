<?php

namespace App\Controllers\Admincp;

use App\Models\StatsModel;
use App\Models\UsersModel;
use App\Models\ContactModel;
use App\Models\EmailModel;

class Home extends BaseController
{
    protected $pagesfeedback ;
    
    public function index()
    {
        $data['stats'] = new StatsModel();
        return view('admin/index',$data);
    } 

    public function emailTemplates()
    {
       $data['stats'] = new StatsModel();
        return view('admin/emailTemplates',$data);
    }

    public function saveEmailTemplate()
    {
        $StatsModel = new StatsModel;
        $req['content'] = $this->request->getVar('content');
        $req['title'] = $this->request->getVar('title');
        // $a = $StatsModel->saveEmailTemplate($req);
        // return json_encode($a);
    }

    public function profile()
    {
        $UserModel = new UsersModel;
        $data['admin'] = $UserModel->where(['id' => getAdminUserId()])->get()->getFirstRow();
        return view('admin/profile', $data);
    }

    public function updateProfile()
    {
        $UserModel = new UsersModel;
        if($UserModel->update(['id' => getAdminUserId()], $this->request->getPost())){
            $this->session->setFlashdata('success', 'Profile updated Successfully');
        }else{
            $this->session->setFlashdata('error', 'Error while updating profile');            
        }
        session()->set('isLoggedIn' , [ 'user_id' => getAdminUserId() , 'pid' => getAdminProfileId(), 'user_name' => $this->request->getVar('name_en') ]);
        return redirect()->back();
    }

    public function emailNotifications()
    {
        $ContactModel = new ContactModel;
        $response['count'] = $ContactModel->where('read', '0')->countAllResults();
        $response['notifications'] = $ContactModel->orderBy('id', 'desc')->limit(5)->get()->getResult();
        return $this->response->setJSON($response);
    }

    public function SendEmail(){
        if(isset($_POST['submit'])){
             $emailTo = $_POST['emails'];
             $emailSubject = $_POST['subject'];
             $emailbody = $_POST['emailbody'];
             $this->pagesfeedback = new EmailModel();
             if($this->pagesfeedback->SendEmailByAdmin($emailTo ,$emailSubject ,$emailbody )){
                $this->session->setFlashdata('success', 'Email sent Successfully');
             }else{
                $this->session->setFlashdata('error', 'Error wh');
             }
        }else{
            $this->session->setFlashdata('error', 'Error while sendssssing email');
        }
        return redirect()->back();
    }

}

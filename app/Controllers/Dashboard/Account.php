<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

use App\Models\RegisterModel;
use App\Models\EmailModel;
use App\Traits\CustomerTrait;

class Account extends BaseController
{
    use CustomerTrait;
    
    public function index()
    {
        $data['pagetitle'] = 'Account';
        $data['user'] = (new RegisterModel())->getByIdResult(getUserId());
        return view('dashboard/account/index',$data);
    }
    
    public function update()
    {
        $type = filtreData($this->request->getPost('type'));
        switch ($type) {
            case 1:
                    $dashUserName = filtreData($this->request->getPost('dashUserName'));
                    // code...
                    if ( $dashUserName == "" ) {
                        $data = ['error' => 1, 'msg' => 'Please enter your full name', '_cc' => csrf_hash()];
                        return json_encode($data);
                    } else {
                        (new RegisterModel())->add(['id' => getUserId() , 'fname' => $dashUserName]);
                        $data = ['error' => 2, 'msg' => 'Fullname successfully updated', '_cc' => csrf_hash()];
                        return json_encode($data);
                    }
                break;
            
            case 2:
                    // code...
                    $data['user_email'] = (new RegisterModel())->getByIdResult(getUserId());
                    if ( !empty($data['user_email']) ) {
                        (new EmailModel())->sendMail($data['user_email']['email'],'Account Verification','veirfication',$data);
                        $data = ['error' => 2, 'msg' => 'Verification link sent to your email.', '_cc' => csrf_hash()];
                        return json_encode($data);
                    }
                break;

            case 3:
                    // code...
                    $userePasswordInput = filtreData($this->request->getPost('userePasswordInput'));
                    if ( $userePasswordInput == "" ) {
                        $data = ['error' => 1, 'msg' => 'Please enter your password', '_cc' => csrf_hash()];
                        return json_encode($data);
                    } else {
                        (new RegisterModel())->add(['id' => getUserId() , 'password' => $userePasswordInput]);
                        $data = ['error' => 2, 'msg' => 'Password successfully updated', '_cc' => csrf_hash()];
                        return json_encode($data);
                    }
                break;
            default:
                // code...
                break;
        }
    }

    public function verification()
    {
        $data['user_email'] = filtreData($this->request->getVar('e'));
        $data['user_id'] = filtreData($this->request->getVar('key'));
        $user = (new RegisterModel())->getByIdResult(my_decrypt($data['user_id']));
        if ( !empty($user) && $user['email_verify'] == 1 ) {
            (new RegisterModel())->add(['id' => my_decrypt($data['user_id']),'email_verify' => 2]);
            $this->session->setFlashdata('success', 'Email successfully verified');
            return redirect()->to('/dashboard/account');
        } else {
            $this->session->setFlashdata('error', 'Invalid verification link');
            return redirect()->to('/dashboard/account');
        }
    }

    public function savePhone()
    {
        $RegisterModel = new RegisterModel;
        $phone = $this->request->getVar('phone');
        if($RegisterModel->set('phone', $phone)->where('id', getUserId())->update()){
            $data = ['error' => false, 'msg' => 'Phone successfully updated', '_cc' => csrf_hash()];
        }else{
            $data = ['error' => true, 'msg' => 'Error while updating phone', '_cc' => csrf_hash()];
        }
        return $this->response->setJson($data);
    }

    public function updatePassword()
    {
        $current_pass = $this->request->getPost('current_pass');
        $new_pass = $this->request->getPost('new_pass');
        $confirm_pass = $this->request->getPost('confirm_pass');
        $data = CustomerTrait::updatePasswordTrait($current_pass, $new_pass, $confirm_pass);
        return json_encode($data);
    }

}

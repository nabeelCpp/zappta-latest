<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\VendorModel;
use App\Models\RegisterModel;
use App\Models\Setting;
use App\Models\UsersModel;
use App\Traits\UserTrait;
use Carbon\Carbon;

class Register extends BaseController
{
    use UserTrait;
    public function __construct() {
        if(session()->get('userIsLoggedIn')) {
            header('Location: /dashboard');exit;
        }

        if(session()->get('vendorIsLoggedIn')) {
            header('Location: /vendor');exit;
        }
    }
    public function index()
    {
        return redirect()->to(base_url());
    }


    public function auth()
    {
        if ($this->request->isAJAX()) {
            $vEmail = filtreData($this->request->getVar('userEmail'));
            $vPassword = filtreData($this->request->getVar('userPassword'));
            $data = self::userLoginTrait($vEmail, $vPassword);
            return $this->response->setJSON($data);
        } else {
            return redirect()->to('/');
        }
    }

    public function add()
    {
        if ($this->request->isAJAX()) {

            $vEmail = filtreData($this->request->getVar('userSignEmail'));
            $userSignusername = filtreData($this->request->getVar('userSignusername'));
            $vPassword = filtreData($this->request->getVar('userSignPassword'));
            $user_refer_token = filtreData($this->request->getVar('_user_refer_token'));
            $check_email_already_exists = (new RegisterModel())->findByEmail($vEmail);
            if ($check_email_already_exists) {
                $data = ['code' => (int)1, 'msg' => 'Email already Exist!', 'token' => csrf_hash()];
                return json_encode($data);
            }
            if ($vEmail == "" || $userSignusername == "" || $vPassword == "") {
                $data = ['code' => (int)1, 'msg' => 'Please fill all fields ( * )', 'token' => csrf_hash()];
                return json_encode($data);
            } elseif (!valid_email($vEmail)) {
                $data = ['code' => (int)1, 'msg' => 'Please enter valid email.', 'token' => csrf_hash()];
                return json_encode($data);
            } else if(countPasswordCharacters($vPassword) < 8){
                $data = ['code' => (int)1, 'msg' => 'Password must be at least 8 characters.', 'token' => csrf_hash()];
                return json_encode($data);
            } else {
                $arr = [
                    'email' => $vEmail,
                    'username' => $userSignusername,
                    'password' => $vPassword,
                    'referred_by' => $user_refer_token
                ];
                return response()->setJSON($this->customerRegisterTrait($arr));
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function vendor()
    {
        if (getUserId() != 0) {
            return redirect()->to(base_url());
        }
        $data['pagetitle'] = 'Vendor Registration';
        return view('site/register/vendor', $data);
    }

    public function vendorlogin()
    {
        if (getUserId() != 0) {
            return redirect()->to(base_url());
        }
        $data['pagetitle'] = 'Vendor Login';
        return view('site/register/vendorlogin', $data);
    }

    public function vendoradd()
    {
        if ($this->request->isAJAX()) {

            $vEmail = filtreData($this->request->getVar('vEmail'));
            $vStoreName = filtreData($this->request->getVar('vStoreName'));
            $vStoreLink = filtreData($this->request->getVar('vStoreLink'));
            $vPassword = filtreData($this->request->getVar('vPassword'));
            $vConfirmPassword = filtreData($this->request->getVar('vConfirmPassword'));

            if ($vEmail == "" || $vStoreName == "" || $vPassword == "" || $vConfirmPassword == "") {
                $data = ['code' => (int)1, 'msg' => 'Please fill all fields ( * )', 'token' => csrf_hash()];
                return json_encode($data);
            } elseif (!valid_email($vEmail)) {
                $data = ['code' => (int)1, 'msg' => 'Please enter valid email.', 'token' => csrf_hash()];
                return json_encode($data);
            } elseif ($vPassword !== $vConfirmPassword) {
                $data = ['code' => (int)1, 'msg' => 'Password & Confirm Password is not equal.', 'token' => csrf_hash()];
                return json_encode($data);
            } elseif ((new VendorModel())->findByEmail($vEmail) > 0) {
                $data = ['code' => (int)1, 'msg' => 'Email already exists, Please choose another email.', 'token' => csrf_hash()];
                return json_encode($data);
            } else {
                $data = [
                    'email' => $vEmail,
                    'store_name' => $vStoreName,
                    'store_slug' => (new VendorModel())->addStoreSlug(url_title($vStoreName, '-', true)),
                    'store_link' => $vStoreLink,
                    'password' => $vPassword
                ];
                (new VendorModel())->add($data);
                $data = ['code' => (int)2, 'msg' => 'Thanks for Registering!', 'token' => csrf_hash()];
                return json_encode($data);
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function vendorverify()
    {
        if ($this->request->isAJAX()) {

            $vEmail = filtreData($this->request->getVar('userEmail'));
            $vPassword = filtreData($this->request->getVar('userPassword'));

            if ($vEmail == "" || $vPassword == "") {
                $data = ['code' => (int)1, 'msg' => 'Please fill all fields ( * )', 'token' => csrf_hash()];
                return json_encode($data);
            } elseif (!valid_email($vEmail)) {
                $data = ['code' => (int)1, 'msg' => 'Please enter valid email.', 'token' => csrf_hash()];
                return json_encode($data);
            } else {
                (new VendorModel())->login_verify($vEmail, $vPassword);
                if (session()->get('vendorIsLoggedIn')) {
                    $data = ['code' => (int)2, 'msg' => 'Login Successfully', 'token' => csrf_hash()];
                    return json_encode($data);
                } else {
                    $data = ['code' => (int)1, 'msg' => 'Invalid Email / Password', 'token' => csrf_hash()];
                    return json_encode($data);
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function fb()
    {
        $code = filtreData($this->request->getVar('code'));
        $refer = filtreData($this->request->getVar('refer'));
        if (isset($code)) {
            $access_token = getFbAccessToken($code);
            if (isset($access_token)) {
                $user = getResponseFB(filtreData($access_token));
                if (!empty($user)) {
                    $name = $user['name'];
                    if ($refer !== 0) {
                        $user_token = decodeToken($refer);
                        (new \App\Models\Setting())->insertDollorFriend($user_token, 'ZAPPTA_INVITE_JOIN');
                    }
                    (new RegisterModel())->checkSocialAccountWeb($user['email'], $name, 'FB');
                    return redirect()->to('/dashboard');
                } else {
                    $this->session->setFlashdata('error', 'Invalid Email / Password.');
                    return redirect()->to('/?facebook=false&code=' . $code);
                }
            } else {
                $this->session->setFlashdata('error', 'Invalid access token.');
                return redirect()->to('/?facebook=false&code=' . $code);
            }
        } else {
            $this->session->setFlashdata('error', 'Invalid Code.');
            return redirect()->to('/?facebook=false&code=' . $code);
        }
    }

    public function google()
    {
        $code = filtreData($this->request->getVar('code'));
        $refer = filtreData($this->request->getVar('refer'));
        if (isset($code)) {
            $login = google_login_response($code);
            if (!empty($login['email'])) {
                $name = $login['givenName'] . ' ' . $login['familyName'];
                if ($refer !== 0) {
                    $user_token = decodeToken($refer);
                    (new \App\Models\Setting())->insertDollorFriend($user_token, 'ZAPPTA_INVITE_JOIN');
                }
                (new RegisterModel())->checkSocialAccountWeb($login['email'], $name, 'GO');
                return redirect()->to('/dashboard');
            } else {
                $this->session->setFlashdata('error', 'Invalid Email / Password.');
                return redirect()->to('/?google=false&code=' . $code);
            }
        } else {
            $this->session->setFlashdata('error', 'Invalid Email / Password.');
            return redirect()->to('/?google=false&code=' . $code);
        }
    }


    public function refer()
    {
        if ($this->request->isAJAX()) {

            $friendEmail = filtreData($this->request->getVar('friendEmail'));
            $friendMsg = filtreData($this->request->getVar('friendMsg'));
            $friendName = filtreData($this->request->getVar('friendName'));

            if ($friendEmail == "" || $friendMsg == "" || $friendName == "") {
                $data = ['code' => (int)1, 'msg' => 'Please fill all fields ( * )', 'token' => csrf_hash()];
                return json_encode($data);
            } elseif (!valid_email($friendEmail)) {
                $data = ['code' => (int)1, 'msg' => 'Please enter valid email.', 'token' => csrf_hash()];
                return json_encode($data);
            } else {
                if (getUserId() > 0) {
                    $data['user_data'] = [
                        'user_id' => generateToken(getUserId()),
                        'friendName' => $friendName,
                        'friendMsg' => $friendMsg,
                    ];
                    (new \App\Models\EmailModel())->sendMail($friendEmail, 'Refer A Friend', 'referemail', $data);
                    (new \App\Models\Setting())->insertDollorFriend(getUserId(), 'ZAPPTA_INVITE_FRIEND');
                    $data = ['code' => (int)2, 'msg' => 'Email successfully Sent', 'token' => csrf_hash()];
                    return json_encode($data);
                } else {
                    $data = ['code' => (int)1, 'msg' => 'Invalid Email / Password', 'token' => csrf_hash()];
                    return json_encode($data);
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function loginViaReferral($id)
    {
        if (getUserId()) {
            return redirect()->to('/');
        }
        $id = my_decrypt($id);
        if (is_numeric($id)) {
            $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
            $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
            $data['id'] = $id;
            $user = (new RegisterModel())->where(['id' => $id])->get()->getResult();
            $data['username'] = $user[0]->username;
            return view('site/register/referall-signup', $data);
        }

        return redirect()->to('/');
    }

    public function save()
    {
        $vEmail = filtreData($this->request->getVar('userSignEmail'));
        $userSignusername = filtreData($this->request->getVar('userSignusername'));
        $vPassword = filtreData($this->request->getVar('userSignPassword'));
        $referred_by = filtreData($this->request->getVar('user_refer'));
        $referred_by = my_decrypt($referred_by);
        $check_email_already_exists = (new RegisterModel())->findByEmail($vEmail);
        if ($check_email_already_exists) {
            $data = ['code' => (int)1, 'msg' => 'Email already Exist!'];
        }else{
            if ($vEmail == "" || $userSignusername == "" || $vPassword == "") {
                $data = ['code' => (int)1, 'msg' => 'Please fill all fields ( * )'];
                return json_encode($data);
            } elseif (!valid_email($vEmail)) {
                $data = ['code' => (int)1, 'msg' => 'Please enter valid email.'];
                return json_encode($data);
            } else if(countPasswordCharacters($vPassword) < 8){
                $data = ['code' => (int)1, 'msg' => 'Password must be at least 8 characters.', 'token' => csrf_hash()];
                return json_encode($data);
            } else {
                $ids = (new RegisterModel())->add(['email' => $vEmail, 'username' => $userSignusername, 'password' => $vPassword, 'referred_by' => $referred_by]);
                // Give 100Z to referred by user.
                $this->giveBalanceToReferredByUser($referred_by);
                if ($ids > 0) {
                    (new RegisterModel())->login_verify($vEmail, $vPassword);
                    if (session()->get('userIsLoggedIn')) {
                        (new Setting())->insertDollor('ZAPPTA_REGISTER', 'Regsiter', 3);
                        // if ( $user_refer_token !== 0 ) {
                        //     $user_token = decodeToken($user_refer_token);
                        //     (new \App\Models\Setting())->insertDollorFriend($user_token,'ZAPPTA_INVITE_JOIN');
                        // }
                        $data = [ 'code' => (int)2 , 'msg' => 'Signup Successfully' , 'redirect' => '/' ];
                       
                    } else {
                        $data = [ 'code' => (int)1 , 'msg' => 'Invalid Email / Password' ];
                        // return json_encode($data);
                    }
                } else {
                    $data = [ 'code' => (int)1 , 'msg' => 'There is some problem on creating account, please try again later.' ];
                    // return json_encode($data);
                }
            }
        }
        $data['token'] = csrf_hash();
        return response()->setJSON($data);
    }

    

    public function forgot() {
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        return view('site/register/forgot-password', $data);
    }

    public function reset() {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            $response['token'] = csrf_hash();
            return response()->setJSON($response);
        }
        $request = request()->getPost();
        $email = $request['email'];
        $data = UserTrait::forgotPasswordTrait($email);
        $response = ZapptaHelper::response($data['message'], [], $data['code']);
        $response['token'] = csrf_hash();
        return response()->setJSON($response);
    }

    public function verifyOtp() {
        $rules = [
            'email' => 'required|valid_email',
            'otp' => 'required|min_length[4]',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            $response['token'] = csrf_hash();
            return response()->setJSON($response);
        }
        $request = request()->getPost();
        $email = $request['email'];
        $otp = $request['otp'];
        $data = UserTrait::checkOtp($email, $otp);
        $response = ZapptaHelper::response($data['message'], [], $data['code']);
        $response['token'] = csrf_hash();
        return response()->setJSON($response);
    }

    public function changePassword() {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            $response['token'] = csrf_hash();
            return response()->setJSON($response);
        }
        $request = request()->getPost();
        $email = $request['email'];
        $password = $request['password'];
        $confirm_password = $request['confirm_password'];

        $data = UserTrait::resetPassword($email, $password, $confirm_password);
        $response = ZapptaHelper::response($data['message'], [], $data['code']);
        $response['token'] = csrf_hash();
        return response()->setJSON($response);
    }
}

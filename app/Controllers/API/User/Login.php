<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Models\RegisterModel;
use App\Traits\UserTrait;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
    use UserTrait, ResponseTrait;

    /**
     * User login
     */
    public function index()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $request = $this->request;
        $response = $this->userLoginTrait($request->getJsonVar('email'), $request->getJsonVar('password'), true);
        if($response['success']) {
            $response = self::sendOtpToPhone($response['user_id']);
        }else {
            $response = ZapptaHelper::response($response['msg'], [], $response['status']);
        }
    
        return $this->response->setJSON($response, $response['code']);
    }

    /**
     * Register customer via API
     * @author M Nabeel Arshad
     * @param Request $request
     * @return json
     */
    public function register() : object {
        $request = request();
        $rules = [
            'username' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[register.email]',
            'password' => 'required|min_length[8]',
            'fname' => 'required|min_length[3]',
            'phone' => 'required|min_length[10]|is_unique[register.phone]',
            'phone_code' => 'required',
        ];
        $messages = [
            'email' => [
                'is_unique' => 'This email is already registered. Please try another one.',
            ],
            'fname' => [
                'required' => 'First name is required.',
                'min_length' => 'First name must have at least 3 characters.'
            ],
            'phone' => [
                'is_unique' => 'This phone is already registered. Please try another one.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
            // return $this->fail($this->validator->getErrors(), 400);
        }
        $referred_by = filtreData($this->request->getGet('ref'));
        $referred_by = $referred_by ? my_decrypt($referred_by) : null;
        $arr = [
            'email' => $request->getVar('email'),
            'username' => $request->getVar('username'),
            'password' => $request->getVar('password'),
            'fname' => $request->getVar('fname'),
            'lname' => $request->getVar('lname'),
            'phone_code' => $request->getVar('phone_code') ?? null,
            'phone' => $request->getVar('phone'),
            'referred_by' => $referred_by,
        ];
        $response = $this->customerRegisterTrait($arr);
        if($response['success']) {
            $response = self::sendOtpToPhone($response['register_id'], $response['msg']);
        }else {
            $response =  $response = ZapptaHelper::response($response['msg'], [], 500);
        }
        return response()->setJSON($response);
    }

    /** 
     * Send OTP to phone
     * @param int $id
     * @return array
     * @method sendOtpToPhone
     * @access private
     * @author M Nabeel Arshad
     */
    private function sendOtpToPhone($id, $message = null) : array {
        (new \App\Models\RegisterModel())->find($id);
        $otp = rand(1000, 9999);
        $msg = "Your OTP is: $otp";
        $data['otp'] = $otp;
        $data['otp_time'] = time();
        (new \App\Models\RegisterModel())->update($id, $data);
        // return ZapptaHelper::sendSms($user['phone'], $msg, $otp);
        // return ZapptaHelper::response($message.' OTP sent to your phone!', []); // for production
        return ZapptaHelper::response($message.'OTP sent to your phone!', ['otp' => $otp]); // for testing

    }


    /**
     * Verify OTP
     * @return json
     * @author M Nabeel Arshad
     */
    public function verify() : object {
        $rules = [
            'email'    => 'required|valid_email',
            'otp' => 'required|min_length[4]',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $request = $this->request;
        $response = $this->checkOtp($request->getJsonVar('email'), $request->getJsonVar('otp'));
        if($response['success']) {
            (new RegisterModel())->setUserSession($response['customer'], true);
            $response = $this->tryLogin();
        }else {
            $response = ZapptaHelper::response($response['message'], [], 400);
        }
        return $this->response->setJSON($response, $response['code']);
    }

    /**
     * Try login via api!
     * @param string $email
     * @param string $password
     * @return array
     * @author M Nabeel Arshad
     * @method tryLogin
     */
    private function tryLogin() : array {
        if (session()->get('userIsLoggedIn')) {
            $user = session()->get('api_customer');
            // Generate JWT Token
            $jwtToken = ZapptaHelper::generateJwtToken($user);
            $resp = ['accesstoken' => $jwtToken, 'customer' => $user];
            $response = ZapptaHelper::response($msg ?? 'User Logged in successfully!', $resp);
        } else {
            $response = ZapptaHelper::response('Error while logging user in!', [], 400);
        }
        return $response;
    }

    /**
     * Check OTP
     * @param string $email
     * @param string $otp
     * @return array
     * @access private
     * @author M Nabeel Arshad
     */
    private function checkOtp($email, $otp) : array {
        $user = (new RegisterModel())->findByEmailId($email);
        if($user) {
            if($user['otp'] == $otp) {
                $data['phone_verify'] = $user['phone_verify'] = 1;
                $data['otp'] = $user['otp'] = null;
                $data['otp_time'] = $user['otp_time']= null;
                (new \App\Models\RegisterModel())->update($user['id'], $data);
                $response = ['customer' => $user, 'success' => true];
            }else {
                $response = ['message' => 'Invalid OTP!', 'success' => false];
            }
        }else {
            $response = ['message' => 'Invalid Email!', 'success' => false];
        }
        return $response;
    }

    /**
     * Forgot password
     * @return json
     * @method forgotPassword
     * @access public
     * @param Request $request
     * @return json
     * @access public
     * @method forgotPassword
     * @access public
     * @param Request $request
     * @return json
     */
    public function forgotPassword() : object {
        $rules = [
            'email'    => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $post = request()->getVar();
        $data = UserTrait::forgotPasswordTrait($post->email);
        $response = ZapptaHelper::response($data['message'], [], $data['code']);
        return response()->setJSON($response)->setStatusCode($data['code']);
    }

    /**
     * Verify OTP
     * @return json
     * @method verifyOtp
     * @access public
     * @param Request $request
     * @return json
     */
    public function verifyOtp() : object {
        $rules = [
            'email' => 'required|valid_email',
            'otp' => 'required|min_length[4]',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $request = request()->getVar();
        $email = $request->email;
        $otp = $request->otp;
        $data = UserTrait::checkOtp($email, $otp);
        $response = ZapptaHelper::response($data['message'], [], $data['code']);
        return response()->setJSON($response);
    }

    /**
     * Reset password
     * @return json
     * @method resetPassword
     * @access public
     * @param Request $request
     */
    public function resetPassword() : object {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $post = request()->getVar();
        $data = UserTrait::resetPassword($post->email, $post->password, $post->confirm_password);
        $response = ZapptaHelper::response($data['message'], [], $data['code']);
        return response()->setJSON($response);
    }
}

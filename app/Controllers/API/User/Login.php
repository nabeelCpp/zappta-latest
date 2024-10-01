<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
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
        $response = $this->tryLogin($request->getJsonVar('email'), $request->getJsonVar('password'));
       

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
            'password' => 'required|min_length[6]',
        ];
        $messages = [
            'email' => [
                'is_unique' => 'This email is already registered. Please use another one.',
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
            // return $this->fail($this->validator->getErrors(), 400);
        }

        $response = UserTrait::customerRegisterTrait($request->getVar('email'), $request->getVar('username'), $request->getVar('password'), $request->ref_token??null);
        if($response['success']) {
            $response = $this->tryLogin($request->getJsonVar('email'), $request->getJsonVar('password'), $response['msg']);
        }else {
            $response =  $response = ZapptaHelper::response($response['msg'], [], 500);
        }
        return response()->setJSON($response);
    }
    
    /**
     * Try login via api!
     * @param string $email
     * @param string $password
     * @return array
     * @author M Nabeel Arshad
     * @method tryLogin
     */
    private function tryLogin($email, $password, $msg = '') : array {
        $data = self::UserLoginTrait($email, $password, 'api');
        if (session()->get('userIsLoggedIn')) {
            $user = session()->get('api_customer');
            // Generate JWT Token
            $jwtToken = ZapptaHelper::generateJwtToken($user);
            $resp = ['accesstoken' => $jwtToken, 'customer' => $user];
            $response = ZapptaHelper::response('User Logged in successfully!', $resp);
        } else {
            $response = ZapptaHelper::response($data['msg'], [], $data['status']);
        }
        return $response;
    }
}

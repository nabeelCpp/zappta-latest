<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\UserTrait;
use CodeIgniter\API\ResponseTrait;

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
            return $this->respond(ZapptaHelper::response($this->validator->getErrors(), [], 400), 400);
        }
        $request = $this->request;
        $data = self::UserLoginTrait($request->getJsonVar('email'), $request->getJsonVar('password'), 'api');
        if (session()->get('userIsLoggedIn')) {
            $user = session()->get('api_customer');
            // Generate JWT Token
            $jwtToken = ZapptaHelper::generateJwtToken($user);
            $resp = ['accesstoken' => $jwtToken, 'customer' => $user];
            $response = ZapptaHelper::response('User Logged in successfully!', $resp);
        } else {
            $response = ZapptaHelper::response($data['msg'], [], $data['status']);
        }

        return $this->response->setJSON($response, $response['code']);
    }
}

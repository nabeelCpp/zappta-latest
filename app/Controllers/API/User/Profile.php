<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\CustomerTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Profile extends BaseController
{
    use CustomerTrait;
    public function index()
    {
        $customer = CustomerTrait::getLoggedInApiCustomer();
        $response = ZapptaHelper::response('Customer details fetched successfully!', $customer);
        return response()->setJSON($response);
    }
    
    /**
     * Update customer password
     * @return ResponseInterface
     */
    public function updatePassword()
    {
        $rules = [
            'current_pass' => 'required',
            'new_pass' => 'required|min_length[6]',
            'confirm_pass' => 'required|min_length[6]',
        ];
        $messages = [
            'current_pass' => [
                'required' => 'Current password is required',
            ],
            'new_pass' => [
                'required' => 'New password is required',
            ],
            'confirm_pass' => [
                'required' => 'Confirm password is required',
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $current_pass = request()->getVar('current_pass');
        $new_pass = request()->getVar('new_pass');
        $confirm_pass = request()->getVar('confirm_pass');
        $data = CustomerTrait::updatePasswordTrait($current_pass, $new_pass, $confirm_pass);
        $response = ZapptaHelper::response($data['msg'], [], $data['success'] ? 200 : 400);
        return response()->setJSON($response)->setStatusCode($response['code']);
    }
}

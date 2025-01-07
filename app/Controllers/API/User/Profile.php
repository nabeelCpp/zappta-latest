<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Models\RegisterModel;
use App\Traits\CustomerTrait;
use App\Traits\UserTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Profile extends BaseController
{
    use CustomerTrait, UserTrait;
    public function index()
    {
        $customer = CustomerTrait::getLoggedInApiCustomer();
        if($customer) {
            $customer->ref_link = $this->getReferralLink();
        }
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

    /**
     * Update customer profile
     * @return object
     * @author M Nabeel Arshad
     */
    public function update() : object {
        $customer = request()->customer;
        $register = new RegisterModel();
        $data = $this->request->getVar();
        $validationRules = [];
        $messages = [];
        if (isset($data->email)) {
            // Unique validation, excluding the current user's email
            $validationRules['email'] = "valid_email|is_unique[register.email,id,{$customer->id}]";
            $messages['email'] = [
                'is_unique' => 'The email has already been taken'
            ];
        }
        if (isset($data->fname)) {
            $validationRules['fname'] = 'alpha_space|min_length[3]|max_length[50]';
            $messages['fname'] = [
                'required' => 'First name is required.',
                'min_length' => 'First name must have at least 3 characters.'
            ];
        }
        if (isset($data->phone_code)) {
            $validationRules['phone_code'] = 'required';
        }
        if (isset($data->phone)) {
            $validationRules['phone'] = 'required|min_length[10]|is_unique[register.phone,id,{$customer->id}]';
            $messages['phone'] = [
                'is_unique' => 'This phone is already registered. Please try another one.'
            ];
        }
        if ($validationRules && !$this->validate($validationRules, $messages)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }

        // Update user data
        if ($register->update($customer->id, $data)) {
            $user = $register->find($customer->id);
            $register->setUserSession($user);
            $jwtToken = ZapptaHelper::generateJwtToken($user);
            $resp = ['accesstoken' => $jwtToken, 'customer' => $user];
            $response =  ZapptaHelper::response('Profile updated successfully', $resp, 200);
        } else {
            $response = ZapptaHelper::response('Failed to update profile', [], 500);
        }
        return response()->setJSON($response);
    }
    
    /**
     * Get customer notifications
     * @return ResponseInterface
     * @author M Nabeel Arshad
     */
    public function notifications() {
        $notifications = (new \App\Models\UsersNotification())->where('user_id', getUserId())->orderBy('id', 'DESC')->findAll(20);
        foreach ($notifications as $key => $value) {
            $notifications[$key]['notification'] = strip_tags($notifications[$key]['notification']);
        }
        $response = ZapptaHelper::response('Notifications fetched successfully!', $notifications);
        return response()->setJSON($response);
    }

    /**
     * Get customer referral link
     * @author M Nabeel Arshad
     */
    public function referral() {
        $referral_link = $this->getReferralLink();
        $response = ZapptaHelper::response('Referral link fetched successfully!', ['referral_link' => $referral_link]);
        return response()->setJSON($response);
    }

}

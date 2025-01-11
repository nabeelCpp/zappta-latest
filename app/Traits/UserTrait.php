<?php

namespace App\Traits;

use App\Models\RegisterModel;
use App\Models\Setting;
use App\Models\UsersModel;

trait UserTrait
{
    /**
     * User login script
     * @author M Nabeel Arshad
     * @param string $email
     * @param string $password
     * @return array
     */
    public static function userLoginTrait($email, $password, $api = false): array
    {
        $vEmail = filtreData($email);
        $vPassword = filtreData($password);
        if ($vEmail == "" || $vPassword == "") {
            $data = ['code' => (int)1, 'msg' => 'Please fill all fields ( * )', 'status' => 400, 'success' => false];
        } elseif (!valid_email($vEmail)) {
            $data = ['code' => (int)1, 'msg' => 'Please enter valid email.', 'status' => 400, 'success' => false];
        } else {
            (new RegisterModel())->login_verify($vEmail, $vPassword, $api);
            if (session()->get('userIsLoggedIn')) {
                (new Setting())->insertDollor('ZAPPTA_LOGIN', 'Login', 2);
                $data = ['code' => (int)2, 'msg' => 'Login Successfully', 'status' => 200, 'user_id' => session()->get('userIsLoggedIn')['user_id'], 'success' => true];
            } else {
                $data = ['code' => (int)1, 'msg' => 'Invalid Email / Password', 'status' => 400, 'success' => false];
            }
        }
        $data['token'] = csrf_hash();
        return $data;
    }

    /**
     * Register customer trait
     * @param string $email
     * @param array $user
     * @return array
     * @author M Nabeel Arshad
     */
    public function customerRegisterTrait($user): array
    {
        $ids = (new RegisterModel())->add($user);
        $this->giveBalanceToReferredByUser($user['referred_by']);
        if ($ids > 0) {
            (new RegisterModel())->login_verify($user['email'], $user['password']);
            if (session()->get('userIsLoggedIn')) {
                (new Setting())->insertDollor('ZAPPTA_REGISTER', 'Register', 3);
                // if (isset($user['user_refer_token']) && $user['user_refer_token'] !== 0) {
                //     $user_token = decodeToken($user['user_refer_token']);
                //     (new \App\Models\Setting())->insertDollorFriend($user_token, 'ZAPPTA_INVITE_JOIN');
                // }
                $data = ['code' => (int)2, 'msg' => 'Signup Successfully. ', 'token' => csrf_hash(), 'success' => true, 'register_id' => $ids];
                return $data;
            } else {
                $data = ['code' => (int)1, 'msg' => 'Invalid Email / Password', 'token' => csrf_hash(), 'success' => false];
                return $data;
            }
        } else {
            $data = ['code' => (int)1, 'msg' => 'There is some problem on creating account, please try again later.', 'token' => csrf_hash(), 'success' => false];
            return $data;
        }
    }

    public function giveBalanceToReferredByUser($id)
    {
        if($id) {
            $total_zap = (new Setting())->insertDollorFriend($id, 'ZAPPTA_INVITE_FRIEND');
            $link = '/dashboard/wallet';
            $api_link = '/customer/wallet';
            (new UsersModel())->saveNotification("You won {$total_zap} Zappta dollars bonus via your Referal link signup", $id, $link, 'referral', $api_link);
        }
    }
}

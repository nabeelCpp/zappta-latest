<?php

namespace App\Traits;

use App\Models\RegisterModel;
use App\Models\Setting;

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
            $data = ['code' => (int)1, 'msg' => 'Please fill all fields ( * )', 'status' => 400];
        } elseif (!valid_email($vEmail)) {
            $data = ['code' => (int)1, 'msg' => 'Please enter valid email.', 'status' => 400];
        } else {
            (new RegisterModel())->login_verify($vEmail, $vPassword, $api);
            if (session()->get('userIsLoggedIn')) {
                (new Setting())->insertDollor('ZAPPTA_LOGIN', 'Login', 2);
                $data = ['code' => (int)2, 'msg' => 'Login Successfully', 'status' => 200];
            } else {
                $data = ['code' => (int)1, 'msg' => 'Invalid Email / Password', 'status' => 400];
            }
        }
        $data['token'] = csrf_hash();
        return $data;
    }

    /**
     * Register customer trait
     * @param string $email
     * @param string $username
     * @param string $password
     * @param string|null $user_refer_token
     * @return array
     * @author M Nabeel Arshad
     */
    public static function customerRegisterTrait($email, $username, $password, $user_refer_token = null): array
    {
        $ids = (new RegisterModel())->add(['email' => $email, 'username' => $username, 'password' => $password]);
        if ($ids > 0) {
            (new RegisterModel())->login_verify($email, $password);
            if (session()->get('userIsLoggedIn')) {
                (new Setting())->insertDollor('ZAPPTA_REGISTER', 'Register', 3);
                if ($user_refer_token !== 0) {
                    $user_token = decodeToken($user_refer_token);
                    (new \App\Models\Setting())->insertDollorFriend($user_token, 'ZAPPTA_INVITE_JOIN');
                }
                $data = ['code' => (int)2, 'msg' => 'Signup Successfully', 'token' => csrf_hash(), 'success' => true];
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
}

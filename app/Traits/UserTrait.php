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
                (new Setting())->insertDollor('ZAPPTA_LOGIN','Login',2);
                $data = ['code' => (int)2, 'msg' => 'Login Successfully', 'status' => 200];
            } else {
                $data = ['code' => (int)1, 'msg' => 'Invalid Email / Password', 'status' => 400];
            }
        }
        $data['token'] = csrf_hash();
        return $data;
    }
}

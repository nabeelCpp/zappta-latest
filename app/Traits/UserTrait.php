<?php

namespace App\Traits;

use App\Models\RegisterModel;
use App\Models\Setting;
use App\Models\UsersModel;
use Carbon\Carbon;

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

    /**
     * Get user profile based on email for forgot password process
     * @param string $email
     * @return array {success: bool, message: string, code: int}
     * @author M Nabeel Arshad
     * @version 1.0.0
     * @since 2025-01-30
     */
    public static function forgotPasswordTrait(string $email) : ?array{
        $user = (new RegisterModel())->findByEmailId($email);
        if(!$user) {
            return ['success' => false, 'message' => 'Email not found!', 'code' => 400];
        }
        $otp = generateOtp(4);
        $data = [
            'otp' => $otp,
            'otp_time' => Carbon::now()->toDateTimeString(),
        ];
        (new RegisterModel())->update($user['id'], $data);
        $data['user'] = [
            ...$user,
            'otp' => $otp,
        ];
        (new \App\Models\EmailModel())->sendMail($email, 'Reset Password', 'resetpassword', $data);
        return ['success' => true, 'message' => 'OTP sent to your email!', 'code' => 200];
    }

    /**
     * Verify OTP
     * @param string $email
     * @param string $otp
     * @return array {success: bool, message: string, code: int}
     * @access public
     * @version 1.0.0
     * @since 2025-01-30
     * @author M Nabeel Arshad
     */
    public static function checkOtp(string $email, string $otp) : array {
        $user = (new RegisterModel())->findByEmailId($email);
        if(!$user) {
            return ['success' => false, 'message' => 'Email not found!', 'code' => 400];
        }
        if($user['otp'] != $otp) {
            return ['success' => false, 'message' => 'Invalid OTP!', 'code' => 400];
        }
        $otp_time = Carbon::parse($user['otp_time']);
        $now = Carbon::now();
        $diff = $now->diffInMinutes($otp_time);
        if($diff > 5) {
            return ['success' => false, 'message' => 'OTP expired!', 'code' => 400];
        }
        $data = [
            'otp' => null,
            'otp_time' => null,
        ];
        (new RegisterModel())->update($user['id'], $data);
        return ['success' => true, 'message' => 'OTP verified!', 'code' => 200];
    }

    /**
     * Reset password
     * @param string $email
     * @param string $password
     * @param string $confirm_password
     * @return array {success: bool, message: string, code: int}
     * @access public
     * @version 1.0.0
     * @since 2025-01-30
     * @author M Nabeel Arshad
     */
    public static function resetPassword(string $email, string $password, string $confirm_password) : array {
        $user = (new RegisterModel())->findByEmailId($email);
        if(!$user) {
            return ['success' => false, 'message' => 'Email not found!', 'code' => 400];
        }
        if($password != $confirm_password) {
            return ['success' => false, 'message' => 'Password and Confirm Password should be same!', 'code' => 400];
        }
        $data = [
            'password' => $password,
        ];
        (new RegisterModel())->update($user['id'], $data);
        return ['success' => true, 'message' => 'Password updated successfully!', 'code' => 200];
    }
}

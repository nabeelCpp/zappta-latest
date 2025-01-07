<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Setting;

class ZapptaHelper {

    public const CACHE_SECONDS = 1209600;

    const HASHING_ALGO = 'HS256';

    const ZAPPTA_TAX = '2.5%';

    /**
     * Customized response pattern for all API endpoints
     * @param 
     */
    public static function response( $message = null, $data=[], $code = 200, $meta = null, $media = null) {
        $return = [
            'success' => $code == 200 ? true : false,
            'code' => $code,
            'message' => !is_array($message) ? $message : $message,
            'response' => $data
        ];
        if($meta) {
            $return['meta'] = $meta;
        }
        if($media) {
            $return['media'] = base_url().'images/media/';
        }
        return $return;
    }

    /**
     * Create meta for large data requests
     * @param int $page
     * @param int $total
     * @param mixed $limit
     * @return array
     * @author M nabeel Arshad
     */
    public static function createMeta($page, $total, $limit = null) : array {
        return [
            "page"  => $page,
            "total" => $total,
            "limit" => $limit
        ];
    }

    /**
     * Make selected get parameters encrypted so that api logic got sync with web logic
     * @author M Nabeel Arshad
     * @return void
     */
    public static function makeSelectedGetParamsEncrypt($variables) : void {
        foreach ($variables as $key => $g) {
            if(isset($_GET[$g])) {
                $arr = [];
                foreach(explode(',', $_GET[$g]) as $f ) {
                    $arr[] = my_encrypt($f);
                }
                $_GET[$g] = implode('|', $arr);
            }
        }
    }

    /**
     * modified old themes css to be campatible with new design
     * @author M nabeel Arshad
     * @return string
     * @deprecated
     */
    public static function loadModifiedThemeCss() : string {
        return "<link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url() . "/theme/css/theme_modified.css\">";
    }

    /**
     * Load new design assets url
     * @return string
     * @author M nabeel Arshad
     */
    public static function loadAssetsUrl() : string {
        return base_url('/new-landing/assets');
    }

    /**
     * Get zappta global settings
     * @return string
     * @author M Nabeel Arshad
     */
    public static function getGlobalSettings($fields = []) : array {
        if ( ! cache()->get('getGlobalSettings') ) {
            cache()->save('getGlobalSettings',(new Setting())->orderBy('id', 'ASC')->get()->getResultArray(), self::CACHE_SECONDS);
        }
        if(count($fields) > 0 ) {
            $settings = cache()->get('getGlobalSettings');
            $return = [];
            foreach($settings as $setting) {
                if(in_array($setting['var_name'], $fields)) {
                    $return[] = $setting;
                }
            }
            return $return;
        }
        return cache()->get('getGlobalSettings');


        // $globalSettings = (new \App\Models\Setting())->orderBy('id', 'ASC');
        // if(count($fields)) {
        //     $globalSettings = $globalSettings->GetValues($fields);
        // }else {
        //     $globalSettings = $globalSettings->get()->getResultArray();
        // }
        // return $globalSettings;
    }

    /**
     * Load Dashboard css links
     * @return string
     * @author M Nabeel Arshad
     */
    public static function loadDashboardCss() : string {
        $currenturl = str_replace(base_url(), '', current_url());
        $arr = explode('/', $currenturl);
        $arr = array_values(array_filter($arr, function($a) {
            return $a != '';
        }));
        if(isset($arr[0]) && $arr[0] ) {
            return '<link rel="stylesheet" type="text/css" href="'.base_url() . '/theme/css/dashboard_.css"><link rel="stylesheet" type="text/css" href="'.base_url() . '/theme/css/responsive-.css">';
        }
        return '';
    }
    
    /**
     * Generate JWT token for user
     * @param object $user
     * @return string
     * @author M nabeel Arshad
     */
    public static function generateJwtToken($user) : string {
        $jwtPayload = [
            'iat' => time(), // Issued at
            'exp' => time() + 60*60*24*30, // Token expiration time (1 hour)
            'customer' => $user
        ];
        $jwtToken = self::encodeJwtToken($jwtPayload);
        return $jwtToken;
    }

    /**
     * @author M Nabeel Arshad
     * Encode JWT token
     * @param array $jwtPayload
     * @return string
     * @method encodeJwtToken
     */
    public static function encodeJwtToken($jwtPayload) : string {
        return JWT::encode($jwtPayload, getenv('JWT_SECRET_KEY'), self::HASHING_ALGO);
    }

    /**
     * Decode JWT token
     * @author M Nabeel Arshad
     * @method decodeJwtToken
     * @param string $token
     * @return object
     */
    public static function decodeJwtToken($token) : object {
        return JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'), self::HASHING_ALGO));
    }
}
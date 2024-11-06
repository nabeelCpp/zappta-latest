<?php

use App\Helpers\ZapptaHelper;

function uuid_creat($values)
{
    return (new \App\Libraries\Uuid())->generate_uuid($values);
}

function uuid_decode($values)
{
    return (new \App\Libraries\Uuid())->decode_uuid($values);
}

function uuid_product()
{
    return (new \App\Libraries\Uuid())->generate_uuid_product();
}

function uuid_product_decode($values)
{
    return (new \App\Libraries\Uuid())->generate_uuid_product($values);
}

function valid_email($str)
{
    if (function_exists('idn_to_ascii') && defined('INTL_IDNA_VARIANT_UTS46') && preg_match('#\A([^@]+)@(.+)\z#', $str, $matches)) {
        $str = $matches[1] . '@' . idn_to_ascii($matches[2], 0, INTL_IDNA_VARIANT_UTS46);
    }
    return (bool) filter_var($str, FILTER_VALIDATE_EMAIL);
}

function filtreData($data)
{
    return trim(strip_tags($data));
}

function filtreDataText($data)
{
    return trim(htmlentities($data));
}

function imageSize()
{
    return [
               100,
               250,
               350,
               600, 
               1280,
               1980, 
            ];
}

function getUrlSegment()
{
    $uri = service('uri');
    if(is_array($uri->getSegments()) && count($uri->getSegments())){
        if( count($uri->getSegments()) > 1 ) {
            return [ 0 => $uri->getSegments()[1] ];
        } else {
            return [ 0 => 'home' ];
        }
    } else {
        return [ 0 => '' ];
    }
}

function getCurrentUrl()
{   
    $uri = service('uri');
    return $uri->getSegments();
}

function imageThumb($path,$dir,$filename)
{
    $image = \Config\Services::image();
    foreach ( imageSize() as $size ) {
        $image->withFile($path);
        if ( $size == 1280 || $size == 1980 ) {
            $image->resize($size, $size,true);
            $image->save($dir.'/'.$size.'-'.$size.'-'.$filename,100);
        } else {
            $image->resize($size, $size,true, 'height');
            $image->save($dir.'/'.$size.'-'.$size.'-'.$filename,50);
        }
    }   
    $image->withFile($path);
    $image->resize(1980, 780,true);
    $image->save($dir.'/'.$filename,100);
}

function removeImage($dir,$filename)
{
    foreach ( imageSize() as $size ) {
        if ( file_exists ( './upload/'.$dir.'/'.$size.'-'.$size.'-'.$filename ) ) {
            unlink('./upload/'.$dir.'/'.$size.'-'.$size.'-'.$filename);
        }
    }
    if ( file_exists ('./upload/'.$dir.'/'.$filename ) ) {
        unlink('./upload/'.$dir.'/'.$filename);
    }
}

function show_message()
{
    $session = \Config\Services::session();
    if ( $session->getFlashdata('success') ) { 
        return '<div class="alert alert-success"><strong>'.$session->getFlashdata('success').'</strong></div>';
    } elseif( $session->getFlashdata('error') ) {
        return '<div class="alert alert-danger"><strong>'.$session->getFlashdata('error').'</strong></div>';
    }
}

function getImageThumg($dir,$filename,$size)
{
    $path = "upload/$dir/$size-$size-$filename";
    return file_exists($path) && is_file($path) ? base_url().$path : base_url()."upload/img-not-found.jpg";
}

function getImageFull($dir,$filename)
{
    $path = "upload/$dir/$filename";
    return file_exists($path) && is_file($path) ? base_url().$path : base_url()."upload/media/1723736066_00efe961f828f10c94ad.jpeg";
}

function getAdminUserId()
{
    if(session()->get('isLoggedIn')){
        $session = session()->get('isLoggedIn');
        return $session['user_id'];
    } else {
        return 0;
    }
}

function getAdminProfileId()
{
    if(session()->get('isLoggedIn')){
        $session = session()->get('isLoggedIn');
        return $session['pid'];
    } else {
        return 0;
    }
}

function getAdminUserName()
{
    if(session()->get('isLoggedIn')){
        $session = session()->get('isLoggedIn');
        return $session['user_name'];
    } else {
        return 0;
    }
}

function getAdminMenuPerm()
{
    return (new \App\Models\PermissionModel())->getResultById(getAdminProfileId());
}

function perm($right)
{
    return (new \App\Models\PermissionModel())->getResultByRights(getAdminProfileId(),$right);
}

function getUserId()
{
    if($customer = \App\Traits\CustomerTrait::getLoggedInApiCustomer()) {
        return $customer->id;
    } elseif(session()->get('userIsLoggedIn')){
        $session = session()->get('userIsLoggedIn');
        return $session['user_id'];
    }  else {
        return 0;
    }
}

function getUserName()
{
    if(session()->get('userIsLoggedIn')){
        $session = session()->get('userIsLoggedIn');
        return ucfirst($session['username']);
    } else {
        return 0;
    }
}

function getVendorUserId()
{
    if(session()->get('vendorIsLoggedIn')){
        $session = session()->get('vendorIsLoggedIn');
        return $session['user_id'];
    } else {
        return 0;
    }
}

function getVendorUserName()
{
    if(session()->get('vendorIsLoggedIn')){
        $session = session()->get('vendorIsLoggedIn');
        return ucfirst($session['user_name']);
    } else {
        return 0;
    }
}


function my_encrypt($string, $key="zappta", $url_safe=TRUE)
{
    return strtr(base64_encode($string.'|'.$key), '+/=', '._-');
}


function my_decrypt($string, $key="zappta")
{
    $data = base64_decode(strtr($string.'|'.$key, '._-', '+/='));
    $data = explode('|',$data);
    return $data[0];
}


function short($string,$word){
    $html = html_entity_decode($string);
    $htmls = preg_replace("/\r\n|\r|\n/", ' ', trim($html));
    $replace = str_replace(array("\n", "\r"), '', $htmls);
    $return = strip_tags($replace);
    $result = substr($return, 0,$word);
    if(strlen($return) > $word){
        return ucfirst($result) . '...';
    } else {
        return ucfirst($result);
    }
}

function vendorStatus($status)
{
    switch ($status) {
        case 1:
                return '<span class="badge bg-primary">New Request</span>';
            break;

        case 2:
                return '<span class="badge bg-secondary">Active</span>';
            break;
        
        case 3:
                return '<span class="badge bg-warning text-dark">Block</span>';
            break;

        case 4:

            break;
    }
}

function customerStatus($status)
{
    switch ($status) {
        case 1:
                return '<span class="badge bg-primary">Active</span>';
            break;

        case 2:
                return '<span class="badge bg-warning">Block</span>';
            break;
        
        case 3:
                return '<span class="badge bg-warning text-dark">Block</span>';
            break;

        case 4:

            break;
            default:
            return '<span class="badge bg-danger">De Activate</span>';

    }
}

function getAttributeType($status)
{
    switch ($status) {
        case 1:
                return '<span class="badge bg-primary">Size</span>';
            break;

        case 2:
                return '<span class="badge bg-secondary">Color</span>';
            break;
        
        case 3:
                return '<span class="badge bg-warning text-dark">Dimension</span>';
            break;

        case 4:
                return '<span class="badge bg-success">Paper Type</span>';
            break;
    }
}

function productConditionStatus($status)
{
    switch ($status) {
        case 1:
                return '<span class="badge bg-primary">New</span>';
            break;

        case 2:
                return '<span class="badge bg-secondary">Used</span>';
            break;
        
        case 3:
                return '<span class="badge bg-warning text-dark">Refurbished</span>';
            break;
    }
}

function orderCartOnAdminStatus($status)
{
    switch ($status) {
        case 1:
                return '<span class="badge bg-primary">Pending</span>';
            break;

        case 2:
                return '<span class="badge bg-secondary">Inprocessing</span>';
            break;
        
        case 3:
                return '<span class="badge bg-warning text-dark">Shipped</span>';
            break;

        case 4:
                return '<span class="badge bg-success">Delivered</span>';
            break;

        case 5:
                return '<span class="badge bg-info text-dark">Returned</span>';
            break;

        case 6:
                return '<span class="badge bg-danger">Canceled</span>';
            break;
            
        default:
                return '<span class="badge bg-primary">Pending</span>';
            break;
    }
}

function orderCartOnStatusCode($status)
{
    switch ($status) {
        case 'Pending':
                return 1;
            break;

        case 'Inprocessing':
                return 2;
            break;
        
        case 'Shipped':
                return 3;
            break;

        case 'Delivered':
                return 4;
            break;

        case 'Returned':
                return 5;
            break;

        case 'Canceled':
                return 6;
            break;
            
        default:
                return 7;
            break;
    }
}

function buildTree(Array $data, $parent = 0) {
    $tree = array();
    foreach ($data as $d) {
        if ($d['parent_id'] == $parent) {
            $children = buildTree($data, $d['id']);
            // set a trivial key
            if (!empty($children)) {
                $d['_children'] = $children;
            }
            $tree[] = $d;
        }
    }
    return $tree;
}

function buildTreeForVendor(Array $data, $parent = 0) {
    $tree = array();
    foreach ($data as $d) {
        if ($d['parent_id'] == $parent) {
            $children = buildTreeForVendor($data, $d['value']);
            // set a trivial key
            if (!empty($children)) {
                $d['childrens'] = $children;
            }
            $tree[] = $d;
        }
    }
    return $tree;
}

function buildArrayData($catarray,$selected=0)
{
    $data = buildTreeForVendor($catarray);
    $result = [];
    if ( is_array ( $data ) && count( $data ) > 0 ) {
        foreach ( $data as $d ) {
            $checked = false;
            if ( $selected == $d['value'] ) {    
                $checked = true;
            }
            if ( isset($d['childrens']) && is_array($d['childrens']) && count($d['childrens']) > 0  ) {
                $sub = [];
                foreach($d['childrens'] as $child) {
                    $checkeds = false;
                    if ( $selected == $child['value'] ) {    
                        $checkeds = true;
                    }
                    $sub[] = [
                                'value' => $child['value'].'.'.$d['value'],
                                'label' => $child['label'],
                                'checked' => $checkeds,
                            ];
                }
                $result[] = [
                            'value' => $d['value'].'.0',
                            'label' => $d['label'],
                            'checked' => $checked,
                            'childrens' => $sub
                        ];
            } else {
                $result[] = [
                            'value' => $d['value'].'.0',
                            'label' => $d['label'],
                            'checked' => $checked,
                        ];
            }
        }
    }
    return $result;
}

function adminDisplayTree($catarray,$selected=0)
{
    $data = buildTreeForVendor($catarray);
    $result = [];
    if ( is_array ( $data ) && count( $data ) > 0 ) {
        foreach ( $data as $d ) {
            $checked = false;
            if ( $selected == $d['value'] ) {    
                $checked = true;
            }
            if ( isset($d['childrens']) && is_array($d['childrens']) && count($d['childrens']) > 0  ) {
                $sub = [];
                foreach($d['childrens'] as $child) {
                    $checkeds = false;
                    if ( $selected == $child['value'] ) {    
                        $checkeds = true;
                    }
                    $sub[] = [
                                'value' => $child['value'],
                                'label' => $child['label'],
                                'checked' => $checkeds,
                            ];
                }
                $result[] = [
                            'value' => $d['value'],
                            'label' => $d['label'],
                            'checked' => $checked,
                            'childrens' => $sub
                        ];
            } else {
                $result[] = [
                            'value' => $d['value'],
                            'label' => $d['label'],
                            'checked' => $checked,
                        ];
            }
        }
    }
    return $result;
}

function printTree($tree, $class='parentlink', $r = 0, $p = null) {
        $url = '<ul class="'.$class.'">';
    foreach ($tree as $i => $t) {
        $dash = ($t['parent_id'] == 0) ? '' : str_repeat('', $r) .' ';
        // printf("\t<li><a href='%s'>%s%s</a></li>\n", $t['cat_url'], $dash, $t['cat_name']);
        $url .= '<li><a href="'.base_url().'/categories/'.$t['cat_url'].'">'.$t['cat_name'].'</a></li>';    
        if (isset($t['_children'])) {
            $url .= '<li><a href="'.base_url().'/categories/'.$t['cat_url'].'">'.$t['cat_name'].'</a>';
            $url .= printTree($t['_children'],'sublinks',++$r, $t['parent_id']);
            $url .= '</li>';
            --$r;
        }
    }
    $url .= '</ul>';
    return $url;
}


function StoreCatTree($tree,$urls, $class='parentlink', $r = 0, $p = null) {
    $current_url = current_url();
    if(isset($_GET)){
        $arr = [];
        foreach ($_GET as $key => $value) {
            $arr[] = $key.'='.$value;
        }
        if($arr){
            $current_url = $current_url.'?'.implode('&', $arr);
        }
    }
    $url = '<ul>';
    foreach ($tree as $i => $t) {
        $class = '';
        $style = '';
        $li_class = '';
        $active = prepareCategoryUrl($urls, $t) == $current_url ? " btns":'';
        $dash = ($t['parent_id'] == 0) ? '' : str_repeat('', $r) .' ';
        // printf("\t<li><a href='%s'>%s%s</a></li>\n", $t['cat_url'], $dash, $t['cat_name']);   
        if(isset($_GET['cat'])&& $_GET['cat'] == $t['cat_url']){
            // $class = "parentlink active";
            $class = "parentlink";
            $style = "width: auto";
            $li_class = 'followbtn';
        }
        if (isset($t['_children'])) {
            $filter = array_values(array_filter($t['_children'], function($c) use ($current_url, $urls) {
                return prepareCategoryUrl($urls, $c) == $current_url;
            }));
            if( count($filter) ) {
                $active = ' btns';
                $class = "parentlink";
                $style = "width: auto";
                $li_class = 'followbtn';
            }
            $url .= '<li class="'.$li_class.'" style="'.($style??'').'"><a class="'.$class.$active.'" href="'.base_url().$urls.'/?cat='.$t['cat_url'].'&p='.my_encrypt($t['id']).'" style="'.($style??'').'">'.$t['cat_name'].'</a>';
            $url .= StoreCatTree($t['_children'],$urls,'sublinks',++$r, $t['parent_id']);
            $url .= '</li>';
            --$r;
        } else {
            $url .= '<li class="'.$li_class.'" style="'.($style??'').'"><a class="'.$active.'" href="'.base_url().$urls.'/?cat='.$t['cat_url'].'&p='.my_encrypt($t['id']).'" style="'.($style??'').'">'.$t['cat_name'].'</a></li>'; 
        }
    }
    $url .= '</ul>';
    return $url;
}

/**
 * Prepare url with paramaters
 * @param string $urls
 * @param array $t
 * @return string
 * @author M Nabeel Arshad
 */
function prepareCategoryUrl($urls, $t) : string {
    return base_url().$urls.'?cat='.$t['cat_url'].'&p='.my_encrypt($t['id']);
}


function getDropDownCategory($tree, $selected=0, $class='parentlink', $r = 0, $p = null)
{

    foreach ($tree as $i => $t) {
        $dash = ($t['parent_id'] == 0) ? '' : str_repeat('- ', $r) .'- ';
        $select = '';
        if ( $t['id'] == $selected && $selected > 0 ) {
            $select = 'selected';
        }
        printf("\t<option value='%d' {$select}>%s%s</option>\n", $t['id'], $dash, $t['cat_name']);
        if (isset($t['_children'])) {
            getDropDownCategory($t['_children'], ++$r, $t['parent_id']);
            --$r;
        }
    }

}

function getAdminDropDownCategorySelectedArray($tree, $selected=[], $class='parentlink', $r = 0, $p = null)
{
    foreach ($tree as $i => $t) {
        $dash = ($t['parent_id'] == 0) ? '' : str_repeat('- ', $r) .'- ';
        $select = '';
        if ( is_array($selected) && count($selected) > 0 && array_key_exists( $t['id'], $selected) ) {
            $select .= 'selected';
        }
        printf("\t<option value='%s' {$select}>%s%s</option>\n", my_encrypt($t['id']), $dash, $t['cat_name']);
        if (isset($t['_children'])) {
            getAdminDropDownCategorySelectedArray($t['_children'],$selected,$class, ++$r, $t['parent_id']);
            --$r;
        }
    }

}

function getDropDownCategorySelectedArray($tree, $selected=0, $class='parentlink', $r = 0, $p = null)
{

    foreach ($tree as $i => $t) {
        $dash = ($t['parent_id'] == 0) ? '' : str_repeat('- ', $r) .'- ';
        $select = '';
        if ( $t['id'] == $selected ) {
            $select .= 'selected';
        }
        printf("\t<option value='%s' {$select}>%s%s</option>\n", my_encrypt($t['id']), $dash, $t['cat_name']);
        if (isset($t['_children'])) {
            getDropDownCategorySelectedArray($t['_children'], ++$r, $t['parent_id']);
            --$r;
        }
    }

}

function percentage($percentage,$total)
{
    if ( $percentage > 0 && $total > 0 ) {
        return  round ( ( ( ($percentage - $total) / ($percentage) ) * 100 ) ) ;
    }
    return 0;
}

/**
 * New percentage helper
 * @author M Nabeel Arshad
 */
function calculatePercentage($current, $prev) : float {
    $percentage = 100 * ( $current ? ($current - $prev )/$current : 0 ) ;
    return (float) $percentage;

}

function getHeaderCategory()
{
    if ( ! cache()->get('getHeaderCategory') ) {
        cache()->save('getHeaderCategory',(new App\Models\CategoriesModel())->getAllCategoryTree(),ZapptaHelper::CACHE_SECONDS);
    }
    return cache()->get('getHeaderCategory');
}

function getHomeCategory()
{
    if ( ! cache()->get('getHomeCategory') ) {
        cache()->save('getHomeCategory',(new App\Models\CategoriesModel())->getParentCategories(),ZapptaHelper::CACHE_SECONDS);
    }
    $results = [];
    foreach (cache()->get('getHomeCategory') as $key => $value) {
        $value['cat_icon'] = getImageThumg('media',$value['cat_icon'], 350);
        $results[] = $value;
    }
    return $results;
}

function getHeaderSlider()
{
    if ( ! cache()->get('homeslider') ) {
        cache()->save('homeslider',(new App\Models\SliderModel())->getAllResult(),ZapptaHelper::CACHE_SECONDS);
    }
    $slider = [];
    foreach (cache()->get('homeslider') as $key => $value) {
        $value['slider_image'] = getImageFull('slider',$value['name']);
        $slider[] = $value;
    }
    return $slider;
}

function searchSlider()
{
    if ( ! cache()->get('cms_search_slider') ) {
        cache()->save('cms_search_slider', (new \App\Models\SearchSliderModel())->getAllResult(),ZapptaHelper::CACHE_SECONDS);
    }
    return cache()->get('cms_search_slider');
}

function vendorcompain()
{
    return (new \App\Models\CompainModel())->getCompainForVendors();
}


function assigncompain()
{
    return (new \App\Models\CompainModel())->getVendorCompaignStatus();
}

function getProductCompain($compaign_id,$product_id)
{
    return (new \App\Models\CompainModel())->getProductInCompaign($compaign_id,$product_id);
}

function userTotalZappta()
{
    return (new \App\Models\RegisterModel())->userZapptaDollor();
}

function userWandCount()
{
    return (new \App\Models\RegisterModel())->userWandDollor();
}

function userPowerWandCount()
{
    return (new \App\Models\RegisterModel())->userPowerWandDollor();
}

function getWheelDataOnSpin($id)
{
    return (new \App\Models\CompainModel())->getWheelsById($id);
}

function generateToken($string, $key="", $url_safe=TRUE)
{   
    // $plaintext = $data;
    // $key = getenv('encryption.key');
    // $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    // $iv = openssl_random_pseudo_bytes($ivlen);
    // $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    // $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    // return base64_encode( $iv.$hmac.$ciphertext_raw );
    return strtr(base64_encode($string), '+/=', '._-');
}

function decodeToken($string, $key="")
{
    // $c = base64_decode($data);
    // $key = getenv('encryption.key');
    // $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    // $iv = substr($c, 0, $ivlen);
    // $hmac = substr($c, $ivlen, $sha2len=32);
    // $ciphertext_raw = substr($c, $ivlen+$sha2len);
    // $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    // $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    // if (hash_equals($hmac, $calcmac))// timing attack safe comparison
    // {
    //     return $original_plaintext;
    // }
    return base64_decode(strtr($string, '._-', '+/='));
}

function timeago($date) {
   $timestamp = strtotime($date);   
   
   $strTime = array("second", "minute", "hour", "day", "month", "year");
   $length = array("60","60","24","30","12","10");

   $currentTime = time();
   if($currentTime >= $timestamp) {
        $diff     = time()- $timestamp;
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
        $diff = $diff / $length[$i];
        }

        $diff = round($diff);
        return $diff . " " . $strTime[$i] . "(s) ago ";
   }
}

function getNotifications($limit = null){
    return (new \App\Models\UsersModel())->getNotifications($limit);
}

/**
 * Save notification for different users types
 * 
 */
function saveNotification($message, $type, $order_id=null, $user_id = null, $vendor_id = null) {
    $data = [
        'message' => $message,
        'type' => $type,
        'order_id' => $order_id,
        'user_id' => $user_id,
        'vendor_id' => $vendor_id,
        'is_read' => 0  
    ];
    return (new \App\Models\Notification())->saveNotification($data);
    
}


/**
 * Get results related to pagination
 * @param int $page
 * @param int $limit
 * @param int $total
 * @return string
 * @author M Nabeel Arshad
 */
function displayResultsPhrase($page, $limit, $total) : string {
    $t = $page*$limit > $total ? $total : $page*$limit;
    return "<h2>Showing ".((($page-1)*$limit)+1)."-".($t)." of {$total} results</h2>";
}

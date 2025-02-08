<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\VendorModel;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\RegisterModel;
use App\Models\Setting;
use App\Traits\ZapptaTrait;

class Home extends BaseController
{
    use ZapptaTrait;
    public function index()
    {
        // $data['homeslider'] = (new SliderModel())->getAllResult();
        // return view('site/facebook');
        $data = $this->homeTrait();
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        // return view('site/home',$data);
        return view('site/newLanding/index', $data);
    }

    public function Landing()
    {
        // return view('site/27-aug/home');
        // return view('site/landing');
        $data = $this->homeTrait();
        $data['assets_url'] = base_url() . 'new-landing/assets';
        return view('site/newLanding/index', $data);
    }
    
    public function default()
    {
        $data['homeslider'] = getHeaderSlider();
        $data['categories'] = getHomeCategory();
        $data['store'] = (new VendorModel())->getHomeResult();
        $data['compaign'] = (new ProductsModel())->getCompaignProducts(10);
        return view('site/home',$data);
        // print '<pre>';
        // print_r($data['compaign']);
        // print '</pre>';
    }
    public function spree()
    {
        $post = request()->getPost();
        $post['com_id'] = my_decrypt($post['com_id']);
        $post['store_id'] = my_decrypt($post['store_id']);

        $response = ZapptaTrait::addToSpreeTrait($post);
        $response['token'] = csrf_hash();
        return $this->response->setJSON($response);
    }

    public function fetchSpree()
    {
        $com_id = my_decrypt($_POST['com_id']);
        $store_id = my_decrypt($_POST['store_id']);
        $response = ZapptaTrait::spreeData($com_id, $store_id);
        $response['token'] = csrf_hash();
        return $this->response->setJSON($response);
    }

    /**
     * Display all live and upcoming compaigns
     * @author M Nabeel Arshad
     */
    public function compaigns() {
        $data = $this->compaignsTrait();
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        $data['see_all_btn'] = false;
        return view('site/campaigns', $data);
    }

    /**
     * Generate CSRF Token
     */
    public function generateCsrfToken() {
        $data['token'] = csrf_hash();
        return response()->setJSON($data);
    }

    /**
     * Login Through Game Token
     * 
     */
    public function loginThroughGame() {
        try {
            $get = request()->getGet();
            $token = json_decode(my_decrypt($get['__token']));
            $com_id = my_decrypt($get['__com_id']);
            $store_id = my_decrypt($get['__store_id']);
            if(!$token || !isset($token->user_id) || !$token->user_id || !isset($token->time)) {
                echo "<script>alert('Invalid Token!');window.location.href='".base_url()."'</script>";
                die();
            }
            if($token->time < time()) {
                echo "<script>alert('Token Expired!');window.location.href='".base_url()."'</script>";
                die();
            }
            $registerModel = new RegisterModel();
            $user = $registerModel->find($token->user_id);
            if($user) {
                $registerModel->setUserSession($user);
                $response = ZapptaTrait::spreeData($com_id, $store_id);
                if(isset($response['spree']) && count($response['spree'])) {
                    $url = base_url('compaign/verify/'.my_encrypt($response['spreeDetail']->id));
                    return redirect()->to($url);
                }
            }
            echo "<script>alert('Something went wrong!');window.location.href='".base_url()."'</script>";
            die();
        } catch (\Throwable $th) {
            echo "<script>alert('{$th->getMessage()}');window.location.href='".base_url()."'</script>";
            die();
        }
    }
    
}

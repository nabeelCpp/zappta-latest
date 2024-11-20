<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\VendorModel;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
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
        $data['assets_url'] = base_url() . '/new-landing/assets';
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
        // $data = $_POST;
        // foreach ($data as $key => $value) {
        //     $data[$key] = my_decrypt($value);
        // }
        $data['com_id'] = my_decrypt($_POST['com_id']);
        $data['store_id'] = my_decrypt($_POST['store_id']);
        $data['pid'] = $_POST['pid'];
        $data['user_id'] = getUserId();
        // get spree details 
        $spree_detail = (new VendorModel())->getSpreeByVendorComId( my_decrypt($_POST['store_id']), my_decrypt($_POST['com_id']));
        $product_detail = (new ProductsModel())->getProductDetail($_POST['pid']);
        // return json_encode($product_detail);
        $count_total_spreed = (new ProductsModel())->prevSpreeCount(my_decrypt($_POST['com_id']), my_decrypt($_POST['store_id']));
        if($product_detail['deal_enable'] > 0) {
            $total = $_POST['status'] == 'add'?$count_total_spreed + $product_detail['deal_final_price']:$count_total_spreed - $product_detail['deal_final_price'];
        }else{
            $total = $_POST['status'] == 'add'?$count_total_spreed + $product_detail['final_price']:$count_total_spreed - $product_detail['final_price'];
        }
        if($total > $spree_detail->price){
            $response = ['status' => false,'spree' => [], 'msg'=>'Products selected cost is higher than spree price ($'.$spree_detail->price.')', 'token' => csrf_hash()];
            return $this->response->setJSON($response);
        }
        $spree = (new ProductsModel())->addRemoveSpreeProduct($data);
        $response = ['status' => true, 'spree' => $spree, 'token' => csrf_hash()];
        // return json_encode($response);
        return $this->response->setJSON($response);
    }

    public function fetchSpree()
    {
        $com_id = my_decrypt($_POST['com_id']);
        $store_id = my_decrypt($_POST['store_id']);
        $sprees = (new ProductsModel())->fetchSprees($com_id, $store_id);
        $spreeDetail = (new ProductsModel())->fetchSpreesDetails($com_id, $store_id);
        $spreeDetail[0]['compain_s_date'] = date('Y/m/d', strtotime($spreeDetail[0]['compain_s_date'])).' 23:59:59';
        $response = ['spree' => $sprees, 'spreeDetail' => $spreeDetail[0], 'token' => csrf_hash()];
        return $this->response->setJSON($response);
    }

    /**
     * Display all live and upcoming compaigns
     * @author M Nabeel Arshad
     */
    public function compaigns() {
        $data['compaign'] = (new VendorModel())->getSpreesToDisplayOngoing(10);
        $data['compaign_upcoming'] = (new VendorModel())->getSpreesToDisplayUpcoming(10);
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        $data['see_all_btn'] = false;
        return view('site/campaigns', $data);
    }
    
}

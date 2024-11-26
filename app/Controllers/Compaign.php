<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\VendorModel;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\CompainModel;
use App\Traits\ZapptaTrait;

class Compaign extends BaseController
{
    use ZapptaTrait;
    public function index()
    {

        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['total_products'] = (new ProductsModel())->getTotalCompaignProducts();
        $data['compaign'] = (new ProductsModel())->getAllCompaignProducts($data['page']);
        if ( $data['total_products'] > 12 ) {
            $data['pager'] = service('pager');
        }
        return view('site/compaign/index',$data);
    }
    
    public function play()
    {
        // $data['wheels'] = [];
        // $url = $this->request->getUri()->getSegment(3);
        // $data['pid'] = (new ProductsModel())->getProductByUrlOnPlay(filtreData($url));
        // $data['single'] = (new ProductsModel())->getSinglePlayCompaignProducts($data['pid']);
        // $data['compaign'] = (new ProductsModel())->getAllPlayCompaignProducts($data['pid']);
        // $wh = isset($_GET['wh']) ? $_GET['wh'] : 1;
        // if ( $wh == 2 ) {
        //     if(!$_POST){
        //         return redirect()->to('/');
        //     }
        //     return view('site/compaign/playtwo',$data);
        // } elseif ( $wh == 3 ) {
        //     if(!$_POST){
        //         return redirect()->to('/');
        //     }
        //     return view('site/compaign/playthree',$data);
        // } elseif ( $wh == 4 ) {
        //     if(!$_POST){
        //         return redirect()->to('/');
        //     }
        //     return view('site/compaign/playfour',$data);
        // } else {
            // print_r($_COOKIE['game_spree']);exit;
            if(!isset($_COOKIE['game_spree'])) {
                return redirect()->to('/cart');
            } else {
                $purl = $_COOKIE['game_spree'];
            }
            $data['show_newsletter'] = false;
            return view('site/compaign/play', $data);
        // }
    }

    public function verify()
    {
        $pid = my_decrypt($this->request->getUri()->getSegment(3));
        $cookie_name = "game_spree";
        $cookie_value = my_encrypt($pid);
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        // $url = base_url().'/compaign/play/'.$single['purl'].'/p/'.$single['pc'].'/'.'?sd_row='.$single['sd_row'].'&pds='.$single['pds'].'&playgive=1';
        $url = base_url().'compaign/play';
        return redirect()->to($url);
    }

    public function playresult()
    {
        $sign = '';
        $res = filtreData($this->request->getVar('res'));
        $wheel = filtreData($this->request->getVar('wheel'));
        $wheelplayvalue = filtreData($this->request->getVar('wheelplayvalue'));

        $pid = filtreData($this->request->getVar('winpidp'));
        $store_id = filtreData($this->request->getVar('winspidp'));
        $com_id = filtreData($this->request->getVar('winscidp'));

        $spindata = getWheelDataOnSpin($wheel);
        $getpp = array_search($res,$spindata);

        if (str_contains($res, 'X')) { 
            $sign = '*';
        }
        if (is_numeric($res)) {
            $sign = '+';
        } 

        $points = (new \App\Models\CompainModel())->insertGameDate($wheel,$getpp,$com_id,$store_id,$pid,$wheelplayvalue, $sign);
        print json_encode($points);
    }

    public function latestresult()
    {

        $wheel = filtreData($this->request->getVar('wheel'));
        $pid = filtreData($this->request->getVar('winpidp'));
        $store_id = filtreData($this->request->getVar('winspidp'));
        $com_id = filtreData($this->request->getVar('winscidp'));
        $product_id = my_decrypt($pid);
        $points = (new \App\Models\CompainModel())->getUserCompaignResult($wheel,$com_id,$store_id,$product_id);
        if ( is_array($points) && count($points) > 0 ) {
            $html = '';
            usort($points, function ($item1, $item2) {
                return $item2['score'] <=> $item1['score'];
            });
            $sr = 1;
            foreach( $points as $p ) {
                $html .= '<div class="resultplay">
                            <div class="no">'.$sr++.'</div>
                            <div class="imgtitle d-flex">
                                <div class="img"></div>
                                <div class="tt">'.$p['fname'].'</div>
                            </div>
                            <div class="sc">'.$p['score'].'</div>
                            <div class="strike">'.$p['strikes'].'</div>
                        </div>';
            }
            print json_encode($html);
        }
    }

    public function winners()
    {
        $data = $this->compaignWinnersTrait();
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        return view('site/compaign/winners', $data);
    }

    public function ajaxWinners()
    {
        $CompainModel = new CompainModel;
        $compaign = $CompainModel->getLatestCompaign();
        $products = $CompainModel->getCompaignProductsToshow($compaign->id);
        $data = [];
        foreach ($products as $key => $value) {
            if( ! empty( $value['cover'] ) ) { 
                $ext_name = explode('.',$value['cover']);
                $value['cover']  = base_url().'images/product/'.$ext_name[0].'/'.$ext_name[1].'/250';
            } else {
                $value['cover']  = base_url().'images/product/img-not-found/jpg/100';
            }
            // $value['brand_logo'] = $CompainModel->getBrandLogo($value['id']);

            // if( ! empty( $value['brand_logo'] ) ) { 
            //     $ext_name = explode('.',$value['brand_logo']);
            //     $value['brand_logo']  = base_url().'/images/product/'.$ext_name[0].'/'.$ext_name[1].'/250';
            // } else {
            //     $value['brand_logo']  = base_url().'/images/product/img-not-found/jpg/100';
            // }
            $points = (new \App\Models\CompainModel())->getUserCompaignResult('',my_encrypt($compaign->id),'',$value['id']);
            usort($points, function ($item1, $item2) {
                return $item2['score'] <=> $item1['score'];
            });
            $arr = ['product' => $value, 'points' => $points];
            array_push($data, $arr);
        }
        $res = ['compaign' => $compaign, 'details' => $data];
        return $this->response->setJSON($res);
    }

}

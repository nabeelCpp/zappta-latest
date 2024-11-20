<?php

namespace App\Controllers;

use App\Models\VendorModel;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\CompainModel;
use App\Models\RegisterModel;
use App\Models\Setting;

class Api1 extends BaseController
{
    private $token = 'WIEQvIRW/M5TsLvD1CpuoKKWtItbPLnoUyU/rD+2/AI=';
    public function __construct() {
//        $token = null;
//        $headers = apache_request_headers();
//        if(isset($headers['Authorization'])){
//            $arr = explode(' ', $headers['Authorization']);
//            $token = $arr[1];
//        }
//
//        if($token !== $this->token){
//            http_response_code(503);
//            echo json_encode(['msg' => 'Unauthorized']);
//            exit;
//        }
    }
    public function wheel($id)
    {
        // $id = $this->request->getUri()->getSegment(3);
        $spindata = getWheelDataOnSpin($id);
        unset($spindata['created_at'], $spindata['updated_at'], $spindata['deleted_at']);
        return $this->response->setJSON($spindata);
    }

    public function productDetails()
    {
        if(!$this->request->getVar('wheel')){
            echo json_encode(['error' => 'Wheel id is required!']);
            exit;
        }
        if(!$this->loginUser()){
            return false;
        }
        // if(isset($_COOKIE['game_product']) && $_COOKIE['game_product']){
        //     $purl = $_COOKIE['game_product'];
        // }else{
        //     return redirect()->to('/cart');
        // }
        $wheel = $this->request->getVar('wheel');
        $product = "lotus-biscoff-cookie-butter-spread";
        // $product = $purl;
        $pid = (new ProductsModel())->getProductByUrlOnPlay(filtreData($product));
        $data['pid'] = $pid;
        $data['product'] = (new ProductsModel())->getSinglePlayCompaignProducts($data['pid']);
        $data['product']['pcover'] = base_url().'upload/products/'.$data['product']['pcover'];
        $data['product']['store_logo'] = base_url().'upload/media/'.$data['product']['store_logo'];
        $data['compaign'] = (new ProductsModel())->getAllPlayCompaignProducts($data['pid']);
        $data['coins_played'] = ( (new \App\Models\CompainModel())->getZapptaPlay($wheel, $pid)?(new \App\Models\CompainModel())->getZapptaPlay($wheel, $pid):0 );
        $data['points_won'] = ( (new \App\Models\CompainModel())->getZapptaWinPlay($wheel, $pid)?(new \App\Models\CompainModel())->getZapptaWinPlay($wheel, $pid):0 );
        $data['total_score'] = ( (new \App\Models\CompainModel())->getTotalResult($wheel, $pid)?(new \App\Models\CompainModel())->getTotalResult($wheel, $pid):0 );
        $data['balance'] =  userTotalZappta();
        $data['total_stikes_attend'] = (new \App\Models\CompainModel())->getTotlStrike($wheel, $data['product']['compain_e_date'], $data['product']['compain_s_date'], $pid);
        $data['player_id'] = getUserId();
        $data['wand_count'] = userWandCount();
        return $this->response->setJSON($data);
    }

    public function resetPlayer($id)
    {
        $db = \Config\Database::connect();
        $db->table('compain_players_entry')->where('player_id', $id)->update(['is_deleted' => 1, 'deleted_at' => date('Y-m-d H:i:s')]);
        return $this->response->setJSON(['success' => 'Players stats reset successfully!']);
    }

    
    public function leaderBoard()
    {

        $wheel = filtreData($this->request->getVar('wheel'));
        $pid = filtreData(my_encrypt($this->request->getVar('pid')));
        $store_id = filtreData(my_encrypt($this->request->getVar('store_id')));
        $com_id = filtreData(my_encrypt($this->request->getVar('com_id')));
        $product_id = my_decrypt($pid);
        $points = (new \App\Models\CompainModel())->getUserCompaignResult($wheel,$com_id,$store_id,$product_id);
        if ( is_array($points) && count($points) > 0 ) {
            $html = '';
            usort($points, function ($item1, $item2) {
                return $item2['score'] <=> $item1['score'];
            });
            // $sr = 1;
            // foreach( $points as $p ) {
            //     $html .= '<div class="resultplay">
            //                 <div class="no">'.$sr++.'</div>
            //                 <div class="imgtitle d-flex">
            //                     <div class="img"></div>
            //                     <div class="tt">'.$p['fname'].'</div>
            //                 </div>
            //                 <div class="sc">'.$p['score'].'</div>
            //                 <div class="strike">'.$p['strikes'].'</div>
            //             </div>';
            // }
        }
        for ($i=0; $i < count($points); $i++) { 
            $points[$i]['rank'] = $i+1;
            if($points[$i]['rank'] >= 10 && $points[$i]['is_player']){
                $self_player = $points[$i];
            }
        }
        if(count($points)>10){
            if(isset($self_player)){
                $res = array_slice($points, 0, 9);
                array_push($res, $self_player);
            }else{
                $res = array_slice($points, 0, 10);
            }
        }else{
            $res = $points;
        }
        return $this->response->setJSON($res);
    }

    public function playresult()
    {
        if(!$this->loginUser()){
            return false;
        }
        $sign = '';
        $res = filtreData($this->request->getVar('wheel_value'));
        $wheel = filtreData($this->request->getVar('wheel'));
        $wheelplayvalue = filtreData($this->request->getVar('coins_played'));
        
        $pid = filtreData(my_encrypt($this->request->getVar('pid')));
        $store_id = filtreData(my_encrypt($this->request->getVar('store_id')));
        $com_id = filtreData(my_encrypt($this->request->getVar('com_id')));
        $wand_consumed = filtreData($this->request->getVar('wand_consumed'));
        $wand_gained = filtreData($this->request->getVar('wand_gained'));
        // return $this->response->setJSON((userTotalZappta() - $wheelplayvalue) < 0);
        if((userTotalZappta() - $wheelplayvalue) < 0){
            return $this->response->setJSON(['msg' => 'You have insufficient balanace to play game.', 'balance' => userTotalZappta(), 'coins_played' => $wheelplayvalue]);            
        }
        // check if strikes are less than 3.
        $product = (new ProductsModel())->getSinglePlayCompaignProducts(my_decrypt($pid));
        $strikes = (new \App\Models\CompainModel())->getTotlStrike($wheel, $product['compain_e_date'], $product['compain_s_date'], my_decrypt($pid));
        if($strikes > 3){
            return $this->response->setJSON(['msg' => 'You have already exceed 3 strikes.', 'strikes' => $strikes]);
        }
        $spindata = getWheelDataOnSpin($wheel);
        $getpp = array_search($res,$spindata);
        // echo json_encode([$spindata, $res, $getpp]);exit;

        if (str_contains($res, 'X')) { 
            $sign = '*';
        }
        if (str_contains($res, 'x')) { 
            $sign = '*';
        }
        if (is_numeric($res)) {
            $sign = '+';
        } 

        $points = (new \App\Models\CompainModel())->insertGameDate($wheel,$getpp,$com_id,$store_id,$pid,$wheelplayvalue, $sign, $wand_gained, $wand_consumed);
        return $this->response->setJSON($points);
    }

    public function socialMediaZapptas()
    {
        $social_media =  filtreData($this->request->getVar('social_media'));
        if ( getUserId() > 0 ) {
            (new Setting())->insertDollorSocialMediaClick($social_media);
        }
        return $this->response->setJSON(['balance' => number_format(userTotalZappta(), 2)]);
    }

    public function loginUser()
    {
        (new RegisterModel())->login_verify('semee@gmail.com','semee123');
        if( session()->get('userIsLoggedIn') ) {
            return true;
        }
    }
}

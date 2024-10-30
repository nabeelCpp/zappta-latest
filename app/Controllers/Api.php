<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\VendorModel;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\CompainModel;
use App\Models\RegisterModel;
use App\Models\Setting;

class Api extends BaseController
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
        $db = \Config\Database::connect();
        if(!$this->request->getVar('wheel')){
            echo json_encode(['error' => 'Wheel id is required!']);
            exit;
        }
        if(!$this->loginUser()){
            return false;
        }
        if(isset($_COOKIE['game_spree']) && $_COOKIE['game_spree']){
            $spree_id = my_decrypt($_COOKIE['game_spree']);
        }
        else{
            $spree_id = 14;
            // return redirect()->to('/cart');
        }
        $wheel = $this->request->getVar('wheel');
        // $product = "lotus-biscoff-cookie-butter-spread";
        // $product = $purl;
        // $pid = (new ProductsModel())->getProductByUrlOnPlay(filtreData($product));
        $spree = (new VendorModel())->getPublicSpreeById($spree_id);
        $data['pid'] = $spree_id;
        // $data['product'] = (new ProductsModel())->getSinglePlayCompaignProducts($data['pid']);
        $data['product'] = $spree;
        $data['product']->pname = $spree->store_name;
        $data['product']->final_price = $spree->price;
        $data['product']->pid = $spree->id;
        $data['product']->store_id = $spree->vendor_id;
        $data['product']->pcover = base_url().'/upload/media/spree/'.$spree->cover;
        $data['product']->store_logo = base_url().'/upload/media/'.$spree->store_logo;
        // $data['compaign'] = (new ProductsModel())->getAllPlayCompaignProducts($data['pid']);
        // $data['coins_played'] = ( (new \App\Models\CompainModel())->getZapptaPlay($wheel, $pid)?(new \App\Models\CompainModel())->getZapptaPlay($wheel, $pid):0 );
        $data['coins_played'] = ( (new \App\Models\CompainModel())->getZapptaPlay($wheel, $spree_id)?(new \App\Models\CompainModel())->getZapptaPlay($wheel, $spree_id):0 );
        // $data['points_won'] = ( (new \App\Models\CompainModel())->getZapptaWinPlay($wheel, $pid)?(new \App\Models\CompainModel())->getZapptaWinPlay($wheel, $pid):0 );
        $data['points_won'] = ( (new \App\Models\CompainModel())->getZapptaWinPlay($wheel, $spree_id)?(new \App\Models\CompainModel())->getZapptaWinPlay($wheel, $spree_id):0 );
        // $data['total_score'] = ( (new \App\Models\CompainModel())->getTotalResult($wheel, $pid)?(new \App\Models\CompainModel())->getTotalResult($wheel, $pid):0 );
        $data['total_score'] = ( (new \App\Models\CompainModel())->getTotalResult($wheel, $spree_id)?(new \App\Models\CompainModel())->getTotalResult($wheel, $spree_id):0 );
        $data['balance'] =  userTotalZappta();
        // $data['total_stikes_attend'] = (new \App\Models\CompainModel())->getTotlStrike($wheel, $data['product']['compain_e_date'], $data['product']['compain_s_date'], $pid);
        $data['total_stikes_attend'] = (new \App\Models\CompainModel())->getTotlStrike($wheel, $data['product']->compain_e_date, $data['product']->compain_s_date, $spree_id);
        $data['player_id'] = getUserId();
        $data['wand_count'] = userWandCount();
        $data['power_wand_count'] = userPowerWandCount();
        $level = $db->table("compain_players_entry")->select("level_number")->where(['spree_id' => $spree_id, "player_id" => getUserId(), "com_id" => $spree->com_id, "is_deleted" => 0])->orderBy('level_number', 'DESC')->limit(1)->get()->getResult();
        $data['level_number'] = $level?$level[0]->level_number:1;
        return $this->response->setJSON($data);
    }

    public function resetPlayer($id)
    {
        $db = \Config\Database::connect();
        $db->table('compain_players_entry')->where('player_id', $id)->update(['level_number' => 1,'is_deleted' => 1, 'deleted_at' => date('Y-m-d H:i:s')]);
        $db->table('wands')
                    ->where('user_id',getUserId())
                    ->delete();
        $db->table('power_wands')
                    ->where('user_id',getUserId())
                    ->delete();
        return $this->response->setJSON(['success' => 'Players stats reset successfully!']);
    }

    
    public function leaderBoard()
    {

        $wheel = filtreData($this->request->getVar('wheel'));
        $pid = filtreData(my_encrypt($this->request->getVar('pid'))); //pid is spree_id
        $store_id = filtreData(my_encrypt($this->request->getVar('store_id')));
        $com_id = filtreData(my_encrypt($this->request->getVar('com_id')));
        $product_id = my_decrypt($pid); //product_id is spree_id
        $points = (new \App\Models\CompainModel())->getUserCompaignResult($wheel,$com_id,$store_id,$product_id);
        if ( is_array($points) && count($points) > 0 ) {
            $html = '';
            usort($points, function ($item1, $item2) {
                return $item2['score'] <=> $item1['score'];
            });
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
        $db = \Config\Database::connect();
        if(!$this->loginUser()){
            return false;
        }
        $sign = '';
        $res = filtreData($this->request->getVar('wheel_value'));
        $wheel = filtreData($this->request->getVar('wheel'));
        $wheelplayvalue = filtreData($this->request->getVar('coins_played'));
        // level no
        $level_no = $this->request->getVar('level_no')?filtreData($this->request->getVar('level_no')):0;
        $pid = filtreData(my_encrypt($this->request->getVar('pid'))); //Pid is spree_id
        $store_id = filtreData(my_encrypt($this->request->getVar('store_id')));
        $com_id = filtreData(my_encrypt($this->request->getVar('com_id')));
        $wand_consumed = $this->request->getVar('wand_consumed')?filtreData($this->request->getVar('wand_consumed')):0;
        $power_wand_consumed = $this->request->getVar('power_wand_consumed')?filtreData($this->request->getVar('power_wand_consumed')):0;
        $wand_gained = $this->request->getVar('wand_gained')?filtreData($this->request->getVar('wand_gained')):0;
        $power_wand_gained = $this->request->getVar('power_wand_gained')?filtreData($this->request->getVar('power_wand_gained')):0;
        $zappta_coins = $this->request->getVar('zappta_coins')?filtreData($this->request->getVar('zappta_coins')):0;
        // return $this->response->setJSON((userTotalZappta() - $wheelplayvalue) < 0);
        if((userTotalZappta() - $wheelplayvalue) < 0){
            return $this->response->setJSON(['msg' => 'You have insufficient balanace to play game.', 'balance' => userTotalZappta(), 'coins_played' => $wheelplayvalue]);            
        }
        // check if strikes are less than 3.
        // $product = (new ProductsModel())->getSinglePlayCompaignProducts(my_decrypt($pid));
        $spree = (new VendorModel())->getPublicSpreeById(my_decrypt($pid));
        // $strikes = (new \App\Models\CompainModel())->getTotlStrike($wheel, $product['compain_e_date'], $product['compain_s_date'], my_decrypt($pid));
        $strikes = (new \App\Models\CompainModel())->getTotlStrike($wheel, $spree->compain_e_date, $spree->compain_s_date, my_decrypt($pid));
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

        $points = (new \App\Models\CompainModel())->insertGameDate($wheel,$getpp,$com_id,$store_id,$pid,$wheelplayvalue, $sign, $wand_gained, $wand_consumed,$power_wand_gained, $power_wand_consumed, $level_no);
        // Insert Zapptas
        if($zappta_coins > 0){
            $db->table('zappta_earn')
            ->set('user_id',getUserId())
            ->set('zapta_earn',$zappta_coins)
            ->set('visit_link','Zappta win by game')
            ->set('type', 0)
            ->set('visit_date',date('Y-m-d'))
            ->set('created_at', date('Y-m-d H:i:s'))
            ->insert();
        }
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

    public function checkCompainEnd()
    {
        $db = \Config\Database::connect();
        $compains = $db->table("compain")->where('compain_e_date < ', date('Y-m-d'))->get()->getResultArray();
        foreach ($compains as $key => $comp) {
           $sprees = $db->table("vendor_sprees")->where(['com_id' => $comp['id']])->get()->getResult();
           foreach ($sprees as $key => $spree) {
                $check_coupened = $db->table("coupons")->where(['spree_id' => $spree->id, "com_id" => $comp['id']])->get()->getResult();
                if(count($check_coupened) == 0){
                    $product_id = $spree->id; //product_id is spree_id
                    $points = (new \App\Models\CompainModel())->getUserCompaignResult(1,my_encrypt($comp['id']),$spree->vendor_id,$product_id);
                    if ( is_array($points) && count($points) > 0 ) {
                        usort($points, function ($item1, $item2) {
                            return $item2['score'] <=> $item1['score'];
                        });
                        $winner = $points[0];
                        (new \App\Models\UsersModel())->saveNotification("Congratulations! You have won free coupon of worth $ {$spree->price} by winning spree game.", my_decrypt($winner['player_id']), 'dashboard/spree', '');
                        $coupon_code = $this->generateCoupon();
                        $db->table("coupons")
                                ->set("coupon_code", $coupon_code)
                                ->set("user_id", my_decrypt($winner['player_id']))
                                ->set("spree_id", $spree->id)
                                ->set("com_id", $comp['id'])
                                ->set("vendor_id", $spree->vendor_id)
                                ->set("coupon_price", $spree->price)
                                ->insert();
                        echo $spree->percentage_to_participants."<br>";
                        if($spree->percentage_to_participants > 0){
                            $coupon_price = ($spree->price*$spree->percentage_to_participants)/100;
                            for ($i=1; $i < count($points); $i++) { 
                                $coupon_code = $this->generateCoupon();
                                (new \App\Models\UsersModel())->saveNotification("Congratulations! You have won free coupon of worth $ {$coupon_price} by participating in spree.", my_decrypt($points[$i]['player_id']), 'dashboard/spree', '');
                                $db->table("coupons")
                                    ->set("coupon_code", $coupon_code)
                                    ->set("user_id", my_decrypt($points[$i]['player_id']))
                                    ->set("spree_id", $spree->id)
                                    ->set("com_id", $comp['id'])
                                    ->set("vendor_id", $spree->vendor_id)
                                    ->set("coupon_price", $coupon_price)
                                    ->insert();
                            }
                        }
                    }
                }
           }
        }
    }

    private function generateCoupon()
    {
        $db = \Config\Database::connect();
        $length = 16;
        $coupon_code = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
        if($db->table("coupons")->where("coupon_code", $coupon_code)->get()->getResult()){
            return $this->generateCoupon();
        }
        return $coupon_code;
    }

    public function loginUser()
    {
        if(getUserId() == 0){
            (new RegisterModel())->login_verify('semee@gmail.com','semee12345');
            if( session()->get('userIsLoggedIn') ) {
                return true;
            }
        }else{
            return true;
        }
    }

    public function getLogo() {
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['frontend_logo']);
        $logo = $data['globalSettings'][0]['var_detail'];
        $logo = getImageFull('logo', $logo);
        return response()->setJSON(['logo' => $logo]);
    }
    
}

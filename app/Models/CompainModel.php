<?php

namespace App\Models;

use CodeIgniter\Model;

class CompainModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'compain';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'compain_name',
										'compain_s_date',
										'compain_e_date',
										'compain_msg',
										'compain_terms',
										'status',
										'deleteStatus',
                                        'active',
                                        'notification',
                                        'email_notify',
									];
	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];


    public function getCompaign()
    {
        $date = date('Y-m-d');
        $sql = $this->db->table($this->table)
                        ->where('compain_s_date',$date)
                        ->orderBy('id DESC')
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return $sql;
        }
        return false;
    }

    public function getAllResult($limit=1)
    {
        $limits = 20;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        return $this->db->table($this->table)
                        //->select('categories.*, COUNT(DISTINCT(cms_product_category.product_id)) as total_items, COUNT(DISTINCT(p2.store_id)) as total_stores')
                        //->join('product_category','product_category.catid=categories.id','LEFT')
                        //->join('product_category p2','p2.catid=categories.id','LEFT')
                        ->where('deleteStatus',0)
                        // ->groupBy('categories.id')
                        ->limit($limits,$result_limit)
                        ->orderBy('id DESC')
                        ->get()
                        ->getResultArray();
    }

    public function searchCategories( $word )
    {
        return $this->db->table($this->table)
                        //->select('categories.*, COUNT(DISTINCT(cms_product_category.product_id)) as total_items, COUNT(DISTINCT(p2.store_id)) as total_stores')
                        //->join('product_category','product_category.catid=categories.id','LEFT')
                        //->join('product_category p2','p2.catid=categories.id','LEFT')
                        ->where('deleteStatus',0)
                        ->like('compain_name', $word)
                        // ->groupBy('categories.id')
                        ->orderBy('id DESC')
                        ->get()
                        ->getResultArray();
    }

    public function getAdminTotalResult()
    {
        return $this->db->table($this->table)
                        ->where('deleteStatus',0)
                        ->countAllResults();
    }


    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

    public function sendCompainEmail($email,$compaign_id)
    {
    	$sql = $this->getCVdata($compaign_id,$email);
    	if ( !empty($sql) && $this->getVendorCompaing($sql['vid'],$compaign_id) == false ) {
    		$data['store'] = $sql;
    		$this->insertVendorId($sql['vid'],$compaign_id);
    		$this->insertNotification($sql['vid'],$sql['compain_msg'],$sql['compain_e_date']);
	        (new \App\Models\EmailModel())->sendMail($sql['email'],'New Compaign','compainemail',$data);
	    	return true;
	    }
	    return false;
    }

    private function getCVdata($id,$email)
    {
    	$select = "SELECT cc.compain_msg,cc.compain_e_date, cv.store_name, cv.email, cv.id as vid FROM cms_compain cc JOIN cms_vendor cv WHERE cc.id=$id AND cv.email='$email' ";
    	return $this->db->query($select)
    					->getRowArray();
    }

    private function insertNotification($vendors_id,$msg,$date)
    {
    	// send to 1 for vendors
    	return $this->db->table('notification')
    					->set('types',1)
    					->set('vendors_id',$vendors_id)
    					->set('expiry_date',$date)
    					->set('msg',$msg)
    					->set('send_to',1)
    					->set('created_at', date('Y-m-d H:i:s'))
    					->insert();
    }

    private function insertVendorId($vendor_id,$compaign_id)
    {
    	// send to 1 for vendors
    	return $this->db->table('compain_vendors')
    					->set('compaign_id',$compaign_id)
    					->set('vendor_id',$vendor_id)
    					->set('status',1)
    					->set('created_at', date('Y-m-d H:i:s'))
    					->insert();
    }

    private function getVendorCompaing($vendor_id,$compaign_id)
    {
    	// send to 1 for vendors
    	$sql = $this->db->table('compain_vendors')
    					->where('compaign_id',$compaign_id)
    					->where('vendor_id',$vendor_id)
    					->get()
    					->getRowArray();
    	if ( !empty($sql) ) {
    		return true;
    	}
    	return false;
    }

    /*
    *   vendor status 1,2 is enable
    *   vendor status 3 for reject offer
    */
    public function getCompainForVendors()
    {
        $sql = $this->db->table('compain')
                        ->select('compain.*, cv.status as cvs, cv.compaign_id as compaign_id')
                        ->join('compain_vendors cv','cv.compaign_id=compain.id','LEFT')
                        ->where('compain.status',1)
                        ->whereIn('cv.status',[1,2])
                        ->where('cv.vendor_id',getVendorUserId())
                        ->get()
                        ->getRowArray();
        return $sql;
    }

    public function updateCompainForVendors($status,$compaign_id)
    {
        return $this->db->table('compain_vendors')
                        ->set('status',$status)
                        ->where('compaign_id',$compaign_id)
                        ->where('vendor_id',getVendorUserId())
                        ->update();
    }

    public function getVendorCompaignStatus()
    {
        $sql = $this->db->table('compain')
                        ->select('compain.*, cv.status as cvs, cv.compaign_id as compaign_id')
                        ->join('compain_vendors cv','cv.compaign_id=compain.id','LEFT')
                        ->where('compain.status',1)
                        ->where('cv.status',2)
                        ->where('cv.vendor_id',getVendorUserId())
                        ->get()
                        ->getRowArray();
        return $sql;
    }

    public function addProductInCompaign($compaign_id,$product_id)
    {
        if ( empty( $this->getProductInCompaign($compaign_id,$product_id) ) ) {
            return $this->db->table('products_vendor')
                            ->set('compaign_id',$compaign_id)
                            ->set('product_id',$product_id)
                            ->set('vendors_id',getVendorUserId())
                            ->set('compaign_status',1)
                            ->set('created_at',date('Y-m-d H:i:s'))
                            ->insert();
        }
    }


    public function removeProductInCompaign($compaign_id,$product_id)
    {
        if ( !empty( $this->getProductInCompaign($compaign_id,$product_id) ) ) {
            return $this->db->table('products_vendor')->where(['compaign_id' => $compaign_id, 'product_id' => $product_id, 'vendors_id' => getVendorUserId()])->delete();
        }
    }

    public function getProductInCompaign($compaign_id,$product_id)
    {
        return $this->db->table('products_vendor')
                        ->where('compaign_id',$compaign_id)
                        ->where('product_id',$product_id)
                        ->where('vendors_id',getVendorUserId())
                        ->get()
                        ->getRowArray();
    }

    public function getCompaignProductsToshow($com_id)
    {
        $result = $this->db->table('products_vendor')
                              ->select('products.id, products.name as product_name, products.cover, product_detail.final_price as worth')
                              ->join('products','products.id=products_vendor.product_id')
                              ->join('product_detail','product_detail.product_id=products_vendor.product_id')
                              // ->where('compain_players_entry.play_id',$game_id)
                              // ->where('compain_players_entry.product_id',$pid)
                              ->where('products_vendor.compaign_id',$com_id)
                              ->limit(10)
                              ->get()
                              ->getResultArray();
        return $result;
    }

    public function getBrandLogo($pid)
    {
        $result = $this->db->table('products')
                              ->select('vendor.store_logo as logo')
                              ->join('vendor','vendor.id=products.store_id')
                              ->where('products.id',$pid)
                              ->get()
                              ->getRowArray();
        // echo $this->db->getLastQuery();
        // exit;

        
        return $result['logo'];
    }


    /*
    *   Get Wheels
    */
    public function getWheels()
    {
        $sql = $this->db->table('wheels')
                        ->get()
                        ->getResultArray();
        return $sql;
    }

    public function getWheelsById($id)
    {
        $sql = $this->db->table('wheels')
                        ->where('id',$id)
                        ->get()
                        ->getRowArray();
                        unset($sql['id']);

        return $sql;
    }

    public function getWheelsPoints($id)
    {
        $sql = $this->db->table('wheels_points')
                        ->where('id',$id)
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return $sql;
        }
        return 0;
    }

    public function updateWheelData($ids,$data=[])
    {
        $dbs = $this->db->table('wheels');
        foreach( $data as $d => $v ) {   
            $box = 'box_'.$d;
            $dbs->set($box,filtreData($v));
        }
        $dbs->where('id',$ids)->update();
    }

    public function updateWheelPointsData($ids,$data=[])
    {
        $dbs = $this->db->table('wheels_points');
        foreach( $data as $d => $v ) {   
            $box = 'points_'.$d;
            $dbs->set($box,filtreData($v));
        }
        $dbs->where('id',$ids)->update();
    }

    public function updateWheelNextData($ids,$data)
    {
        $dbs = $this->db->table('wheels_next');
        $dbs->set('box_id',filtreData($data));
        $dbs->where('id',$ids)->update();
    }

    public function getWheelNextData($ids,$data)
    {
        $dbs = $this->db->table('wheels_next')
                        ->where('box_id',filtreData($data))
                        ->where('id',$ids)
                        ->get()
                        ->getRowArray();
        if ( !empty($dbs) ) {
            return true;
        }
        return false;
    }

    public function getWheelPointsList($id,$value)
    {
        $points = $this->getWheelsPoints($id);
        switch ($value) {
            case 'box_1':
                    return $points['points_1'];
                break;
            
            case 'box_2':
                    return $points['points_2'];
                break;
                
            case 'box_3':
                    return $points['points_3'];
                break;
                
            case 'box_4':
                    return $points['points_4'];
                break;
                
            case 'box_5':
                    return $points['points_5'];
                break;
                
            case 'box_6':
                    return $points['points_6'];
                break;
                
            case 'box_7':
                    return $points['points_7'];
                break;
                
            case 'box_8':
                    return $points['points_8'];
                break;
                
            case 'box_9':
                    return $points['points_9'];
                break;
                
            case 'box_10':
                    return $points['points_10'];
                break;
                
            case 'box_11':
                    return $points['points_11'];
                break;
                
            case 'box_12':
                    return $points['points_12'];
                break;
                
            case 'box_13':
                    return $points['points_13'];
                break;
                
            case 'box_14':
                    return $points['points_14'];
                break;
                
            case 'box_15':
                    return $points['points_15'];
                break;
                
            case 'box_16':
                    return $points['points_16'];
                break;
            case 'box_17':
                    return $points['points_17'];
                break;

            default:
                // code...
                break;
        }
    }

    public function insertCompaingGame($user_id,$com_id,$store_id,$pid)
    {
        $db = \Config\Database::connect();
        if( $this->getCompaingGame($user_id,$com_id,$store_id,$pid) == 0 ) {
            $sql = $db->table('compain_players')
                            ->set('user_id',$user_id)
                            ->set('com_id',my_decrypt($com_id))
                            ->set('store_id',my_decrypt($store_id))
                            ->set('pid',my_decrypt($pid))
                            ->set('play_date',date('Y-m-d'))
                            ->set('created_at',date('Y-m-d H:i:s'))
                            ->insert();
            return $db->insertID() ;
        } else {
            return $this->getCompaingGame($user_id,$com_id,$store_id,$pid);
        }
    }

    public function getCompaingGame($user_id,$com_id,$store_id,$pid)
    {
            $sql = $this->db->table('compain_players')
                            ->set('user_id',$user_id)
                            ->set('com_id',my_decrypt($com_id))
                            ->set('store_id',my_decrypt($store_id))
                            ->set('pid',my_decrypt($pid))
                            ->get()
                            ->getRowArray();
            if ( !empty($sql) ) {
                return $sql['id'];
            }
            return 0;
    }

    public function insertCompaingGameREsult($wheel_id,$play_id,$play_coins,$result_value,$result_win, $pid, $wand_gained, $wand_consumed, $power_wand_gained, $power_wand_consumed, $level_no)
    {
        if($power_wand_gained > 0){
            $this->db->table('power_wands')
                    ->set('user_id',getUserId())
                    ->set('wand', $power_wand_gained)
                    ->set('description', "{$power_wand_gained} power wands gained")
                    ->insert();
        }

        if($power_wand_consumed > 0){
            $this->db->table('power_wands')
                    ->set('user_id',getUserId())
                    ->set('wand', "-{$power_wand_consumed}")
                    ->set('description', "{$power_wand_consumed} power wands consumed")
                    ->insert();
        }

        if($wand_gained > 0){
            $this->db->table('wands')
                    ->set('user_id',getUserId())
                    ->set('wand', $wand_gained)
                    ->set('description', "{$wand_gained} wands gained")
                    ->insert();
        }

        if($wand_consumed > 0){
            $this->db->table('wands')
                    ->set('user_id',getUserId())
                    ->set('wand', "-{$wand_consumed}")
                    ->set('description', "{$wand_consumed} wands consumed")
                    ->insert();
        }
        if(is_numeric($result_win)){
            $result_win = $result_win + $wand_gained;
        }
        $insert = $this->db->table('compain_players_entry')
                        ->set('wheel_id',$wheel_id)
                        ->set('com_id',$play_id)
                        ->set('play_coins',$play_coins)
                        ->set('result_value',$result_value)
                        ->set('result_win',$result_win)
                        // ->set('product_id',$pid)
                        ->set('spree_id',$pid)
                        ->set('player_id',getUserId())
                        ->set('created_at', date('Y-m-d'))
                        ->insert();
        if($level_no != 0){
            $this->db->table('compain_players_entry')
                            ->set('level_number',$level_no)
                            ->where('com_id',$play_id)
                            ->where('spree_id',$pid)
                            ->where('player_id',getUserId())
                            ->update();
        }
        return $insert;
    }

    public function insertGameDate($wheel,$getpp,$com_id,$store_id,$pid,$wheelplayvalue, $sign='', $wand_gained, $wand_consumed, $power_wand_gained, $power_wand_consumed, $level_no)
    {
        $points = $this->getWheelPointsList($wheel,$getpp);
        // echo $points;exit;
        // $game_id = $this->insertCompaingGame(getUserId(),$com_id,$store_id,$pid);
        // $play_id = $game_id;
        $play_id = my_decrypt($com_id);
        $result = [];
        switch ($points) {
            case 'LOSE':
                // code...
                    $this->insertCompaingGameREsult($wheel,$play_id,$wheelplayvalue,$points,0, my_decrypt($pid), $wand_gained, $wand_consumed, $power_wand_gained, $power_wand_consumed, $level_no);
                    $result[] = ['p' => 0, 's' => 0, 'l' => 1,'points_result' => 0,'play' => $this->getZapptaPlay($wheel, my_decrypt($pid)),'win' => $this->getZapptaWinPlay($wheel, my_decrypt($pid)),'total' =>  $this->getTotalResult($wheel, my_decrypt($pid)) ,'balance' => userTotalZappta(),'com_id' => my_decrypt($com_id)];
                break;
            
            case 'STRIKE':
                // code...
                    $this->insertCompaingGameREsult($wheel,$play_id,$wheelplayvalue,$points,0, my_decrypt($pid), $wand_gained, $wand_consumed, $power_wand_gained, $power_wand_consumed, $level_no);
                    $result[] = ['p' => 0, 's' =>  $this->getTotlStrike(), 'l' => 0,'points_result' => 0,'play' => $this->getZapptaPlay($wheel, my_decrypt($pid)),'win' => $this->getZapptaWinPlay($wheel, my_decrypt($pid)),'total' =>  $this->getTotalResult($wheel, my_decrypt($pid)),'balance' => userTotalZappta(),'com_id' => my_decrypt($com_id)];
                break;

            case 'POWERUP':
                // code...
                    // $this->insertCompaingGameREsult($wheel,$play_id,$wheelplayvalue,$points,0, my_decrypt($pid), $wand_gained, $wand_consumed, $power_wand_gained, $power_wand_consumed, $level_no);
                    $this->insertCompaingGameREsult($wheel,$play_id,0,$points,0, my_decrypt($pid), $wand_gained, $wand_consumed, $power_wand_gained, $power_wand_consumed, $level_no);
                    $result[] = ['p' => 1, 's' => 0, 'l' => 0,'play' => $this->getZapptaPlay($wheel, my_decrypt($pid)),'points_result' => 0,'win' => $this->getZapptaWinPlay($wheel, my_decrypt($pid)),'total' => $this->getTotalResult($wheel, my_decrypt($pid)),'balance' => userTotalZappta(),'com_id' => my_decrypt($com_id)];
                break;

            case 'EVEN':
                // echo $this->getZapptaWinPlay($wheel, my_decrypt($pid));
                $this->insertCompaingGameREsult($wheel,$play_id,$wheelplayvalue,$points,0, my_decrypt($pid), $wand_gained, $wand_consumed, $power_wand_gained, $power_wand_consumed, $level_no);
                $result[] = ['p' => 1, 's' => 0, 'l' => 0,'play' => $this->getZapptaPlay($wheel, my_decrypt($pid)),'points_result' => 0,'win' => $this->getZapptaWinPlay($wheel, my_decrypt($pid)),'total' => $this->getTotalResult($wheel, my_decrypt($pid)),'balance' => userTotalZappta(),'com_id' => my_decrypt($com_id)];
                break;
            case 'HALF':
                $score = $this->getZapptaWinPlay($wheel, my_decrypt($pid))/2;
                $this->insertCompaingGameREsult($wheel,$play_id,$wheelplayvalue,$points,-$score, my_decrypt($pid), $wand_gained, $wand_consumed, $power_wand_gained, $power_wand_consumed, $level_no);
                $result[] = ['p' => 1, 's' => 0, 'l' => 0,'play' => $this->getZapptaPlay($wheel, my_decrypt($pid)),'points_result' => 0,'win' => $this->getZapptaWinPlay($wheel, my_decrypt($pid)),'total' => $this->getTotalResult($wheel, my_decrypt($pid)),'balance' => userTotalZappta(),'com_id' => my_decrypt($com_id)];
                break;
            case 'DOUBLE':
                $score = $this->getZapptaWinPlay($wheel, my_decrypt($pid))*2;
                $this->insertCompaingGameREsult($wheel,$play_id,$wheelplayvalue,$points,$score, my_decrypt($pid), $wand_gained, $wand_consumed, $power_wand_gained, $power_wand_consumed, $level_no);
                $result[] = ['p' => 1, 's' => 0, 'l' => 0,'play' => $this->getZapptaPlay($wheel, my_decrypt($pid)),'points_result' => 0,'win' => $this->getZapptaWinPlay($wheel, my_decrypt($pid)),'total' => $this->getTotalResult($wheel, my_decrypt($pid)),'balance' => userTotalZappta(),'com_id' => my_decrypt($com_id)];
                break;
            default:
                    $points = str_replace('X', '', $points);
                    if($sign == '*'){
                        $points_result = ($points * $wheelplayvalue);
                    }

                    if($sign == '+'){
                        $points_result = ($points + $wheelplayvalue);
                    }
                    $this->insertCompaingGameREsult($wheel,$play_id,$wheelplayvalue,$points,$points_result, my_decrypt($pid), $wand_gained, $wand_consumed, $power_wand_gained, $power_wand_consumed, $level_no);
                    $result[] = ['p' => 0, 's' => 0, 'l' => 0,'play' => $this->getZapptaPlay($wheel, my_decrypt($pid)),'points_result' => $points_result ,'win' => $this->getZapptaWinPlay($wheel, my_decrypt($pid)),'total' => $this->getTotalResult($wheel, my_decrypt($pid)) ,'balance' => userTotalZappta(),'com_id' => my_decrypt($com_id)];
                break;
        }
        return $result;
    }


    // public function getZapptaPlay($wheel_id=1, $pid='')
    // {
    //     $sql = $this->db->table('compain_players_entry')
    //                     ->select('SUM(play_coins) AS play_coins')
    //                     // ->where('wheel_id', $wheel_id)
    //                     ->where('product_id', $pid)
    //                     ->where('is_deleted', 0)
    //                     ->where('player_id', getUserId())
    //                     ->get()
    //                     ->getRowArray();
    //     if ( !empty($sql) ) {
    //         return $sql['play_coins'];
    //     }        
    //     return 0;
    // }

    public function getZapptaPlay($wheel_id=1, $spree_id='')
    {
        $sql = $this->db->table('compain_players_entry')
                        ->select('SUM(play_coins) AS play_coins')
                        // ->where('wheel_id', $wheel_id)
                        ->where('spree_id', $spree_id)
                        ->where('is_deleted', 0)
                        ->where('player_id', getUserId())
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return $sql['play_coins'];
        }        
        return 0;
    }

    public function getZapptaSpent()
    {
        $sql = $this->db->table('compain_players_entry')
                        ->select('SUM(play_coins) AS play_coins')
                        ->where('player_id', getUserId())
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return $sql['play_coins'];
        } 
        return 0;
    }
    
    // public function getZapptaWinPlay($wheel_id=1, $pid='')
    // {
    //     $sql = $this->db->table('compain_players_entry')
    //                     ->select('SUM(result_win) AS result_win')
    //                     // ->where('wheel_id', $wheel_id)
    //                     ->where('product_id', $pid)
    //                     ->where('is_deleted', 0)
    //                     ->where('player_id', getUserId())
    //                     ->get()
    //                     ->getRowArray();
    //     if ( !empty($sql) ) {
    //         return $sql['result_win'];
    //     }        
    //     return 0;
    // }

    public function getZapptaWinPlay($wheel_id=1, $spree_id='')
    {
        $sql = $this->db->table('compain_players_entry')
                        ->select('SUM(result_win) AS result_win')
                        // ->where('wheel_id', $wheel_id)
                        ->where('spree_id', $spree_id)
                        ->where('is_deleted', 0)
                        ->where('player_id', getUserId())
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return $sql['result_win'];
        }        
        return 0;
    }

    // public function getTotalResult($wheel_id=1, $pid='')
    // {
    //     // return ($this->getZapptaPlay($wheel_id) + $this->getZapptaWinPlay($wheel_id));
    //     return $this->getZapptaWinPlay($wheel_id, $pid);
    // }
    public function getTotalResult($wheel_id=1, $spree_id='')
    {
        // return ($this->getZapptaPlay($wheel_id) + $this->getZapptaWinPlay($wheel_id));
        return $this->getZapptaWinPlay($wheel_id, $spree_id);
    }

    // public function getTotlStrike($wheel_id=1, $com_e_date='', $com_s_date='', $pid='')
    // {
    //     if(!$com_e_date && !$com_s_date){
    //         $sql = $this->db->table('compain_players_entry')
    //                     ->selectCount('id')
    //                     // ->where('wheel_id', $wheel_id)
    //                     ->where('player_id', getUserId())
    //                     ->where('result_value','STRIKE')
    //                     ->where('is_deleted', 0)
    //                     // ->where('product_id',$pid)
    //                     ->where('created_at', date('Y-m-d'))
    //                     ->get()
    //                     ->getRowArray();
    //     }else{
    //         $sql = $this->db->table('compain_players_entry')
    //                     ->selectCount('id')
    //                     // ->where('wheel_id', $wheel_id)
    //                     ->where('player_id', getUserId())
    //                     ->where('result_value','STRIKE')
    //                     ->where('is_deleted', 0)
    //                     ->where('product_id',$pid)
    //                     ->where('created_at between "'.$com_s_date.'" AND "'.$com_e_date.'"')
    //                     ->get()
    //                     ->getRowArray();
    //     }


        public function getTotlStrike($wheel_id=1, $com_e_date='', $com_s_date='', $spree_id='')
        {
            if(!$com_e_date && !$com_s_date){
                $sql = $this->db->table('compain_players_entry')
                            ->selectCount('id')
                            // ->where('wheel_id', $wheel_id)
                            ->where('player_id', getUserId())
                            ->where('result_value','STRIKE')
                            ->where('is_deleted', 0)
                            // ->where('product_id',$pid)
                            ->where('created_at', date('Y-m-d'))
                            ->get()
                            ->getRowArray();
            }else{
                $sql = $this->db->table('compain_players_entry')
                            ->selectCount('id')
                            // ->where('wheel_id', $wheel_id)
                            ->where('player_id', getUserId())
                            ->where('result_value','STRIKE')
                            ->where('is_deleted', 0)
                            ->where('spree_id',$spree_id)
                            ->where('created_at between "'.$com_s_date.'" AND "'.$com_e_date.'"')
                            ->get()
                            ->getRowArray();
            }

            if ( !empty($sql) ) {
                return $sql['id'];
            }        
            return 0;
        }

    public function getTotlStrikeByUser($user,$wheel_id=1, $pid)
    {
        $sql = $this->db->table('compain_players_entry')
                        ->selectCount('id')
                        ->where('player_id', $user)
                        // ->where('wheel_id', $wheel_id)
                        // ->where('product_id', $pid)
                        ->where('spree_id', $pid)
                        ->where('is_deleted', 0)
                        ->where('result_value','STRIKE')
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return $sql['id'];
        }        
        return 0;
    }

    public function getZapptaWinPlayById($user,$wheel_id=1, $pid)
    {
        $sql = $this->db->table('compain_players_entry')
                        ->select('SUM(result_win) AS result_win')
                        // ->where('wheel_id', $wheel_id)
                        // ->where('product_id', $pid)
                        ->where('spree_id', $pid)
                        ->where('is_deleted', 0)
                        ->where('player_id', $user)
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return $sql['result_win'];
        }        
        return 0;
    }

    public function getUserCompaignResult($wheel,$com_id,$store_id='',$pid)
    {
        // $game_id = $this->getCompaingGame(getUserId(),$com_id,$store_id,$pid);
        $result = [];
        $user_data = $this->db->table('compain_players_entry')
                              ->select('compain_players_entry.*, SUM(result_win),register.username')
                              ->join('register','register.id=compain_players_entry.player_id')
                              // ->where('compain_players_entry.play_id',$game_id)
                            //   ->where('compain_players_entry.product_id',$pid)
                              ->where('compain_players_entry.spree_id',$pid)
                                ->where('compain_players_entry.is_deleted', 0)
                                ->where('compain_players_entry.com_id',my_decrypt($com_id))
                              ->groupBy('compain_players_entry.player_id')
                              ->orderBy('compain_players_entry.result_win DESC')
                            //   ->limit(10)
                              ->get()
                              ->getResultArray();

                              
        if ( is_array($user_data) && count($user_data) > 0 ) {
            // $sr = 1;
            foreach( $user_data as $data ) {
                $result[] = [
                            // 'sr' => $sr,
                            'player_id' => my_encrypt($data['player_id']),
                            'is_player' => getUserId() == $data['player_id']?true:false,
                            'score' => $this->getZapptaWinPlayById($data['player_id'],$wheel, $pid),
                            'fname' => $data['username'],
                            'strikes' => $this->getTotlStrikeByUser($data['player_id'],$wheel, $pid),
                        ];
                // $sr++;
            }
        }
        return $result;
    }

    public function getLatestCompaign()
    {
        $compaign = $this->db->table('compain')->orderBy('id', 'desc')->limit(1)->get()->getRow();
        return $compaign;
    }

    public function getUpcomingCompaigns()
    {
        $compaigns = $this->db->table('compain')->where('compain_s_date > ', date('Y-m-d'))->orderBy('id', 'desc')->get()->getResultArray();
        // echo $this->db->getLastQuery();exit;
        return $compaigns;
    }

}

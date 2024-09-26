<?php 

namespace App\Models;

use CodeIgniter\Model; 

/**
 * 	Setting Model for update Setting
 */
class StatsModel extends Model
{
	
	protected $DBGroup  = 'default';

    public function getTotalRevenue()
    {
        $db = $this->db->table('order')
                       ->select('SUM(total_amount) as totalAmount')
                       ->get()
                       ->getResult();
        return number_format($db[0]->totalAmount,2);
    }

    public function getTotalOrders()
    {
        $db = $this->db->table('order')
                       ->select('COUNT(*) as totalCount')
                       ->get()
                       ->getResult();
        return $db[0]->totalCount;
    }

    public function getTotalGiveaways()
    {
        $db = $this->db->table('compain_vendors')
                       ->select('COUNT(*) as totalCount')
                       ->get()
                       ->getResult();
        return $db[0]->totalCount;
    }

    public function getTotalStores()
    {
        $db = $this->db->table('vendor')
                       ->select('COUNT(*) as totalCount')
                       ->where('deleteStatus', '0')
                       ->get()
                       ->getResult();
        return $db[0]->totalCount;
    }

    public function lastMonthsRevenue($month=6)
    {
        $db = $this->db->table('order')
                       ->select("SUM(total_amount) AS revenue, DATE_FORMAT(created_at, '%M') AS month")
                       ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
                       ->get()
                       ->getResult();
        return array_slice($db, -$month);
    }

    public function lastMonthsVisitors($month=6)
    {
        $db = $this->db->table('register')
                       ->select("COUNT(*) AS visitors, DATE_FORMAT(created_at, '%M') AS month")
                       ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
                       ->get()
                       ->getResult();
        return array_slice($db, -$month);
    }

    public function getSalesReport($limit=15)
    {
        $stores = $this->db->table('order_items')
                       ->select('SUM(cms_order_items.subtotal) AS sales, order_items.store_id, vendor.store_name, vendor.store_link, vendor.store_logo')
                       ->join('vendor','vendor.id=order_items.store_id')
                       ->where(['order_items.item_status' => 0, 'vendor.deleteStatus' => 0])
                       ->groupBy('store_id')
                       ->orderBy('sales', 'DESC')
                       ->limit($limit)
                       ->get()
                       ->getResult();
        for ($i=0; $i < count($stores); $i++) { 
            $stores[$i]->pending = $this->db->table('order_items')
                                    ->select('*')
                                    ->where(['item_status' => '0', 'store_id' => $stores[$i]->store_id])
                                    ->get()
                                    ->getNumRows();
            $stores[$i]->delivered = $this->db->table('order_items')
                                    ->select('*')
                                    ->where(['item_status != ' => '0', 'store_id' => $stores[$i]->store_id])
                                    ->get()
                                    ->getNumRows();
            // $stores[$i]->sales = $this->db->table('order_items')
            //                         ->select('*')
            //                         ->where(['item_status != ' => '0', 'store_id' => $stores[$i]->store_id])
            //                         ->getNumRows();
        }
        return $stores;
    }

    public function giveawaysReport($limit = 10)
    {
        return json_encode([]);
        $stores = $this->db->table('compain')
                ->select('vendor.store_name, compain_vendors.compaign_id, compain_vendors.vendor_id, compain.compain_name, compain.compain_e_date')
                ->join('compain_vendors','compain.id = compain_vendors.compaign_id')
                ->join('vendor','vendor.id = compain_vendors.vendor_id')
                ->where(['compain.compain_e_date >= ' => 'CURDATE()',  'compain.active' => 1, 'vendor.deleteStatus' => 0])
                ->get()
                ->getResult();
        for ($i=0; $i < count($stores) ; $i++) { 
            $stores[$i]->compain_e_date = date('d, M-Y h:i a', strtotime($stores[$i]->compain_e_date));
            $pro = $this->db->table('products_vendor')
                ->select('cms_products.id, cms_products.name, cms_product_detail.final_price')
                // ->join('products','products.id = products_vendor.product_id')
                ->join('product_detail','products.id = product_detail.product_id')
                ->where(['products_vendor.compaign_id' => $stores[$i]->compaign_id,  'products_vendor.vendors_id' => $stores[$i]->vendor_id, "products.deleteStatus" => 0])
                ->get()
                ->getResult();
            for($j = 0; $j < count($pro); $j++){
                $result = [];
                $user_data = $this->db->table('compain_players_entry')
                                      ->select('compain_players_entry.*, SUM(result_win),register.username')
                                      ->join('register','register.id=compain_players_entry.player_id')
                                      ->where('compain_players_entry.product_id',$pro[$j]->id)
                                        ->where('compain_players_entry.is_deleted', 0)
                                        ->where('compain_players_entry.com_id',$stores[$i]->compaign_id)
                                      ->groupBy('compain_players_entry.player_id')
                                      ->orderBy('compain_players_entry.result_win DESC')
                                      ->get()
                                      ->getResultArray();
        
                                      
                if ( is_array($user_data) && count($user_data) > 0 ) {
                    foreach( $user_data as $data ) {
                        $result[] = [
                                    'score' => (new \App\Models\CompainModel())->getZapptaWinPlayById($data['player_id'],1, $pro[$j]->id),
                                    'fname' => $data['username'],
                                ];
                    }
                    usort($result, function ($item1, $item2) {
                        return $item2['score'] <=> $item1['score'];
                    });
                    $pro[$j]->participants = count($result);
                    $pro[$j]->winner = $result[0];
                }else{
                    $pro[$j]->participants = 0;
                    $pro[$j]->winner = null;
                }
            }
            
            $stores[$i]->products = $pro;
        }
        return json_encode($stores);
    }

    public function getTotalDailyRevenue()
    {
        $dates = date('Y-m-d');
        $db = $this->db->table('order')
                       ->select('SUM(total_amount) as totalAmount')
                       ->where('created_at >=',$dates)
                       ->get()
                       ->getResult();
        return number_format($db[0]->totalAmount,2);
    }

    public function getTotalCustomer()
    {
        $db = $this->db->table('register')
                       ->select('COUNT(id) as totalAmount')
                       ->get()
                       ->getResult();
        return $db[0]->totalAmount;
    }

    public function getTotalDailyCustomer()
    {
        $dates = date('Y-m-d H:i:s');
        $db = $this->db->table('register')
                       ->select('COUNT(id) as totalAmount')
                       ->where('created_at',$dates)
                       ->get()
                       ->getResult();
        return $db[0]->totalAmount;
    }

    public function getSalesByCategory()
    {
        $result = [];
        $db = $this->db->table('categories')
                       ->select('categories.cat_img,categories.cat_name,categories.id as cid')
                       ->limit(5)
                       ->get()
                       ->getResult();
        if(is_array($db)){               
            foreach($db as $d){
                $result[] = [ 
                                'catId' => $d->cid ,
                                'name' => $d->cat_name,
                                'subtotal' => $this->getSalesBySingleCategory($d->cid),
                                'fimg' => $d->cat_img,
                            ];    
            }   
            return $result;
        }      
        return NULL;  
    }

    public function getSalesBySingleCategory($catid)
    {
        $db = $this->db->table('product_category')
                       ->select('SUM(subtotal) as subtotal')
                       ->join('order_items','order_items.item_id=product_category.product_id')
                       ->where('product_category.catid',$catid)
                       ->get()
                       ->getResult();
        return $db[0]->subtotal;               
    }

    public function getLatestOrder()
    {
        $db = $this->db->table('order')
                       ->where('status >',0)
                       ->limit(4)
                       ->orderBy('created_at DESC')
                       ->get()
                       ->getResult();
        if(is_array($db)){
            $result = [];               
            foreach($db as $d){
                $result[] = [ 
                                'catId' => $d->id ,
                                'status' => $d->status,
                                'dates' => date('d F Y H:i A'),
                                'totalItem' => $this->getTotalOrderItem($d->id),
                                'totalAmount' => $d->total_amount,
                                'fimg' => $this->getTotalOrderSingleItem($d->id),
                            ];    
            }   
            return $result;
        }      
        return NULL; 
    }

    public function getTotalOrderItem($order_id)
    {
        $db = $this->db->table('order_items')
                       ->select('COUNT(id) as ids')
                       ->where('order_id',$order_id)
                       ->get()
                       ->getResult();
        return $db[0]->ids; 
    }
    public function getTotalOrderSingleItem($order_id)
    {
        $db = $this->db->table('order_items')
                       ->where('order_id',$order_id)
                       ->limit(1)
                       ->get()
                       ->getRow();
        return $this->getFirstImage($db->item_id); 
    }

    public function getFirstImage($product_id)
    {
        $db = $this->db->table('product_img')
                        ->where('product_id',$product_id)
                        ->limit(1)
                        ->get()
                        ->getRow();
        if(!empty($db)){
            return getImageThumg('gallery',$db->fimg,100);
        }
        return false;
    }

    public function getTotalProfit()
    {
        $result = [];
        $months = array("1","2","3","4","5","6","7", "8","9","10","11","12");
        foreach($months as $mon){
            $result[] = $this->getOrderProfit($mon);
        }
        return implode(',',$result);
    }

    public function getOrderProfit($month)
    {
        $db = $this->db->table('order')
                       ->select('COUNT(id) as total_order, SUM(total_amount) as totalAmount,  YEAR(created_at) as Order_year, MONTH(created_at) as Order_month')
                       ->where('MONTH(created_at)',$month)
                       ->get()
                       ->getRow();
        return $db->totalAmount;
    }

    public function getTotalShipping()
    {
        $result = [];
        $months = array("1","2","3","4","5","6","7", "8","9","10","11","12");
        foreach($months as $mon){
            $result[] = $this->getOrderShipping($mon);
        }
        return implode(',',$result);
    }

    public function getOrderShipping($month)
    {
        $db = $this->db->table('order')
                       ->select('COUNT(id) as total_order, SUM(shipping) as shipping,  YEAR(created_at) as Order_year, MONTH(created_at) as Order_month')
                       ->where('MONTH(created_at)',$month)
                       ->get()
                       ->getRow();
        return $db->shipping;
    }

    public function getTotalDiscount()
    {
        $result = [];
        $months = array("1","2","3","4","5","6","7", "8","9","10","11","12");
        foreach($months as $mon){
            $result[] = $this->getOrderDiscount($mon);
        }
        return implode(',',$result);
    }

    public function getOrderDiscount($month)
    {
        $db = $this->db->table('order')
                       ->select('COUNT(id) as total_order, SUM(discount) as discount,  YEAR(created_at) as Order_year, MONTH(created_at) as Order_month')
                       ->where('MONTH(created_at)',$month)
                       ->get()
                       ->getRow();
        return $db->discount;
    }

    public function getCityOrder()
    {
        $db = $this->db->table('country_city')
                       ->get()
                       ->getResult();
        if(is_array($db)) {
            $result = [];
            foreach($db as $d){
                $name = $d->name;
                $result[] = ['name' => $name, 'total' => $this->getCityOrderCount($d->id)];
            }
            return $result;
        }
        return NULL;
    }

    public function getCityOrderCount($id)
    {
        $db = $this->db->table('address')
                       ->select('COUNT(order_id) as subtotal')
                       ->join('order_address','order_address.address_id=address.id')
                       // ->where('address.city',$id)
                       ->get()
                       ->getResult();
        return $db[0]->subtotal;               
    }


}
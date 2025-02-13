<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\ProductVoucherModel;
use App\Models\ProductModel;
use App\Models\Address;
use App\Models\RegisterModel;
use App\Models\TaxesModel;
use App\Models\UsersModel;

class OrderModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'order';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [ 
										'order_serial',
										'user_id',
										'final_subtotal',
										'total_amount',
										'discount',
										'shipping',
										'payment_method',
										'payment_confirmation',
										'payment_response',
										'platform',
										'status',
										'ip_address',
										'order_type',
										'order_message',
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

	public $bgColor = '#EE3186';

	public function getAllResult($limit=1)
    {
        $limits = 20;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        return $this->db->table($this->table)
        				->select('order.*,rg.fname,rg.username, rg.email, COUNT(DISTINCT(ot.order_id)) as total_orders, COUNT(DISTINCT(ot.store_id)) as total_stores ,ad.phone,order_address.address_id')
        				->join('register rg','rg.id=order.user_id','LEFT')
        				->join('order_address','order_address.order_id=order.id','LEFT')
        				->join('address ad','ad.id=order_address.address_id','LEFT')
        				->join('order_items ot','ot.order_id=order.id','LEFT')
        				->groupBy('order.id')
   						->limit($limits,$result_limit)
        				->get()
        				->getResultArray();
    }

	public function adminsearch($word)
    {
        return $this->db->table($this->table)
        				->select('order.*,rg.fname, COUNT(DISTINCT(ot.order_id)) as total_orders, COUNT(DISTINCT(ot.store_id)) as total_stores ,ad.phone,order_address.address_id')
        				->join('register rg','rg.id=order.user_id','LEFT')
        				->join('order_address','order_address.order_id=order.id','LEFT')
        				->join('address ad','ad.id=order_address.address_id','LEFT')
        				->join('order_items ot','ot.order_id=order.id','LEFT')
        				->like('order.order_serial',$word)
        				->groupBy('order.id')
   						->get()
        				->getResultArray();
    }

	public function getFilterAllResult($limit,$status=NULL)
    {
        return $this->where('status',$status)->orderBy('id DESC')->paginate($limit);
    }

    public function getTotalOrder()
    {
    	return $this->db->table($this->table)->countAllResults();
    }

	public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }


   	public function getAdminStoreOrderBYId($id)
   	{
   		$result = [];
    	$sql = $this->db->query('SELECT 
    								cms_order.id as pid,
    								cms_order.order_serial as order_serial,
    								cms_order.final_subtotal,
    								cms_order.total_amount,
    								cms_order.discount,
    								cms_order.shipping as shippingss,
    								cms_order.payment_method,
    								cms_order.payment_confirmation,
    								cms_order.payment_response,
    								cms_order.created_at as order_date,
    								cms_order_items.*,
    								cms_order_timeline.* ,
    								st.store_name as store_name
    							FROM cms_order 
    								LEFT JOIN cms_order_items on cms_order_items.order_id=cms_order.id 
    								LEFT JOIN cms_order_timeline on cms_order_timeline.order_id=cms_order.id 
    								INNER JOIN cms_vendor st on cms_order_items.store_id=st.id 
    							WHERE cms_order.id='.$id.'
    							AND cms_order.status > 0'
    						)
    					->getResultArray();
    	if ( is_array($sql) && count($sql) > 0 ) {
    		foreach ( $sql as $q => $val ) {
    			$result['order'] = [
    								'order_id' => $val['order_id'],
    								'order_serial' => $val['order_serial'],
    								'final_subtotal' => $val['final_subtotal'],
    								'total_amount' => $val['total_amount'],
									'discount' => $val['discount'],
    								'shipping' => $val['shippingss'],
									'payment_method' => $val['payment_method'],
    								'payment_confirmation' => $val['payment_confirmation'],
									'payment_response' => $val['payment_response'],
									'order_date' => $val['order_date'],
									'order_status' => $val['status'],
    							];
    			$result['items'][] = [
    									'store_name' => $val['store_name'],
										'item_id' => $val['item_id'],
										'item_name' => $val['item_name'],
										'qty' => $val['qty'],
										'price' => $val['price'],
										'shipping' => $val['shipping'],
										'item_image' => $val['item_image'],
										'item_status' => $val['item_status'],
										'vat' => $val['vat'],
										'subtotal' => $val['subtotal'],
										'attribute' => unserialize($val['attribute']),//(new \App\Models\AttributeValueModel())->getAttributeById(unserialize($val['attribute'])),
									];
    		}
    	}
    	return $result;
   	}
	
    public function updateOrderPrice($order_id,$final_subtotal,$total_amount,$shipping,$order_serial, $tax)
    {
      	$this->db->table($this->table)
			   	 ->set('final_subtotal',$final_subtotal)
			   	 ->set('total_amount',$total_amount)
			     ->set('shipping',$shipping)
			     ->set('order_serial',$order_serial)
				 ->set('tax',$tax)
			     ->where('id',$order_id)
			     ->update();
		return true;
    }

    private function getOrderById($id)
    {
        $user = $this->asArray()
                     ->where(['id' => $id])
                     ->first();
        if(!empty($user)) {    
            return $user;
        }
        return false;
    }

    public function AddOrderItems($data = [])
    {
    	$db = $this->db->table('order_items');
    	foreach($data as $field => $keys){
    		$db->set($field,$keys);
    	}
    	$db->insert();
    }

    public function updateOrderItems($order_id,$item_id,$item_status)
    {
	      $this->db->table('order_items')
				   ->set('item_status',$item_status)
				   ->where('order_id',$order_id)
				   ->where('item_id',$item_id)
				   ->update();
    }
    public function GetRecordOfPayments(){
           $query = $this->db->query('SELECT st.store_logo, st.store_name, st.id, SUM(o.price) AS total FROM cms_order_items o LEFT JOIN cms_vendor st ON st.id = o.store_id GROUP BY o.store_id');
           return $query->getResultArray();

    }

    public function GETrecordOfPaymentsAgain(){

           $query = $this->db->query('SELECT st.store_logo, st.store_name, SUM(o.price) AS total ,o.item_status FROM cms_order_items o LEFT JOIN cms_vendor st ON st.id = o.store_id where o.item_status != 0 GROUP BY o.store_id ');
           return $query->getResultArray();
    }

	/**
	 * Edit order address with updated data
	 * @param array $data
	 * @param integer $address_id
	 * @return void
	 * @author M Nabeel Arshad
	 * @since 2024-12-24
	 */
	public function editOrderAddress($data, $address_id) : void {
		(new Address())->update($address_id, $data);
	}

   	public function addOrderAddress($data = [],$type=1)
   	{
   		$post = [
   					'user_id' => getUserId(),
   					'first_name' => filtreData($data['first_name']),
   					'last_name' => filtreData($data['last_name']),
   					'company_name' => filtreData($data['company_name']),
   					'country' => filtreData($data['country']),
   					'stree_address' => filtreData($data['stree_address']),
   					'stree_address_optional' => filtreData($data['stree_address_optional']??null),
   					'town_city' => filtreData($data['town_city']),
   					'postcode' => filtreData($data['postcode']),
   					'phone' => filtreData($data['phone']),
   					'email' => filtreData($data['email']),
   					'type' => filtreData($type),
   				];
   		return (new Address())->add($post);
   	}
    
   	public function assignAddress($order_id,$address_id)
   	{
   		$this->db->table('order_address')
					 ->set('order_id',$order_id)
					 ->set('address_id',$address_id)
					 ->set('created_at',date('Y-m-d H:i:s'))
					 ->insert();
   	}

   	public function getOrderListByStores($limit=1)
   	{
        $limits = 20;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        $result=[];
   		$sql = $this->db->table('order_items')
   						->select('order_items.order_id,order_items.user_id,order_items.store_id as item_store_id,order.total_amount,order.payment_method,order.created_at,order_timeline.status as time_status,order_timeline.created_at as time_date')
   						->join('order','order.id=order_items.order_id','left')
   						->join('order_timeline','order_timeline.order_id=order_items.order_id','left')
   						->where('order_items.store_id',getVendorUserId())
   						->where('order_items.item_status >',0)
   						->groupBy('order_items.order_id')
   						->limit($limits,$result_limit)
   						->get()
   						->getResultArray();
   		if ( is_array($sql) && count($sql) > 0 ) {
   			foreach ($sql as $q) {
   				$address = $this->getUserAddress($q['order_id']);
   				$result[] = [
   								'order_id' => $q['order_id'],
   								'user_id' => $q['user_id'],
   								'store_id' => $q['item_store_id'],
   								'total' => $q['total_amount'],
   								'payment' =>  $q['payment_method'],
   								'created_at' =>  $q['created_at'],
   								'time_status' =>  orderCartOnAdminStatus($q['time_status']),
   								'time_date' =>  $q['time_date'],
   								'address' => $address,
   							];
   			}
   			return $result;
   		}
   		return 0;
   	}

   	public function getStoreOrderBYId($id)
   	{
   		$result = [];
    	$sql = $this->db->query('SELECT cms_order.id as pid,cms_order.order_serial,cms_order.total_amount,cms_order.discount,cms_order.shipping,cms_order.payment_method,cms_order.payment_confirmation,cms_order.payment_response,cms_order.created_at as order_date,cms_order_items.* FROM cms_order INNER JOIN cms_order_items on cms_order_items.order_id=cms_order.id  WHERE cms_order_items.store_id='.getVendorUserId().' AND cms_order.id='.$id.' AND cms_order.status > 0')
    					->getResultArray();
    	if ( is_array($sql) && count($sql) > 0 ) {
    		foreach ( $sql as $q => $val ) {
    			$result['order'] = [
    								'order_serial' => $val['order_serial'],
    								'order_id' => $val['order_id'],
    								'total_amount' => $val['total_amount'],
									'discount' => $val['discount'],
    								'shipping' => $val['shipping'],
									'payment_method' => $val['payment_method'],
    								'payment_confirmation' => $val['payment_confirmation'],
									'payment_response' => $val['payment_response'],
									'order_date' => $val['order_date'],
    							];
    			$result['items'][] = [
													'item_id' => $val['item_id'],
													'item_name' => $val['item_name'],
													'qty' => $val['qty'],
													'price' => $val['price'],
													'shipping' => $val['shipping'],
													'item_image' => $val['item_image'],
													'vat' => $val['vat'],
													'subtotal' => $val['subtotal'],
													'time_item_status' => $val['item_status'],
													'attribute' => (new \App\Models\AttributeValueModel())->getAttributeById(unserialize($val['attribute'])),
												];
    		}
    	}
    	return $result;
   	}

   	private function getOrderStatus($order_id,$item_id)
   	{
   		$sql = $this->db->table('order_timeline')
   						->where('order_id',$order_id)
   						->where('item_id',$item_id)
   						->get()
   						->getRowArray();
   		if ( !empty($sql) ) {
   			return $sql['status'];
   		}
   		return false;
   	}

   	public function getTotalStoreOrders()
   	{
   		return $this->db->table('order_items')
   						->where('store_id',getVendorUserId())
   						->groupBy('order_id')
   						->countAllResults();
   	}

    public function getUserAddress($order_id)
    {
        return  $this->db->table('order_address')
        				 ->select('address.first_name,address.last_name,address.country,address.stree_address,order_address.order_id,country.name')
	                     ->join('address','address.id=order_address.address_id')
	                     ->join('country','country.id=address.country')
	                     ->where('order_address.order_id',$order_id)
	                     ->get()
	                     ->getResultArray();
    }

    public function getUserAddressByOrder($order_id)
    {
        return  $this->db->table('order_address')
        				 ->select('address.*,order_address.*,country.name as country_name')
	                     ->join('address','address.id=order_address.address_id')
	                     ->join('country','country.id=address.country')
	                     ->where('order_address.order_id',$order_id)
	                     ->get()
	                     ->getResultArray();
    }

    public function addOrderTimelime($order_id,$status,$item_id=0)
    {
    	return $this->db->table('order_timeline')
				 		->set('order_id',$order_id)
				 		->set('status',$status)
				 		->set('item_id',$item_id)
				 		->set('type',1)
				 		->set('created_at',date('Y-m-d H:i:s'))
				 		->insert();
    }

    private function getAllOrderCompleteTimelime($order_id)
    {
    	$sql = $this->db->table('order_timeline')
				 		->where('order_id', $order_id)
				 		->limit(1)
				 		->orderBy('id DESC')
				 		->get()
				 		->getRowArray();
		if( !empty($sql) ) {
			return $sql;
		}
		return NULL;
    }
    
    public function getOrderTimelimeList($order_id)
    {
    	$sql = $this->db->table('order_timeline')
				 		->where('order_id', $order_id)
				 		->orderBy('id ASC')
				 		->get()
				 		->getResultArray();
		if( !empty($sql) ) {
			return $sql;
		}
		return NULL;
    }
    
    public function getUserTotalOrder()
    {
    	return $this->db->table($this->table)
    					->where('user_id',getUserId())
    					->countAllResults();
    }

    public function getUserOrderList($limit = 1, $order_id)
    {
        $limits = $_GET['limit'] ?? 10;
        $result_limit = 0;
		if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        $result = [];
		$where = $order_id ? ' AND cms_order.id = '.$order_id.' ' : null ;
    	$sql = $this->db->query('SELECT cms_order.id,
	    							cms_order.order_serial as order_serial,
	    							cms_order_items.id as item_row,
	    							cms_order_items.order_id as order_id,
	    							cms_order_items.item_id as item_id,
	    							cms_order_items.item_name,
	    							cms_order_items.item_image,
	    							cms_order_timeline.status,
	    							cms_order_timeline.created_at as status_date,
									cms_order.created_at as ordered_at,
									cms_order.final_subtotal,
									cms_order.total_amount,
									cms_order.discount,
									cms_order.shipping,
									cms_order.payment_method,
									cms_order.shipping,
									cms_order.order_serial,
									cms_order.tax
    							FROM (SELECT * FROM cms_order WHERE user_id='.getUserId().' AND cms_order.status > 0 '.$where.' ORDER BY id DESC  LIMIT '.$limits.' OFFSET '.$result_limit.' ) `cms_order` 
    							LEFT JOIN cms_order_items on cms_order_items.order_id=cms_order.id 
    							LEFT JOIN cms_order_timeline on cms_order_timeline.order_id=cms_order.id
    							WHERE cms_order.status > 0 '.$where.'
    							ORDER BY cms_order_items.order_id DESC')
    					->getResultArray();
    	if ( is_array($sql) && count($sql) > 0 ) {
    		foreach ( $sql as $q => $val ) {
    			$result['order'][$val['id']] = [
    								'id' => $val['id'],
    								'status' => $val['status'],
									'status_date' => $val['status_date'],
									'order_date' => $val['ordered_at'],
									'final_subtotal' => $val['final_subtotal'],
									'total_amount' => $val['total_amount'],
									'discount' => $val['discount'],
									'shipping' => $val['shipping'],
									'payment_method' => $val['payment_method'],
									'order_serial' => $val['order_serial'],
									'tax' => $val['tax'],
    							];
    			$result['items'][$val['id']][] = [
													'item_row' => $val['item_row'],
													'item_id' => $val['item_id'],
													'order_id' => $val['order_id'],
													'item_name' => $val['item_name'],
													'item_image' => $val['item_image'],
												];
    		}
    	}
    	return $result;
    }


    public function getUserSingleOrder($id)
    {
    	$result = [];
    	$sql = $this->db->query('SELECT cms_order.id as order_ids,
	    							cms_order.order_serial as order_serial,
	    							cms_order.final_subtotal,
	    							cms_order.total_amount,
	    							cms_order.discount,
	    							cms_order.shipping as oship,
	    							cms_order.payment_method,
	    							cms_order.payment_confirmation,
	    							cms_order.payment_response,
	    							cms_order.created_at as order_date,
	    							cms_vendor.store_name,
	    							cms_order_items.*,
									cms_order_items.item_id as items_id,
	    							cms_order_timeline.* 
    							FROM cms_order 
    								LEFT JOIN cms_order_items on cms_order_items.order_id=cms_order.id 
    								LEFT JOIN cms_order_timeline on cms_order_timeline.order_id=cms_order.id 
    								LEFT JOIN cms_vendor on cms_order_items.store_id=cms_vendor.id 
    							WHERE cms_order.user_id='.getUserId().' AND cms_order.id='.$id.' AND cms_order.status > 0')
    					->getResultArray();
    	if ( is_array($sql) && count($sql) > 0 ) {
    		foreach ( $sql as $q => $val ) {
    			$result['order'] = [
    								'order_id' => $val['order_ids'],
    								'order_serial' => $val['order_serial'],
    								'final_subtotal' => $val['final_subtotal'],
    								'total_amount' => $val['total_amount'],
									'discount' => $val['discount'],
    								'shipping' => $val['oship'],
									'payment_method' => $val['payment_method'],
    								'payment_confirmation' => $val['payment_confirmation'],
									'payment_response' => $val['payment_response'],
									'order_date' => $val['order_date'],
									'order_status' => $val['status'],
    							];
    			$result['items'][] = [
													'item_id' => $val['items_id'],
													'item_name' => $val['item_name'],
													'store_name' => $val['store_name'],
													'qty' => $val['qty'],
													'price' => $val['price'],
													'shipping' => $val['shipping'],
													'item_image' => $val['item_image'],
													'vat' => $val['vat'],
													'subtotal' => $val['subtotal'],
													'attribute' => unserialize($val['attribute']),//(new \App\Models\AttributeValueModel())->getAttributeById(unserialize($val['attribute'])),
												];
    		}
    	}
    	return $result;
    }

    public function getCheckoutUserSingleOrder($id)
    {
    	$result = [];
    	$sql = $this->db->query('SELECT cms_order.id as order_ids,
	    							cms_order.order_serial as order_serial,
	    							cms_order.final_subtotal,
	    							cms_order.total_amount,
	    							cms_order.tax,
	    							cms_order.discount,
	    							cms_order.shipping as oship,
	    							cms_order.payment_method,
	    							cms_order.payment_confirmation,
	    							cms_order.payment_response,
	    							cms_order.created_at as order_date,
	    							cms_order_items.*,
	    							cms_order_timeline.* 
    							FROM cms_order 
    								LEFT JOIN cms_order_items on cms_order_items.order_id=cms_order.id 
    								LEFT JOIN cms_order_timeline on cms_order_timeline.order_id=cms_order.id 
    							WHERE cms_order.user_id='.getUserId().' AND cms_order.id='.$id.'')
    					->getResultArray();
    	if ( is_array($sql) && count($sql) > 0 ) {
    		foreach ( $sql as $q => $val ) {
    			$result['order'] = [
    								'order_id' => $val['order_ids'],
    								'order_serial' => $val['order_serial'],
    								'final_subtotal' => $val['final_subtotal'],
    								'total_amount' => $val['total_amount'],
    								'tax' => $val['tax'],
									'discount' => $val['discount'],
    								'shipping' => $val['oship'],
									'payment_method' => $val['payment_method'],
    								'payment_confirmation' => $val['payment_confirmation'],
									'payment_response' => $val['payment_response'],
									'order_date' => $val['order_date'],
									'order_status' => $val['status'],
    							];
    			$result['items'][] = [
													'item_id' => $val['item_id'],
													'item_name' => $val['item_name'],
													'qty' => $val['qty'],
													'price' => $val['price'],
													'shipping' => $val['shipping'],
													'item_image' => $val['item_image'],
													'vat' => $val['vat'],
													'subtotal' => $val['subtotal'],
													'attribute' => unserialize($val['attribute']),//(new \App\Models\AttributeValueModel())->getAttributeById(unserialize($val['attribute'])),
												];
    		}
    	}
    	return $result;
    }

    public function checkProductExitsInOrder($user_id,$product_id)
    {
    	$sql = $this->db->table('order_items')
    					->where('user_id',$user_id)
    					->where('item_id',$product_id)
    					->get()
    					->getRowArray();
    	if ( !empty($sql) ) {
    		return true;
    	}
    	return false;
    }

    public function insertOrder($ip,$data=[],$orderCart=[])
    {
		$db = \Config\Database::connect();
		// Coupon logic added by nabeel
		if(isset($data['coupons'])){
			$couponArr = explode(',', $data['coupons']);
			$coupon_data = $db->table('coupons')->whereIn('coupon_code', $couponArr)->get()->getResult();	
		}
		// Coupon logic ends here
        $grand_sub_total = [];
        $grand_shipp_total = [];
        if ( $data['gateway'] ==  'cod' || $data['gateway'] ==  'coupon_code' ) {
        	$order_status = 1;
        } else {
        	$order_status = 0;
        }
        $orderData = [
                        'user_id' => getUserId(),
                        'payment_method' => $data['gateway'],
                        'ip_address' => $ip,
                        'platform' => $data['platform'],
                        'order_message' => $data['address']['billing']['order_notes'] ?? ($data['order_message'] ?? null),
                        'status' => $order_status,
                    ];
        $order_id = $this->add($orderData);
        $order_serial = 'Z'.date('Ymd').'-'.$order_id;
        $total_zapptas = 0;
		$earnedZapptas = [];
        foreach( $orderCart as $cart ) {
    		$total_attr_price = [];
            if ( is_array($cart['options']) && count($cart['options']) > 0 ) {
                foreach ( $cart['options'] as $option ) {
                    $total_attr_price[] = $option['attr_price'];
                }
            }
            $single_item = (new \App\Models\ProductsDetailModel())->getById($cart['id']);
            if ( $single_item['deal_enable'] > 0 ) {
                $new_total_price = ( $single_item['deal_final_price'] + array_sum($total_attr_price) );
            } else {
                $new_total_price = ( $single_item['final_price'] + array_sum($total_attr_price) );
            }
            
            $item_add_ship = ( $new_total_price * $cart['qty'] );
			// Coupon logic added by nabeel
			if(isset($coupon_data) && count($coupon_data) > 0 ){
				$coupon_code = "";
				$coupon_price_used = 0;
				$coupon_detail = [];
				for ($i=0; $i < count($coupon_data); $i++) { 
					$coupon = $coupon_data[$i];
					if($single_item['store_id'] == $coupon->vendor_id && $coupon->coupon_price > 0){
						$coupon_code = $coupon->coupon_code;
						if($coupon->coupon_price >= $item_add_ship){
							$coupon_price_used = $item_add_ship;
							$coupon->coupon_price = $coupon->coupon_price - $item_add_ship;
							$item_add_ship = 0;
						}else if($item_add_ship > $coupon->coupon_price) {
							$item_add_ship = $item_add_ship - $coupon->coupon_price;
							$coupon_price_used = $coupon->coupon_price;
							$coupon->coupon_price = 0;
						}
						$coupon_detail = [
							'order_id' => $order_id,
							'item_id' => $cart['id'],
							'user_id' => getUserId(),
							'coupon_code' => $coupon_code,
							'coupon_price_used' => $coupon_price_used
						];
						$db->table('used_coupons')->insert($coupon_detail);
						$db->table('coupons')
								->set('coupon_price', $coupon->coupon_price)
								->set('is_used', $coupon->coupon_price==0?1:0)
								->where('coupon_code', $coupon->coupon_code)
								->update();
					}
					$coupon_data[$i] = $coupon;
				}
			}
			// end here
			$handle_ship = $cart['item_handle'];
			if ( !empty($single_item['shipping_cost']) && strlen($single_item['shipping_cost']) > 0 ) {
				$handle_ship = $single_item['shipping_cost'];
			}

			if ( $item_add_ship >= $cart['item_transfer'] ) {
				$handle_ship = 0;
			}

            $sub_total_price = ( $item_add_ship ) + $handle_ship;//$single_item['shipping_cost'];

            $grand_sub_total[] = $item_add_ship;//( $new_total_price * $cart['qty'] );

            $grand_shipp_total[] = $handle_ship;
            
            $order_items = [
                            'order_id' => $order_id,
                            'user_id' => getUserId(),
                            'store_id' => $single_item['store_id'],
                            'item_id' => $cart['id'],
                            'item_name' => $cart['name'],
                            'price' => $new_total_price,
                            'qty' => $cart['qty'],
                            'shipping' => $handle_ship,
                            'item_image' => $cart['item_image'],
                            'item_status' => $order_status,
                            'subtotal' => $sub_total_price,
                            'attribute' => serialize($cart['options']),
							// Coupon logic added by nabeel
							// 'coupon_detail' => isset($coupon_detail)&& !$coupon_detail ? json_encode($coupon_detail) : NULL,
							// End here
                            'zappta_commission' => (new  \App\Models\ProductsDetailModel())->getZapptaCommission($cart['id']),
                            'created_at' => date('Y-m-d H:i:s')
                        ];
            $this->AddOrderItems($order_items);
            (new  \App\Models\ProductsDetailModel())->updateItemQty($cart['id'], (int)$cart['qty'], $cart['options']);
			// Add zapta coins after successfull order placed!
            $store = (new \App\Models\VendorModel())->findStoreById($single_item['store_id']);
			if(isset($store['earn_zappta'])){
				$zapptas = $store['earn_zappta']*$store['per_dollar']*$sub_total_price;
				$total_zapptas += $zapptas;
				if($order_status == 1){
					$this->zapptaEarned($zapptas, $order_serial);
				}else {
					$earnedZapptas[] = $zapptas;
				}
			}
        }
		$subtotal = array_sum($grand_sub_total);
		$tax = calculateSubtotalTax($subtotal, get_zappta_tax());
        $final_total = ($subtotal + array_sum($grand_shipp_total) + $tax);

        $this->updateOrderPrice($order_id,array_sum($grand_sub_total),$final_total,array_sum($grand_shipp_total),$order_serial, $tax);

		$this->assignAddress($order_id,$data['billing_address_id']);
		$this->assignAddress($order_id,$data['shipping_address_id']);



        (new \App\Models\Setting())->insertDollor('ZAPPTA_BUYING','Buy Item',4,$final_total);
		// Notification to user!
		if($order_status == 1){
			$link = '/dashboard/history/status?order_id='.my_encrypt($order_id).'&key='.csrf_hash();
			(new UsersModel())->saveNotification("Your Order <b style='color: {$this->bgColor};'>{$order_serial}</b> has been placed!", getUserId(), $link, 'order-placed');
			$link = '/dashboard/wallet';
			if($total_zapptas > 0) {
				(new UsersModel())->saveNotification("You won {$total_zapptas} Zappta dollars bonus via your Order <b style='color: {$this->bgColor};'>{$order_serial}</b>", getUserId(), $link, 'order-bonus');
			}
		}
        return ['order_id' => $order_id, 'zapptas' => $earnedZapptas, 'order_serial' => $order_serial];
    }
	
	/**
	 * Save earned zapptas to user wallet
	 * @param int $zapptas
	 * @param string $order_serial
	 * @return void
	 * @author M Nabeel Arshad
	 */
	public function zapptaEarned($zapptas, $order_serial) {
		$this->db->table('zappta_earn')
			->set('user_id',getUserId())
			->set('zapta_earn',$zapptas)
			//  ->set('visit_link','Purchased product '.$product[0]['name'])
			->set('visit_link', $order_serial)
			->set('type',6)
			->set('visit_date',date('Y-m-d'))
			->set('created_at', date('Y-m-d H:i:s'))
			->insert();
	}

    public function updateItemOrderStatus($order_id,$status)
    {
		$order = $this->getUserIdByOrder($order_id);
		$this->deleteZapptaEarned($order[0]['order_serial']);
    	return $this->db->table('order_items')
    					->set('item_status',$status)
    					->where('order_id',$order_id)
    					->update();
    }

	public function deleteZapptaEarned($order_id)
	{
		return $this->db->table('zappta_earn')
    					->where('visit_link',$order_id)
    					->delete();
	}

    public function GetLatestOrders(){

   		 $sql = $this->db->table('order_items')
   						->select('order_items.order_id,order_items.item_name,order_items.user_id,order_items.store_id as item_store_id,order.total_amount,order.payment_method,order.created_at,order_timeline.status as time_status,order_timeline.created_at as time_date')
   						->join('order','order.id=order_items.order_id','left')
   						->join('order_timeline','order_timeline.order_id=order_items.order_id','left')
   						->where('order_items.store_id',getVendorUserId())
   						->where('order_items.item_status >',0)
   						->groupBy('order_items.order_id')
   						->orderBy('order.id','DESC')
   						->limit(5)
   						->get()
   						->getResultArray();
   						return $sql;
   						// echo $this->db->getLastQuery();
   						// exit;
    }

	public function countOrdersPerStore($id)
    {
    	return count($this->db->table('order_items')
    					->where('store_id',$id)
						->get()
						->getResultArray());
    					// ->count();
    }

	public function getUserIdByOrder($order_id)
   	{
   		return $this->db->table('order')
   						->where('id',$order_id)
						->get()
   						->getResultArray();
   	}

}

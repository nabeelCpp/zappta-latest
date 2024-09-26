<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsDetailModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'product_detail';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'product_id',
										'store_id',
										'quantity',
										'min_qty',
										'low_qty',
										'stock_email',
										'outofstockorder',
										'dimwidth',
										'dimheight',
										'dimlenth',
										'weightkg',
										'devliery_time',
										'devliery_days',
										'devliery_days_after',
										'shipping_cost',
										'retail_price_notax',
										'retail_price_tax',
										'is_discount',
										'deal_enable',
										'zappta_commission',
										'final_price',
										'deal_final_price',
										'product_value',
										'product_selected',
									];

	// Dates
	protected $useTimestamps        = false;
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


    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

    public function getById($product_id)
    {
        $product = $this->asArray()
                    ->where( [ 'product_id' => $product_id ] )
                    ->first();
        if(!empty($product)) {
        	return $product;
    	}
    	return 0;
    }

    public function getZapptaCommission($product_id)
    {
        return $this->getById($product_id)['zappta_commission'];
    }

    public function updateData($data=[],$product_id)
    {
    	if ( is_array($data) && count($data) > 0 ) {
    		$builder = $this->db->table($this->table);
    		foreach ( $data as $d => $v ) {
    			$builder->set($d,$v);
    		}
    		$builder->where('product_id',$product_id);
    		$builder->update();
    	}
    }


    public function updateItemQty($item_id,$qty)
    {
        $sql = $this->find($item_id);
        if(!empty($sql)) {
            $oldqty = (int) $sql['quantity'];
            if ( is_int($oldqty) ) {
	            $current_qty = $oldqty - $qty;
	            if( $current_qty <= 0 ) {
	                $this->add(['id' => $item_id , 'quantity' => $current_qty]);
	            } else {
	                $this->add(['id' => $item_id , 'quantity' => $current_qty ]);
	            }
	        }
        }
    }

}

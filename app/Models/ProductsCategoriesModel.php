<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsCategoriesModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'product_category';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'product_id',
										'catid',
										'store_id',
									];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created';
	protected $updatedField         = 'created';
	protected $deletedField         = 'created';

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
    	return false;
    }

    public function getByStoreId($product_id)
    {
        $product = $this->asArray()
                    ->where( [ 'product_id' => $product_id, 'store_id' => getVendorUserId() ] )
                    ->first();
        if(!empty($product)) {
        	return $product['catid'];
    	}
    	return false;
    }

    public function getAdminByStoreId($product_id)
    {
        $product = $this->asArray()
                    ->where( [ 'product_id' => $product_id ] )
                    ->first();
        if(!empty($product)) {
        	return $product['catid'];
    	}
    	return false;
    }

    public function deleteCategory($product_id)
	{
        return $this->db->table($this->table)->delete(['product_id' => $product_id]);
	}


}

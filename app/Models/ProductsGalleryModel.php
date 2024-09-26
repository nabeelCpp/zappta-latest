<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsGalleryModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'product_img';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'product_id',
										'fimg',
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


	public function getAllResult($limit=1)
	{
        $limits = 20;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        return $this->db->table($this->table)
                        ->limit($limits,$result_limit)
                        ->get()
                        ->getResultArray();
	}

    public function getAdminTotalResult()
    {
        return $this->db->table($this->table)
                        ->countAllResults();
    }

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

    public function getAllById($product_id)
    {
    	return $this->where('product_id',$product_id)->findAll();
    }

    public function deleteImage($product_id)
	{
        return $this->db->table($this->table)->delete(['product_id' => $product_id]);
	}
	
    public function deleteSingleImage($product_id,$fimg)
	{
        return $this->db->table($this->table)
        				->where('product_id',$product_id)
        				->where('fimg',$fimg)
        				->delete();
	}

}

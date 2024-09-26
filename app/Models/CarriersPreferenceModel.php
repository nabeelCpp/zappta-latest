<?php

namespace App\Models;

use CodeIgniter\Model;

class CarriersPreferenceModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'shipping_preference';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'store_id',
										'handlingcharges',
										'freeshipat', 
										'freeshipatweight', 
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

    public function getAllResult($limit=20)
    {
        return $this->orderBy('id DESC')->paginate($limit);
    }

    public function getById()
    {
        $user = $this->asArray()
                    ->where( [ 'store_id' => getVendorUserId() ] )
                    ->first();
        if(!empty($user)) {
        	return $user;
    	}
    	return false;
    }

}

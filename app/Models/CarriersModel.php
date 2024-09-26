<?php

namespace App\Models;

use CodeIgniter\Model;

class CarriersModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'shipping_career';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'handle_ship',
										'billing',
										'package_width', 
										'package_height', 
										'package_depth', 
										'package_weight', 
										'price',
										'status',
										'fimg',
										'deleteStatus'
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


    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

    public function deleteR($ids)
    {
        $this->add(['id'=>$ids,'deleteStatus' => 1]);
    }

    public function getAllResult($limit=20)
    {
        return $this->where('deleteStatus',0)->orderBy('id DESC')->paginate($limit);
    }


}

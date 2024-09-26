<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileRightModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users_right';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['name','rights'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = true;
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

	public function getAllResult()
	{
		return $this->orderBy('name ASC')->findAll();
	}

	public function add($data = [])
	{
		return $this->save($data);
	}
    
    public function getById($id)
    {
        return $this->find($id);
    }
    
    public function deleteRow($id)
    {
        return $this->delete($id);
    }

}

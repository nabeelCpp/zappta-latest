<?php

namespace App\Models;

use CodeIgniter\Model;

class CountryModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'country';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'name',
										'name_ar',
										'flags',
										'numcode',
										'iso',
										'iso_ar',
										'deleteStatus'
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

	public function getAll()
	{
		return $this->where('deleteStatus',0)->orderBy('name ASC')->findAll();
	}

	public function getAllResult($limit)
    {
        return $this->where('deleteStatus',0)->orderBy('id DESC')->paginate($limit);
    }

    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

    public function getSingleName($id)
    {
    	$sql = $this->where('deleteStatus',0)->find($id);
    	if(!empty($sql)){
    		return $sql['name'];
    	}
    	return NULL;
    }

    public function deleteR($ids)
    {
        $builder = $this->db->table($this->table);
        $builder->set('deleteStatus', 1);
        $builder->where('id', $ids);
        $builder->update();
    }

    public function getCountry()
    {
    	$result = [];
    	$sql = $this->getAll();
    	if(!empty($sql)){
    		$result[] = [ 'id' => (int) $sql['id'] , 'name' => $sql['name']];
    		return $result;
    	}
    	return NULL;
    }
    

}

<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users_permission';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['name','pright','pid','addp','editp','view','deletep','allview'];

	// Dates
	protected $useTimestamps        = false;
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
		return $this->findAll();
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
        return $this->where(['pid' => $id])->delete();
    }

    public function findProfileId($pid)
    {
        $user = $this
		            ->asArray()
		            ->where(['pid' => $pid])
		            ->orderBy('pright ASC')
		            ->findAll();
		if(!empty($user))    
			return $user;
    }

    public function getResultById($user_id)
    {
    	$result = [];
        $sql = $this->db->table('users_permission up')
        				->select('ur.rights,up.addp,up.editp,up.view,up.deletep,up.allview')
        				->join('users_right ur','ur.rights=up.pright','LEFT')
                        ->where('up.pid',$user_id)
                        ->get()
                        ->getResultArray();
    	if ( is_array($sql) && count($sql) > 0 ) {
    		foreach( $sql as $q ) {
    			$result[$q['rights']] = [
    										'edit' => $q['editp'],
    										'add' => $q['addp'],
    										'view' => $q['view'],
    										'delete' => $q['deletep'],
    										'allview' => $q['allview'],
    									];
    		}
    	}
    	return $result;
    }

    public function getResultByRights($user_id,$right)
    {
    	return $this->db->table('users_permission')
        				->select('addp,editp,view,deletep,allview')
                        ->where('pid',$user_id)
                        ->where('pright',$right)
                        ->get()
                        ->getRow();
    }
    
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class MetaModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'meta_detail';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'type',
										'entry_id',
										'urls',
										'meta_title',
										'meta_description',
										'meta_keywords',
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


    public function getAllResult($limit=20)
    {
        return $this->orderBy('id DESC')
        			->paginate($limit);
    }

    public function findById($id,$type)
    {
        $user = $this->asArray()
                    ->where(['entry_id' => $id ,'type' => $type])
                    ->first();
        if(!empty($user)) {
        	return $user;
    	}
    	return false;
    }

    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }


    public function updateData($type,$entry_id,$meta_title,$meta_description,$meta_keywords)
    {
    	$builder = $this->db->table($this->table);
		$builder->set('meta_title',$meta_title);
		$builder->set('meta_description',$meta_description);
		$builder->set('meta_keywords',$meta_keywords);
		$builder->where('type',$type);
		$builder->where('entry_id',$entry_id);
		$builder->update();
    }

    public function getMetaName($entry_id, $type)
    {
        $user = $this->asArray()
                    ->where(['entry_id' => $entry_id, 'type' => $type])
                    ->first();
    	if ( !empty($user) ) {
    		return $user['meta_title'];
    	}
    	return false;
    }
    
    public function getMetaDescription($entry_id, $type)
    {
        $user = $this->asArray()
                    ->where(['entry_id' => $entry_id, 'type' => $type])
                    ->first();
    	if ( !empty($user) ) {
    		return $user['meta_description'];
    	}
    	return false;
    }

    public function getMetaKeyword($entry_id, $type)
    {
        $user = $this->asArray()
                    ->where(['entry_id' => $entry_id, 'type' => $type])
                    ->first();
    	if ( !empty($user) ) {
    		return $user['meta_keywords'];
    	}
    	return false;
    }

}

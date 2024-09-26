<?php

namespace App\Models;

use CodeIgniter\Model;


class pagesfeedback extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'pages_feedback';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [ 
										'id',
										'value',
										'page_url',
								
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


	public function AddPagesFeedBack($page_name ,$value){
		    	return $sql =  $this->db->table($this->table)
				 		->set('page_url',$page_name)
				 		->set('value',$value)
				 		->insert();
				 		
	}


}

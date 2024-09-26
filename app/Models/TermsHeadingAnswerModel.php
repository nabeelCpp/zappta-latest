<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Query;

class TermsHeadingAnswerModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'faqs_heading_answer';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = true;
	protected $protectFields        = true;
	protected $allowedFields        = ['lang_id','faq_heading_id','title','answer'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

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

	public function getAllResultById($id)
	{
		return $this->where('faq_heading_id', $id)->findAll();
	}

	public function add($data = [])
	{
		$this->save($data);
        return $this->getInsertID();
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

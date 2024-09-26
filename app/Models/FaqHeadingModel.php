<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Tools;
use App\Models\FaqHeadingAnswerModel;

class FaqHeadingModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'faqs_heading';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = true;
	protected $protectFields        = true;
	protected $allowedFields        = ['lang_id','name','type'];

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
		return $this->where('type',1)->findAll();
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

    public function getFaq($lang='en')
    {
    	$result = [];
    	$sql = $this->where('type',1)->findAll();
    	if(is_array($sql)){
    		foreach($sql as $row){
    			$result[] = [
    							'id' => (int) $row['id'],
    							'type' => 1,
    							'heading' => (new Tools())->getByNameByLang(apilang($lang),$row['id'],'name',9),
    							'answer' => $this->getFaqAnswer($lang,$row['id'])
    						];
    		}
    		return $result;
    	}
    	return NULL;
    }
    
    private function getFaqAnswer($lang,$id)
    {
    	$answers = (new FaqHeadingAnswerModel())->getAllResultById($id);
    	if(!empty($answers)) {
    		$result = [];
    		foreach($answers as $ans){
    			$result[] = (new Tools())->getByNameByLang( apilang($lang) ,$ans['id'],'short',10 );
    		}
    		return $result;
    	}
    	return NULL;
    }
    
}

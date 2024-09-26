<?php

namespace App\Models;

use CodeIgniter\Model;

class CityModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'country_city';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = true;
	protected $protectFields        = true;
	protected $allowedFields        = ['country_id','sid','zone','name','name_ar','deleteStatus'];

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

	public function getByCountry($country_id)
	{
		return $this->where('deleteStatus',0)->where('country_id',$country_id)->orderBy('name ASC')->findAll();
	}
	
    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

    public function getSingleName($lang,$id)
    {
    	$sql = $this->where('deleteStatus',0)->find($id);
    	if(!empty($sql)){
    		if( apilang($lang) == 1 ) {
				return $sql['name'];
			} else {
				return $sql['name_ar'];
			}
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

    public function getCountryCity( string $lang='en',$country_id)
    {
    	$result = [];
    	$sql = $this->getByCountry($country_id);
    	if(!empty($sql)){
    		foreach($sql as $row){
    			if( apilang($lang) == 1 ) {
    				$result[] = [ 'id' => (int) $row['id'] , 'name' => $row['name']];
    			} else {
    				$result[] = [ 'id' => (int) $row['id'] , 'name' => $row['name_ar']];
    			}
    		}
    		return $result;
    	}
    	return NULL;
    }
    

}

<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CountryModel;
use App\Models\CityModel;

class Address extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'address';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [ 
										'user_id',
										'first_name',
										'last_name',
										'company_name',
										'country',
										'stree_address',
										'stree_address_optional',
										'town_city',
										'postcode',
										'phone',
										'email',
										'default_address',
										'type',
										'same_shipping',
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

	const ADDRESS_TYPE_BILLING = 1;
	const ADDRESS_TYPE_SHIPPING = 2;
	const ADDRESS_DISPLAY_LIMIT = 5;

    public function getAllResultByUser($user_id,$limit=20,$type=1)
    {
        return $this->where('deleteStatus',0)->where('user_id',$user_id)->where('type',$type)->orderBy('id DESC')->paginate($limit);
    }

    public function getAllResult($limit=20)
    {
        return $this->where('deleteStatus',0)->orderBy('id DESC')->paginate($limit);
    }

	public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }
	
	public function deleteRecord($ids)
    {
        $this->set('deleteStatus', 1)
    		 ->where('id',$ids)
    		 ->update();
    }

	public function deleteR($ids,$user_id)
    {
        $this->set('deleteStatus', 1)
    		 ->where('user_id',$user_id)
    		 ->where('id',$ids)
    		 ->update();
    }

}

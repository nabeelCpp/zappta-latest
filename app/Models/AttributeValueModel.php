<?php 

namespace App\Models;

use CodeIgniter\Model;

class AttributeValueModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table                = 'attributes_value';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'store_id',
										'name_en',
										'name_ar',
										'attr_id',
										'value_opt',
										'color_code',
										'price_enable',
										'price_value',
										'value_img',
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


    public function getAdminAllResult($attr_id,$limit=1)
    {
        $limits = 20;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        return $this->where('attr_id',$attr_id)
        			->where('deleteStatus',0)
        			->orderBy('id DESC')
        			->findAll($limits,$result_limit);
    }

    public function countAdminresult($attr_id)
    {
        return $this->db->table($this->table)
                        ->where('attr_id',$attr_id)
                        ->where('deleteStatus',0)
                        ->countAllResults();
    }

    public function getAllResult($attr_id,$limit=20)
    {
        return $this->where('attr_id',$attr_id)
        			->where('deleteStatus',0)
        			->where('store_id',getVendorUserId())
        			->orderBy('id DESC')
        			->paginate($limit);
    }

    public function countresult($attr_id)
    {
    	return $this->db->table($this->table)
    					->where('attr_id',$attr_id)
    					->where('deleteStatus',0)
        				->where('store_id',getVendorUserId())
    					->countAllResults();
    }

    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

    public function deleteR($ids)
    {
        $builder = $this->db->table($this->table);
        $builder->set('deleteStatus', 1);
        $builder->where('id', $ids);
        $builder->update();
    }

    public function getById($id)
    {
        $user = $this->asArray()
                    ->where( [ 'id' => $id ,'store_id' => getVendorUserId() , 'deleteStatus' => 0 ] )
                    ->first();
        if(!empty($user)) {
        	return $user;
    	}
    	return false;
    }

    public function getNameById($id,$store_id)
    {
        $user = $this->asArray()
                    ->where( [ 'id' => $id ,'store_id' => $store_id , 'deleteStatus' => 0 ] )
                    ->first();
        if(!empty($user)) {
        	return $user;
    	}
    	return false;
    }

    public function getValueName($id)
    {
        $user = $this->asArray()
                    ->where( [ 'id' => $id , 'deleteStatus' => 0 ] )
                    ->first();
        if(!empty($user)) {
            return $user['name_en'];
        }
        return false;
    }

    public function getValueNameWithAttr($id)
    {
        $sql = $this->db->table('attributes')
                        ->select('attributes.name_en as attr_name,attributes_value.name_en as value_name')
                        ->join('attributes_value','attributes_value.attr_id=attributes.id')
                        ->where('attributes_value.id',$id)
                        ->where('attributes_value.deleteStatus',0)
                        ->limit(1)
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return $sql['attr_name'] .': ' . $sql['value_name'];
        }
        return false;
    }

    public function getValueNameById($id,$store_id)
    {
        $user = $this->asArray()
                    ->where( [ 'id' => $id ,'store_id' => $store_id , 'deleteStatus' => 0 ] )
                    ->first();
        if(!empty($user)) {
            return $user['name_en'];
        }
        return false;
    }

    public function getAllByType($value_opt)
    {
        return $this->where(['value_opt' => $value_opt ,'store_id' => getVendorUserId() , 'deleteStatus' => 0])->findAll();
    }

    public function findById($attr_id)
    {
        $values = $this->where(['attr_id' => $attr_id])->findAll();
        if(is_array($values)) {
        	return $values;
    	}
    	return false;
    }

    public function getValueByAttrbuteForProduct($attr_id, $admin = true)
    {
        if($admin) {
            $sql = $this->db->table($this->table)
                            ->select('attributes.name_en as attr_name,attributes.id as attr_id ,attributes_value.id,attributes_value.name_en,attributes_value.value_opt,attributes_value.color_code,attributes_value.value_img')
                            ->join('attributes','attributes.id=attributes_value.attr_id','left')
                            ->where('attr_id',$attr_id)
                            ->get()
                            ->getResultArray();
        }else{
            $sql = $this->db->table($this->table)
                ->select('attributes.name_en as attr_name,attributes.id as attr_id ,attributes_value.id,attributes_value.name_en,attributes_value.value_opt,attributes_value.color_code,attributes_value.value_img')
                ->join('attributes','attributes.id=attributes_value.attr_id','left')
                ->where('attr_id',$attr_id)
                ->where('attributes_value.deleteStatus',0)
                ->get()
                ->getResultArray();
        }
        return $sql;
    }

    public function getValueByAttrbuteId($attribute_id,$value_id)
    {
        return $this->where(['attr_id' => $attribute_id ,'id ' => $value_id])->findAll();
    }

    public function findByValueId($attr_id)
    {
    	$result = [];
        $values = $this->where(['attr_id' => $attr_id])->findAll();
        if(is_array($values)) {
        	foreach($values as $val){
        		if( activelang() == 1 ){
	            	$name = $val['name_en'];
	        	} else {
	            	$name = $val['name_ar'];
	    		}
	    		if ( $val['value_opt'] == 1 ) {
        			$result[] = [ 'id' => (int) $val['id'] , 'name' => $name , 'type' =>  (int) $val['value_opt'] ];
        		} else {
        			$result[] = [ 'id' => (int) $val['id'] , 'name' => $val['color_code'] , 'type' =>  (int) $val['value_opt'] ];
        		}
        	}
    		return $result;
    	}
    	return NULL;
    }

    public function getAttributeById($attr=[])
    {
    	if ( is_array($attr) && count($attr) > 0 ) {
    		// $result = [];
    		foreach( $attr as $at ) {
    			return $this->getValueByAttrbuteId($at['attribute_id'],$at['value_id']);
    		}
    		// return $result;
    	}
    	return NULL;
    }

    public function getValueByType($attribute_id,$value_opt)
    {
        $r = [];
        $sql = $this->where(['attr_id' => $attribute_id ,'value_opt ' => $value_opt])->findAll();
        // dd($sql);
        if ( is_array($sql) && count($sql) > 0 ) {
            foreach( $sql as $q ) {
                $r[] = $q['id'];
            }
        }
        // die();
        return serialize($r);
    }

}

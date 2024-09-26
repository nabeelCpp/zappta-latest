<?php

namespace App\Models;

use CodeIgniter\Model;

class AttributeModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'attributes';
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
										'opt',
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


    public function getAdminAllResult($limit=1)
    {
        $limits = 20;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        return $this->db->table($this->table)
                        ->select('attributes.*, COUNT(cms_product_attribute.attr_id) as total_items')
                        ->join('product_attribute','product_attribute.attr_id=attributes.id','LEFT')
                        ->where('attributes.deleteStatus',0)
                        ->groupBy('attributes.id')
                        ->limit($limits,$result_limit)
                        ->orderBy('id DESC')
                        ->get()
                        ->getResultArray();
    }

    public function searchAttribute( $word )
    {
        return $this->db->table($this->table)
                        ->select('attributes.*, COUNT(cms_product_attribute.attr_id) as total_items')
                        ->join('product_attribute','product_attribute.attr_id=attributes.id','LEFT')
                        ->where('attributes.deleteStatus',0)
                        ->like('name_en', $word)
                        ->groupBy('attributes.id')
                        ->orderBy('id DESC')
                        ->get()
                        ->getResultArray();
    }

    public function getAdminTotalResult()
    {
        return $this->db->table($this->table)
                        ->where('attributes.deleteStatus',0)
                        ->countAllResults();
    }

    public function getAllResult($limit=20)
    {
        return $this->where('deleteStatus',0)
        			->where('store_id',getVendorUserId())
        			->orderBy('id DESC')
        			->paginate($limit);
    }

    public function getAll($store_id)
    {
    	return $this->where('deleteStatus',0)
        	   	    ->where('store_id',$store_id)
        	        ->findAll();
        			
    }

    public function countTotalStoreAttr()
    {
        return $this->db->table($this->table)->where('deleteStatus',0)->where('store_id',getVendorUserId())->countAllResults();
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
        $builder->where('deleted_at', date('Y-m-d H:i:s'));
        $builder->update();
    }

    public function getAttrbuteById($id)
    {
        $user = $this->asArray()
                    ->where( [ 'id' => $id , 'deleteStatus' => 0 ] )
                    ->first();
        if(!empty($user)) {
            return $user;
        }
        return false;
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

    public function findById($id)
    {
        $user = $this->asArray()
                    ->where(['id' => $id ,'store_id' => getVendorUserId() , 'deleteStatus' => 0])
                    ->first();
        if(!empty($user)) {
        	return $user['name_en'];
    	}
    	return false;
    }

    public function addAttributeCategories( $category_id, $brand_id )
    {
    	$this->db->table('attributes_categories')
    			 ->set('category_id',$category_id)
    			 ->set('brand_id',$brand_id)
    			 ->set('created_at',date('Y-m-d H:i:s'))
    			 ->insert();
    	return true;
    }

    public function deleteAttributeCategories( $brand_id )
    {
    	$this->db->table('attributes_categories')
    			 ->where('brand_id',$brand_id)
    			 ->delete();
    	return true;
    }

    public function deleteAttributeByCategories( $category_id )
    {
        $this->db->table('attributes_categories')
                 ->where('category_id',$category_id)
                 ->delete();
        return true;
    }

    public function getSingleAttribute($id)
    {
        $result = [];
    	$sql = $this->db->query('SELECT cms_attributes.id as aid,cms_attributes.name_en,cms_attributes.opt,cms_attributes_categories.category_id as attr_cat,cms_attributes_categories.brand_id as attr_id  FROM (SELECT * FROM cms_attributes WHERE cms_attributes.id='.$id.'  LIMIT 1 ) `cms_attributes` LEFT JOIN cms_attributes_categories on cms_attributes_categories.brand_id=cms_attributes.id')
    					->getResultArray();
    	if ( is_array($sql) && count($sql) > 0 ) {
    		foreach ( $sql as $q => $val ) {
                $result['name_en'] = $val['name_en'];
                $result['opt'] = $val['opt'];
    			$result['categories'][] = [ 'attr_cat' => $val['attr_cat'] ];
    		}
    	}
    	return $result;
    }

    public function totalAttributeProduct($attr_id)
    {
        return $this->db->table('product_attribute')
                        ->where('attr_id',$attr_id)
                        ->countAllResults();
    }

    public function getCatAttr( $category_id )
    {
        $result = [];
        $sql = $this->db->table($this->table)
                        ->select('attributes.name_en as attr_name, attributes.id as attr_id')
                        ->join('attributes_categories','attributes_categories.brand_id=attributes.id')
                        ->where('attributes_categories.category_id',$category_id)
                        ->where('attributes.deleteStatus',0)
                        ->get()
                        ->getResultArray();
        if ( is_array($sql) && count($sql) > 0 ) {
            foreach( $sql as $q ) {
                $result[] = [
                                'attr_name' => $q['attr_name'],
                                'values' => $this->getCatAttrVal( $q['attr_id'] )
                            ];
            }
        }
        return $result;
    }

    public function getCatAttrVal( $attr_id )
    {
        $result = [];
        $sql = $this->db->table('attributes_value')
                        ->where('attributes_value.attr_id',$attr_id)
                        ->where('attributes_value.deleteStatus',0)
                        ->get()
                        ->getResultArray();
        return $sql;
    }

    public function getAttributesValues()
    {
        $result = [];
        $sql = $this->db->table('attributes')
                        ->select('attributes.name_en,attributes.opt,attributes_value.name_en as value_name, attributes_value.attr_id as attr_id, attributes_value.id as value_id,attributes_value.color_code, attributes_value.value_opt, attributes_value.value_img')
                        ->join('attributes_value','attributes_value.attr_id=attributes.id')
                        ->where('attributes.deleteStatus',0)
                        ->get()
                        ->getResultArray();
        if ( is_array($sql) && count($sql) > 0 ) {
            foreach( $sql as $q ) {
                $result[$q['name_en']][] = [
                                                'value_id' => $q['value_id'],
                                                'value_name' => $q['value_name'],
                                                'value_opt' => $q['value_opt'],
                                                'color_code' => $q['color_code'],
                                                'value_img' => $q['value_img'],
                                            ];
            }
        }
        return $result;
    }


}

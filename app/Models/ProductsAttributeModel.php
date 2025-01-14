<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsAttributeModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'product_attribute';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'product_id',
										'type',
										'attr_id',
										'value_id',
										'name',
										'price',
										'qty',
										'category_id',
										'sizes',
										'colors',
										'dimension',
										'paper_type',
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


    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

    public function getAllById($product_id,$attr_id)
    {
        $product = $this->where('product_id',$product_id)->where('attr_id',$attr_id)->findAll();
        if(!empty($product)) {
        	return $product;
    	}
    	return NULL;
    }

    public function getById($product_id)
    {
        $product = $this->asArray()
                    ->where( [ 'product_id' => $product_id ] )
                    ->first();
        if(!empty($product)) {
        	return $product;
    	}
    	return false;
    }

    public function deleteAttr($product_id,$type)
	{
        return $this->db->table($this->table)->delete(['product_id' => $product_id,'type' => $type]);
	}

    public function deleteAllAttr($product_id)
	{
        return $this->db->table($this->table)
        				->where('product_id',$product_id)
        				->delete();
	}

    public function addattr($product_id,$data=[],$type=0)
    {
    	$this->deleteAttr($product_id,$type);
    	if( isset($data) && is_array($data) && count($data) > 0 ) {
    		foreach( $data as $ds => $vs ) {
    			$attr_id = explode('_1_',$vs);
    			$this->add( [ 'product_id' => $product_id , 'type' => $type, 'attr_id' => my_decrypt($attr_id[0]),'value_id' => my_decrypt(end($attr_id)) ] ); 
    		}
    	}
    }

    public function insertAttr($product_id,$attr_id,$value_id,$name,$price,$category_id=0, $qty = 0)
    {
    	$type = explode('_', $name);
    	$this->add( [ 
    					'product_id' => $product_id , 
    					'attr_id' => $attr_id, 
    					'value_id' => $value_id,
    					'name' => $name, 
    					'price' => $price,
    					'qty' => $qty,
    					'category_id' => $category_id,
    					'type' => end($type)
    				] );
    }

    public function getByStoreId($product_id,$type,$attr_id,$value_id)
    {
        $product = $this->asArray()
                    ->where( [ 'product_id' => $product_id, 'type' => $type, 'attr_id' => $attr_id, 'value_id' => $value_id ] )
                    ->first();
        if(!empty($product)) {
        	return $product;
    	}
    	return false;
    }

    public function getAttributesById($product_id)
    {
    	return $this->db->table('product_attribute')
    					->select('product_attribute.attr_id,attributes.name_en')
    					->join('attributes','attributes.id=product_attribute.attr_id','left')
    					->where('product_attribute.product_id',$product_id)
    					->groupBy('product_attribute.attr_id')
    					->orderBy('product_attribute.attr_id DESC')
    					->get()
    					->getResultArray();
    }

}

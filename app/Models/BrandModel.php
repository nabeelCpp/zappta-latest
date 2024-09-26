<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'brands';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'category_id',
										'urls',
										'name',
										'short',
										'description',
										'logo',
										'brand_banner',
										'status',
										'deleteStatus',
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
	protected $beforeInsert         = ['beforeInsert'];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];


	protected function beforeInsert(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    private function getUpdatedDataWithHashedPassword(array $data): array
    {
        if ( isset($data['data']['urls']) && empty($data['data']['urls']) ) {
            return $data;
        }
        if (isset($data['data']['urls'])) {
            $link = strtolower(trim($data['data']['urls']));
            $link = preg_replace('/[^a-z0-9-]/', '-', $link);
            $link = preg_replace('/-+/', "-", $link);
            $link = rtrim($link, '-');
            $link = preg_replace('/\s+/', '-', $link);
            $existing_lnk = $this->db->table($this->table);
            $existing_lnk->where('urls',$link);
            $num = $existing_lnk->get()->getResult();
            $first_total = count($num);
            for($i=0;$first_total != 0;$i++){
            	if($i == 0){
                    $new_number = $first_total + 1;
                    $newlink = $link."-".$new_number;
                }
                $check_lnk = $this->db->table($this->table);
	            $check_lnk->where('urls',$newlink);
	            $other = $check_lnk->get()->getResult();
	            $other_total = count($other);
                if($other_total != 0){
                    $first_total = $first_total + $other_total;
                    $new_number = $first_total;
                    $newlink = $link."-".$new_number;
                }elseif($other_total == 0){
                    $first_total = 0;
                } 
            }

            if($i > 0){
            	$data['data']['urls'] = $newlink;
            } else{
            	$data['data']['urls'] = $link;
            }

        }
        return $data;
    }

    public function getTotalBrandAllResult($limit=20 )
    {
        $limits = 20;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        return $this->db->table($this->table)
                        ->select('brands.*, COUNT(DISTINCT(p.id)) as total_products, COUNT(DISTINCT(p2.store_id)) as total_stores')
                        ->join('products p','p.brand_id=brands.id','LEFT')
                        ->join('products p2','p2.brand_id=p.brand_id','LEFT')
                        ->where('brands.deleteStatus',0)
                        ->groupBy('brands.id')
                        ->limit($limits,$result_limit)
                        ->orderBy('id DESC')
                        ->get()
                        ->getResultArray();
    }

    public function searchBrands( $word )
    {
        return $this->db->table($this->table)
                        ->select('brands.*, COUNT(DISTINCT(p.id)) as total_products, COUNT(DISTINCT(p2.store_id)) as total_stores')
                        ->join('products p','p.brand_id=brands.id','LEFT')
                        ->join('products p2','p2.brand_id=p.brand_id','LEFT')
                        ->where('brands.deleteStatus',0)
                        ->like('brands.name', $word)
                        ->groupBy('brands.id')
                        ->orderBy('id DESC')
                        ->get()
                        ->getResultArray();
    }

    public function getAdminTotalResult()
    {
        return $this->db->table($this->table)
                        ->where('deleteStatus',0)
                        ->countAllResults();
    }

    public function getAllResult( $category_id , $limit=20 )
    {
        return $this->db->table($this->table)
                        ->join('brands_categories','brands_categories.brand_id=brands.id','left')
                        ->where('brands_categories.category_id',$category_id)
                        ->where('brands.deleteStatus',0)
                        ->get()
                        ->getResultArray();
    }

    public function getTotal()
    {
    	return $this->db->table($this->table)
    					->where('deleteStatus',0)
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
        $builder->where('deleted_at', date('Y-m-d H:i:s'));
        $builder->update();
    }

    public function getById($id)
    {
        $user = $this->asArray()
                    ->where( [ 'id' => $id , 'deleteStatus' => 0 ] )
                    ->first();
        if(!empty($user)) {
        	return $user;
    	}
    	return false;
    }

    public function getByUrl($urls)
    {
        $user = $this->asArray()
                    ->where( [ 'urls' => $urls , 'deleteStatus' => 0 ] )
                    ->first();
        if(!empty($user)) {
        	return $user;
    	}
    	return false;
    }

    public function findById($id)
    {
        $user = $this->asArray()
                    ->where(['id' => $id , 'deleteStatus' => 0])
                    ->first();
        if(!empty($user)) {
        	return $user['name'];
    	}
    	return false;
    }

    public function totalBrandProduct($brand_id)
    {
        return $this->db->table('products')
                        ->where('brand_id',$brand_id)
                        ->countAllResults();
    }

    public function totalStoreBrand($brand_id)
    {
        return $this->db->table('products')
                        ->where('brand_id',$brand_id)
                        ->groupBy('store_id')
                        ->countAllResults();
    }

    public function addBrandCategories( $category_id, $brand_id )
    {
        $this->db->table('brands_categories')
                 ->set('category_id',$category_id)
                 ->set('brand_id',$brand_id)
                 ->set('created_at',date('Y-m-d H:i:s'))
                 ->insert();
        return true;
    }

    public function updateBrandCategories( $category_id, $brand_id )
    {
        $this->db->table('brands_categories')
                 ->set('category_id',$category_id)
                 ->where('brand_id',$brand_id)
                 //->set('created_at',date('Y-m-d H:i:s'))
                 ->update();
        return true;
    }

    public function deleteBrandCategories( $brand_id )
    {
        $this->db->table('brands_categories')
                 ->where('brand_id',$brand_id)
                 ->delete();
        return true;
    }

    public function deleteBrandByCategories( $category_id )
    {
        $this->db->table('brands_categories')
                 ->where('category_id',$category_id)
                 ->delete();
        return true;
    }

    public function getSingleBrand($id)
    {
        $sql = $this->db->query('SELECT cms_brands.*,cms_brands_categories.category_id as bcat,cms_brands_categories.brand_id as bid FROM cms_brands LEFT JOIN cms_brands_categories ON cms_brands_categories.brand_id=cms_brands.id WHERE cms_brands.id='.$id.' LIMIT 1')
                           ->getRowArray();
        return $sql;
    }


}

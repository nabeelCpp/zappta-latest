<?php

namespace App\Models;

use CodeIgniter\Model;


class CategoriesModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'categories';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'parent_id',
                                        'cat_name',
                                        'description',
                                        'metakey',
										'cat_url',
										'status',
										'cat_img',
										'cat_icon',
                                        'deleteStatus',
                                        'brands',
                                        'attributes',
										'type'
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
	protected $afterInsert          = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = [];

    protected function beforeInsert(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    private function getUpdatedDataWithHashedPassword(array $data): array
    {
        if ( isset($data['data']['cat_url']) && empty($data['data']['cat_url']) ) {
            return $data;
        }
        if (isset($data['data']['cat_url'])) {
            $link = strtolower(trim($data['data']['cat_url']));
            $link = preg_replace('/[^a-z0-9-]/', '-', $link);
            $link = preg_replace('/-+/', "-", $link);
            $link = rtrim($link, '-');
            $link = preg_replace('/\s+/', '-', $link);
            $existing_lnk = $this->db->table($this->table);
            $existing_lnk->where('cat_url',$link);
            $existing_lnk->where('type',1);
            $num = $existing_lnk->get()->getResult();
            $first_total = count($num);
            for($i=0;$first_total != 0;$i++){
            	if($i == 0){
                    $new_number = $first_total + 1;
                    $newlink = $link."-".$new_number;
                }
                $check_lnk = $this->db->table($this->table);
	            $check_lnk->where('cat_url',$newlink);
            	$check_lnk->where('type',1);
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
            	$data['data']['cat_url'] = $newlink;
            } else{
            	$data['data']['cat_url'] = $link;
            }

        }
        return $data;
    }

    public function blogCategories()
    {
    	return $this->where('deleteStatus',0)->where('type',2)->orderBy('id DESC')->findAll();
    }

    public function getAllBlogsResult($limit)
    {
        return $this->where('deleteStatus',0)->where('type',2)->orderBy('id DESC')->paginate($limit);
    }

    public function getAllResult($limit=1)
    {
        $limits = 20;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        return $this->db->table($this->table)
                        ->select('categories.*, COUNT(DISTINCT(cms_product_category.product_id)) as total_items, COUNT(DISTINCT(p2.store_id)) as total_stores')
                        ->join('product_category','product_category.catid=categories.id','LEFT')
                        ->join('product_category p2','p2.catid=categories.id','LEFT')
                        ->where('categories.deleteStatus',0)
                        ->groupBy('categories.id')
                        ->limit($limits,$result_limit)
                        ->orderBy('id DESC')
                        ->get()
                        ->getResultArray();
    }

    public function searchCategories( $word )
    {
        return $this->db->table($this->table)
                        ->select('categories.*, COUNT(DISTINCT(cms_product_category.product_id)) as total_items, COUNT(DISTINCT(p2.store_id)) as total_stores')
                        ->join('product_category','product_category.catid=categories.id','LEFT')
                        ->join('product_category p2','p2.catid=categories.id','LEFT')
                        ->where('categories.deleteStatus',0)
                        ->like('cat_name', $word)
                        ->groupBy('categories.id')
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

    public function getStoreAllResult($limit=20)
    {
        return $this->where('deleteStatus',0)->where('type',3)->orderBy('id DESC')->paginate($limit);
    }

    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

    public function deleteRblog($ids)
    {
        $builder = $this->db->table($this->table);
        $builder->set('deleteStatus', 1);
        $builder->where('id', $ids);
		$builder->where('type',2);
        $builder->update();
    }

    public function deleteR($ids)
    {
        $builder = $this->db->table($this->table);
        $builder->set('deleteStatus', 1);
        $builder->where('id', $ids);
		// $builder->where('type',1);
        $builder->update();
    }

    
    public function addCategoryImage($cat_id,$image)
	{
        $builder = $this->db->table('categories_image');
        $builder->set('cat_id', $cat_id);
        $builder->set('image', $image);
        $builder->set('created', date('Y-m-d'));
        $builder->insert();
	}

    public function deleteCategoryImage($cat_id)
	{
        return $this->db->table('categories_image')->delete(['cat_id' => $cat_id]);
	}

    public function getCategoryImage($cat_id)
	{
        $builder = $this->db->table('categories_image')
        				->where('cat_id', $cat_id)
        				->get()
        				->getResultArray();
		return $builder;
	}
	
    public function getParentCategories()
    {
        return $this->where('deleteStatus',0)->where('type',1)->where('parent_id',0)->orderBy('cat_name ASC')->findAll();
    }

	public function getcat($parent = 0, $spacing = '', $user_tree_array = '')
	{
		if (!is_array($user_tree_array)){
		    $user_tree_array = array();
		}
		$db = $this->db->table($this->table);
		$db->where('parent_id',$parent);
		$db->where('type',1);
		$db->where('deleteStatus',0);
		$db->orderBy('parent_id ASC');
		$q = $db->get()->getResult();
        // $q = cache()->get('allcategories');
		if(is_array($q) && count($q)) {
			foreach($q as $row){
                //$user_tree_array[] = array( "id" => $row['id'], "name" => $spacing,'cat_name' => $row['cat_name'] );
		      	//$user_tree_array = $this->getcat($row['id'], $spacing . '&nbsp;&nbsp;', $user_tree_array);
			    $user_tree_array[] = array( "id" => $row->id, "name" => $spacing,'cat_name' => $row->cat_name );
                $user_tree_array = $this->getcat($row->id, $spacing . '&nbsp;&nbsp;', $user_tree_array);
            }
		}
		return $user_tree_array;
	}

    public function totalCategoryProduct($catid)
    {
        return $this->db->table('product_category')
                        ->where('catid',$catid)
                        ->countAllResults();
    }

    public function totalStoreCategory($catid)
    {
        return $this->db->table('product_category')
                        ->where('catid',$catid)
                        ->groupBy('store_id')
                        ->countAllResults();
    }

    
    public function getCategoryProduct($product_id)
    {
        $sql = $this->db->table('categories')
                        ->select('categories.id as catid, categories.cat_name,product_category.product_id,product_category.catid,product_category.store_id')
                        ->join('product_category','product_category.catid=categories.id')
                        ->where('product_category.store_id',getVendorUserId())
                        ->where('product_category.product_id',$product_id)
                        // ->orderBy('product_category.catid ASC')
                        ->limit(1)
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return $sql['cat_name'];
        }
        return false;
    }

    public function getVendorCategory()
    {
        $sql = $this->db->table('product_category')
                        ->select('categories.id,categories.cat_name as ccname,categories.cat_url')
                        ->join('categories','categories.id=product_category.catid','left')
                        ->where('product_category.store_id',getVendorUserId())
                        ->groupBy('product_category.catid')
                        ->get()
                        ->getResultArray();
        return $sql;
    }

    public function getCatIdByUrl($url)
    {
        $sql = $this->where('cat_url',$url)->first();
        if ( !empty($sql) ) {
            return $sql;
        }
        return 0;
    }

    public function getAllCategoryForTree($parent=0)
    {
        return $this->where('deleteStatus',0)->where('type',1)->where('parent_id',$parent)->orderBy('cat_name ASC')->findAll();
    }

    public function getAllCategoryTree()
    {
        return $this->where('deleteStatus',0)->where('type',1)->orderBy('cat_name ASC')->findAll();
    }

    public function getAllCategoryTreeForVendor()
    {
        return $this->db->table($this->table)
                        ->select('id as value,cat_name as label,parent_id')
                        ->where('deleteStatus',0)
                        ->where('type',1)
                        ->orderBy('cat_name ASC')
                        ->get()
                        ->getResultArray();
    }

    public function getSelectBrand($catid)
    {
        $sql = $this->db->table('brands')
                        ->select('brands.name,brands.id')
                        ->join('brands_categories','brands_categories.brand_id=brands.id')
                        ->where('brands_categories.category_id',$catid)
                        ->get()
                        ->getResultArray();
        return $sql;
    }

    public function getSelectAttribute($catid)
    {
        $sql = $this->db->table('attributes')
                        ->select('attributes.name_en,attributes.id')
                        ->join('attributes_categories','attributes_categories.brand_id=attributes.id')
                        ->where('attributes_categories.category_id',$catid)
                        ->get()
                        ->getResultArray();
        return $sql;
    }

    public function getStoreSelectedCat($store_id)
    {
        $sql = $this->db->table('product_category')
                        ->select('*')
                        ->join('categories','categories.id=product_category.catid')
                        ->where('product_category.store_id',$store_id)
                        ->groupBy('catid')
                        ->get()
                        ->getResultArray();
        return $sql;
    }

    public function getStoreProductsByCatId($store_id,$cat_id)
    {
        $proid = [];
        $sql = $this->db->table('product_category')
                        ->where('store_id',$store_id)
                        ->where('catid',$cat_id)
                        ->get()
                        ->getResultArray();
        if ( is_array($sql) && count($sql) > 0 ) {
            foreach( $sql as $q ) {
                $proid[] = $q['product_id'];
            }
        }
        return $proid;
    }

    public function getRelatedCategories($cat_id,$product_id)
    {
        $proid = [];
        $sql = $this->db->table('product_category')
                        ->where('product_id <>',$product_id)
                        ->where('catid',$cat_id)
                        ->limit(12)
                        ->get()
                        ->getResultArray();
        if ( is_array($sql) && count($sql) > 0 ) {
            foreach( $sql as $q ) {
                $proid[] = $q['product_id'];
            }
        }
        return $proid;
    }

    public function getStoreCategoriesProduct($pro)
    {
        $p = [];
        if ( is_array($pro) && count($pro) > 0 ) {
            foreach( $pro as $pr ) {
                $p[] = $pr['product_id'];
            } 
        }
        return $p;
    }

}

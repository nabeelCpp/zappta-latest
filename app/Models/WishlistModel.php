<?php 

namespace App\Models;

use CodeIgniter\Model; 
use App\Models\ProductModel;

/**
 * 	Profile Model Creating Admin Profile for permissions
 */
class WishlistModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'wishlist';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = [ 
                                'product_id',
                                'user_id',
                                'store_id',
                                'created_at'
                             ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

	
    public function getAllResult($limit)
    {
        return $this->orderBy('id ASC')->paginate($limit);
    }

    public function getAllResultByUserId($user_id,$limit=null)
    {
        $sql =  $this->where('user_id',$user_id)->orderBy('id ASC');
        if($limit) {
            $data = $sql->paginate($limit);
        }else{
            $data = $sql->get()->getResultArray();
        }
        return $data;
    }


    public function getUserTotalList()
    {
        return $this->db->table($this->table)
                        ->where('user_id',getUserId())
                        ->countAllResults();
    }


    public function getUserOrderList($page=1, $limit = PER_PAGE)
    {
        $result_limit = 0;
        if ( $page > 1 ) {
            $result_limit = $limit * ( $page - 1 );
        }
        $result = [];
        $sql = $this->db->query('SELECT cms_wishlist.product_id,cms_wishlist.id as wid,cms_products.name,cms_products.url,cms_products.sd_row,cms_products.pds,cms_products.pc,cms_products.cover,cms_products.short FROM (SELECT * FROM cms_wishlist WHERE user_id='.getUserId().'  LIMIT '.$limit.' OFFSET '.$result_limit.' ) `cms_wishlist` INNER JOIN cms_products on cms_products.id=cms_wishlist.product_id ORDER BY cms_wishlist.id DESC')
                        ->getResultArray();
        if ( is_array($sql) && count($sql) > 0 ) {
            foreach ( $sql as $q => $val ) {
                // $result['order'][$val['id']] = [
                //                     'id' => $val['id'],
                //                     'status' => $val['status'],
                //                     'status_date' => $val['status_date'],
                //                 ];
                // $result['items'][$val['id']][] = [
                //                                     'item_row' => $val['item_row'],
                //                                     'item_id' => $val['item_id'],
                //                                     'order_id' => $val['order_id'],
                //                                     'item_name' => $val['item_name'],
                //                                     'item_image' => $val['item_image'],
                //                                 ];
                $result[] = $val;
            }
        }
        return $result;
    }


    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

    public function deleteR($ids)
    {
        return $this->where('id',$ids)->delete();
    }

    public function checkWishList($store_id,$product_id,$user_id)
    {
        $pro = $this->asArray()
                    ->where(['store_id' => $store_id ,'product_id' => $product_id , 'user_id' => $user_id])
                    ->first();
        if(!empty($pro)) {
            return true;
        }
        return false;
    }


}
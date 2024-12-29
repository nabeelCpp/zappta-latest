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
        $sql = $this->db->query('SELECT cms_wishlist.product_id as pid,cms_wishlist.id as wishlist_id,cms_products.name as pname,cms_products.short as pshort, cms_products.url as purl, cms_products.cover as pcover,cms_products.sd_row ,cms_products.pds,cms_products.pc, cms_product_detail.retail_price_tax,cms_product_detail.retail_price_notax, cms_product_detail.deal_enable, cms_product_detail.final_price,cms_product_detail.zappta_commission,cms_product_detail.deal_final_price, cms_product_detail.outofstockorder, cms_shipping_preference.freeshipat, cms_shipping_preference.freeshipatweight,  cms_vendor.earn_zappta, cms_vendor.per_dollar FROM (SELECT * FROM cms_wishlist WHERE user_id='.getUserId().'  LIMIT '.$limit.' OFFSET '.$result_limit.' ) `cms_wishlist` INNER JOIN cms_products on cms_products.id=cms_wishlist.product_id LEFT JOIN cms_product_detail ON cms_product_detail.product_id=cms_products.id LEFT JOIN cms_vendor ON cms_vendor.id=cms_products.store_id LEFT JOIN cms_shipping_preference ON cms_shipping_preference.store_id=cms_products.store_id ORDER BY cms_wishlist.id DESC')
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
                $val['pshort'] = html_entity_decode($val['pshort']);
                $val['pcover'] = getImageThumg('products', $val['pcover'], 100);
                $val['is_wishlist'] = true;
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
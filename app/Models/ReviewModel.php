<?php 

namespace App\Models;

use CodeIgniter\Model; 
use App\Models\RegisterModel;

/**
 * 	Profile Model Creating Admin Profile for permissions
 */
class ReviewModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'product_review';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = [ 
                                'product_id',
                                'store_id',
                                'order_id',
                                'user_id',
                                'rates',
                                'fimg',
                                'comments',
                                'likes',
                                'dislikes',
                                'status'
                             ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getFrontAllResult($pid,$limit=1)
    {
        $limits = 12;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        return $this->db->table($this->table)
                        ->select('product_review.*,register.fname')
                        ->join('register','register.id=product_review.user_id','LEFT')
                        ->where('product_id',$pid)
                        ->limit($limits,$result_limit)
                        ->orderBy('id DESC')
                        ->get()
                        ->getResultArray();
    }
	
    public function getAllResult($limit)
    {
        return $this->orderBy('created_at DESC')->paginate($limit);
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

    /*
    *   Product Single ID
    *   return array
    */

    public function getApiProductReview( $lang='en', $product_id, $store_id=0,$user_id=0 )
    {
        $result = [];
        $sql = $this->where('status',1)
                    ->where('product_id',$product_id)
                    ->where('store_id',$store_id)
                    ->orderBy('id DESC')
                    ->paginate(2);
        if(!empty($sql)){
            foreach($sql as $row) {
                $result[] = $this->getApiSingleReview($row['id'],$user_id);
            }
            return $result;
        }    
        return NULL;        
    }

    public function getOrderReview($product_id,$order_id,$user_id)
    {
        $pro = $this->asArray()
                    ->where(['product_id' => $product_id,'order_id' => $order_id,'user_id' => $user_id])
                    ->first();
        if(!empty($pro)){
            return $this->getApiSingleReview($pro['id'],$user_id);
        }    
        return NULL;        
    }

    public function getApiReview( $lang='en', $limit=1, $product_id, $store_id,$user_id=0 )
    {
        $limits = 10;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        $result = [];
        $sql = $this->where('status',1)
                    ->where('product_id',$product_id)
                    ->where('store_id',$store_id)
                    ->orderBy('id DESC')
                    ->findAll(10,$result_limit);
        if(is_array($sql)){
            $result['excellent'] = $this->countRate($product_id,$store_id,5);
            $result['good'] = $this->countRate($product_id,$store_id,4);
            $result['average'] = $this->countRate($product_id,$store_id,3);
            $result['belowaverage'] = $this->countRate($product_id,$store_id,2);
            $result['poor'] = $this->countRate($product_id,$store_id,1);
            foreach($sql as $row) {
                $result['product_reviews'][] = $this->getApiSingleReview($row['id'],$user_id);
            }
            return $result;
        }    
        return NULL;        
    }

    public function getApiSingleReview($id,$user_id=0)
    {
        $sql = $this->find($id);
        if(is_array($sql)){
            $row = $sql;
            $result = [
                            'id' => (int) $row['id'],
                            'store_id' => (int) $row['store_id'],
                            'store_name' => getFieldName($row['store_id'],'name',15),
                            'username' =>  (new RegisterModel())->getUserNameBySingleId($row['user_id']),
                            'user_image' =>  (new RegisterModel())->getUserProfileImage($row['user_id']),
                            'rates' => (int) $row['rates'],
                            'comments' => $row['comments'],
                            'likes' => (int) $this->gettotalLike($row['id']),
                            'dislikes' => (int) $this->gettotalDisLike($row['id']),
                            'userlike' => (bool) $this->getUserDisLike($row['id'],$user_id),
                            'status' => (int) $row['status'],
                            'review_date' => date('Y-m-d', strtotime($row['created_at'])),
                            'reviewimage' => $this->getAllPath($row['id']),
                        ];
            return $result;
        }    
        return NULL;        
    }

    public function getAvargeRate($product_id,$store_id=0)
    {
        $sql = $this->db->table($this->table)
                        ->selectSum('rates')
                        ->where('status',1)
                        ->where('store_id',$store_id)
                        ->where('product_id',$product_id)
                        ->get()
                        ->getRow();
        if(!empty($sql)){
            if($sql->rates > 0){
                $avg = $sql->rates / $this->totalResult($product_id,$store_id);
                return $avg;
            } else {
                return 0;
            }
        }
        return NULL;
    }

    private function countRate($product_id,$store_id,$count)
    {
        return $this->db->table($this->table)->where('status',1)->where('store_id',$store_id)->where('product_id',$product_id)->where('rates',$count)->countAllResults();
    }

    public function totalResult($product_id,$store_id)
    {
        return $this->db->table($this->table)
                        ->where('status',1)
                        ->where('store_id',$store_id)
                        ->where('product_id',$product_id)
                        ->countAllResults();
    }

    public function getTotalPages($product_id,$store_id)
    {
        $limit = 10;
        $total_pages = ceil( $this->totalResult($product_id,$store_id) / $limit );
        return $total_pages;
    }
    
    public function getRemainingPages($page,$product_id,$store_id)
    {
        $remin = $this->getTotalPages($product_id,$store_id) - $page;
        return $remin;
    }

    public function addApiReview($data=[],$user_id)
    {
        $post = [
                    'user_id' => $user_id,
                    'store_id' => (int) $data['store_id'],
                    'product_id' => (int) $data['product_id'],
                    'order_id' => 0,
                    'rates' => $data['rates'],
                    'comments' => $data['comments'],
                    'status' => 1,
                ];
        $ids = $this->add($post);
        // if ( isset($data['fimg']) && is_array($data['fimg'])  && count($data['fimg']) > 0 ) {
        //     foreach($data['fimg'] as $img){
        //         $dir = ROOTPATH . 'public/upload/media';
        //         $image = filtreData($img);
        //         $image_parts = explode(";base64,", $image);
        //         $image_type_aux = explode("image/", $image_parts[0]);
        //         $image_type = $image_type_aux[1];
        //         $image_base64 = base64_decode($image_parts[1]);
        //         $filename = uniqid() .'.jpg';
        //         $file = $dir.'/'.$filename;
        //         file_put_contents($file, $image_base64);
        //         imageThumb($file,$dir,$filename);
        //         // $this->add( [ 'id' => $ids,'fimg' => $filename ] );
        //         $this->addReviewImg($ids,$filename);
        //     }
        // }
        // return $this->getApiSingleReview($ids,$user_id);
    }

    private function addReviewImg($review_id,$fimg)
    {
        $db = $this->db->table('product_review_img');
        $db->set('review_id',$review_id);
        $db->set('fimg',$fimg);
        $db->set('created_at',date('Y-m-d'));
        $db->insert();
    }

    public function getAllPath($review_id)
    {
        $result = [];
        $image = $this->db->table('product_review_img')->where('review_id',$review_id)->get()->getResult();
        if(is_array($image)){
            foreach($image as $img){
                $result['small'][] = getImageThumg('media',$img->fimg,100);
                $result['medium'][] = getImageThumg('media',$img->fimg,250);
                $result['large'][] = getImageThumg('media',$img->fimg,350);
                $result['xlarge'][] = getImageThumg('media',$img->fimg,600);
                $result['original'][] = getImageFull('media',$img->fimg);
            }
        }
        if ( is_array($result) && count($result) > 0 ) {
            return $result;
        } else {
            return NULL;
        }
    }

    public function reviewLike($review_id,$user_id,$like)
    {
        if( $this->getUserLikeExits($review_id,$user_id) == false ) {
            $db = $this->db->table('product_review_likes');
            $db->set('review_id',$review_id);
            $db->set('user_id',$user_id);
            $db->set('likes',1);
            $db->set('dislikes',0);
            $db->set('created_at',date('Y-m-d'));
            $db->insert();
        } else {
            $db = $this->db->table('product_review_likes');
            // $db->set('likes',0);
            // $db->set('dislikes',1);
            // $db->set('created_at',date('Y-m-d'));
            $db->where('review_id',$review_id);
            $db->where('user_id',$user_id);
            $db->delete();
        }
        return $this->getApiSingleReview($review_id,$user_id);
    }

    public function reviewdisLike($review_id,$user_id,$like)
    {
        if( $this->getUserLikeExits($review_id,$user_id) == false ) {
            $db = $this->db->table('product_review_likes');
            $db->set('review_id',$review_id);
            $db->set('user_id',$user_id);
            $db->set('likes',1);
            $db->set('dislikes',0);
            $db->set('created_at',date('Y-m-d'));
            $db->insert();
        } else {
            $db = $this->db->table('product_review_likes');
            $db->set('likes',0);
            $db->set('dislikes',1);
            $db->set('created_at',date('Y-m-d'));
            $db->where('review_id',$review_id);
            $db->where('user_id',$user_id);
            $db->update();
        }
        return $this->getApiSingleReview($review_id,$user_id);
    }

    public function gettotalLike($review_id)
    {
        return $this->db->table('product_review_likes')
                        ->where('likes',1)
                        ->where('review_id',$review_id)
                        ->countAllResults();
    }

    public function gettotalDisLike($review_id)
    {
        return $this->db->table('product_review_likes')
                        ->where('likes',0)
                        ->where('review_id',$review_id)
                        ->countAllResults();
    }

    public function getUserDisLike($review_id,$user_id)
    {
        $sql = $this->db->table('product_review_likes')
                        ->where('likes',1)
                        ->where('review_id',$review_id)
                        ->where('user_id',$user_id)
                        ->countAllResults();
        if($sql > 0){
            return true;
        }
        return false;
    }

    public function getUserLikeExits($review_id,$user_id)
    {
        $pro = $this->db->table('product_review_likes')
                        ->where('review_id',$review_id)
                        ->where('user_id',$user_id)
                        ->get()
                        ->getResult();
        if(!empty($pro)) {
            return true;
        }
        return false;
    }

    public function insertreviews($user_id,$data=[])
    {
        $post = [
                    'user_id' => $user_id,
                    'store_id' => (int) $data['store_id'],
                    'product_id' => (int) $data['product_id'],
                    'order_id' => 0,
                    'rates' => $data['rates'],
                    'comments' => $data['comments'],
                    'status' => 1,
                ];
        return $this->add($post);
    }

}
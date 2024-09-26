<?php 

namespace App\Models;

use CodeIgniter\Model; 

/**
 * 	Setting Model for update Setting
 */
class MediaModal extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'media';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = [ 'images', 'status','store_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'created_at';
    protected $deletedField  = 'created_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

	public function getAllResult($limit=1)
    {
        $limits = 30;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        $result = [];
        $sql = $this->where('status',1)
                    ->where('store_id',getVendorUserId())
                    ->orderBy('id DESC')
                    ->findAll($limits,$result_limit);
        if ( is_array($sql) && count($sql) > 0 ) {
            foreach( $sql as $q ) {
                $img_ext = explode('.',$q['images']);
                $result[] = [
                                'id' => $q['id'],
                                'image' => $q['images'],
                                'small' => base_url().'/images/product/'.$img_ext[0].'/'.$img_ext[1].'/100',
                                'medium' => base_url().'/images/product/'.$img_ext[0].'/'.$img_ext[1].'/250',
                                'large' => base_url().'/images/product/'.$img_ext[0].'/'.$img_ext[1].'/350',
                                'xlarge' => base_url().'/images/product/'.$img_ext[0].'/'.$img_ext[1].'/600',
                                'original' => getImageFull('products',$q['images'])
                            ];
            }
            return $result;
        }
        return NULL;
    }

}
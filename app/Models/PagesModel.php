<?php

namespace App\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'content';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'url',
										'parent',
										'title',
										'customurl',
										'usecustom',
										'menupos',
										'position',
										'active',
										'tempid',
										'sidebar',
										'content',
										'fimg',
										'deleteStatus',
										'metatitle',
										'metadescp',
										'metakeyword'
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
        if ( isset($data['data']['url']) && empty($data['data']['url']) ) {
            return $data;
        }
        if (isset($data['data']['url'])) {
            $link = strtolower(trim($data['data']['url']));
            $link = preg_replace('/[^a-z0-9-]/', '-', $link);
            $link = preg_replace('/-+/', "-", $link);
            $link = rtrim($link, '-');
            $link = preg_replace('/\s+/', '-', $link);
            $existing_lnk = $this->db->table($this->table);
            $existing_lnk->where('url',$link);
            $num = $existing_lnk->get()->getResult();
            $first_total = count($num);
            for($i=0;$first_total != 0;$i++){
            	if($i == 0){
                    $new_number = $first_total + 1;
                    $newlink = $link."-".$new_number;
                }
                $check_lnk = $this->db->table($this->table);
	            $check_lnk->where('url',$newlink);
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
            	$data['data']['url'] = $newlink;
            } else{
            	$data['data']['url'] = $link;
            }

        }
        return $data;
    }

    public function getAllResult($limit=1)
    {
        $limits = 12;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        return $this->db->table($this->table)
        				->where('deleteStatus',0)
                        ->limit($limits,$result_limit)
                        ->get()
                        ->getResultArray();
        //return $this->where('deleteStatus',0)->orderBy('id DESC')->paginate($limit);
    }

    public function getTotalAdminPages()
    {
        return $this->db->table($this->table)->where('deleteStatus',0)->countAllResults();
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
    	return $this->where('active',1)->where('deleteStatus',0)->find($id);
    }

    public function getPageByUrl($url)
    {
    	return $this->where('url',$url)
    				->asArray()
    				->first();
    }

    public function getUrlByPageId($id)
    {
    	$sql = $this->where('id',$id)
    				->where('active',1)
    				->where('deleteStatus',0)
    				->asArray()
    				->first();
    	if ( !empty($sql) ) {
    		return $sql['url'];
    	}
    	return NULL;
    }

    public function getApiPageByUrl($url,$lang)
    {
    	$sql = $this->where('url',$url)
    				->asArray()
    				->first();
    	if ( !empty($sql) ) {
    		return [
    				'id' => (int)$sql['id'],
    				'url' => $sql['url'],
    				'title' => getFieldNameId(apilang($lang),$sql['id'],'title',4),
    				'description' => strip_tags(html_entity_decode(getFieldNameId(apilang($lang),$sql['id'],'content',4))),
    			];
    	}
    }

}

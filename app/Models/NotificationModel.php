<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'product_question';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
										'user_id',
										'product_id',
										'vendor_id',
										'message',
										'replymsg',
										'status',
									];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'created_at';
	protected $deletedField         = 'created_at';

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
        $limits = 30;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        $sql = $this->db->table('product_question pq')
        				->select('pq.*, r.fname, r.email as user_email, v.store_name, p.name')
        				->join('register r','r.id=pq.user_id','LEFT')
        				->join('vendor v','v.id=pq.vendor_id','LEFT')
        				->join('products p','p.id=pq.product_id','LEFT')
        				->limit($limits,$result_limit)
        				->orderBy('id DESC')
        				->get()
        				->getResultArray();
        return $sql;
    }

    public function countAdminAllResult()
    {
        $sql = $this->db->table($this->table)->countAllResults();
        return $sql;
    }

    public function deleteR($ids)
    {
        return $this->where('id',$ids)->delete();
    }
    
    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }


}

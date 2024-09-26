<?php 

namespace App\Models;

use CodeIgniter\Model; 

class SliderModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'homepage_slider';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = [ 
                                'name', 
                                'status'
                             ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $beforeInsert = [];
    protected $beforeUpdate = [];

    

	public function getAllResult($limit=20)
    {
        return $this->paginate($limit);
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



}
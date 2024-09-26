<?php 

namespace App\Models;

use CodeIgniter\Model; 

/**
 * 	Profile Model Creating Admin Profile for permissions
 */
class ProfileModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'users_profiles';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = [ 
                                'name_en',
                                'name_ar',
                             ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

	
    public function getAllResult($limit=20)
    {
        return $this->orderBy('name_en ASC')->paginate($limit);
    }

    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }


    public function addAdminUsers($name)
    {
        $data = ['name_en'=>$name];
        $this->insert($data);
        return $this->getInsertID();
    }

    public function deleteR($ids)
    {
        return $this->where('id',$ids)->delete();
    }

}
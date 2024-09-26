<?php 

namespace App\Models;

use CodeIgniter\Model; 

class UsersModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'users';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = [ 
                                'pid', 
                                'name_en',
                                'last_en',
                                'name_ar',
                                'address',
                                'phone',
                                'photo',
                                'designation',
                                'email',
                                'password',
                                'lang_id',
                                'status'
                             ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    protected function beforeUpdate(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    private function getUpdatedDataWithHashedPassword(array $data): array
    {
        if ( isset($data['data']['password']) && empty($data['data']['password']) ) {
            return $data;
        }
        if (isset($data['data']['password'])) {
            $plaintextPassword = $data['data']['password'];
            $data['data']['password'] = $this->hashPassword($plaintextPassword);
        }
        return $data;
    }

    public function hashPassword(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

	public function getAllResult($limit)
    {
        return $this->orderBy('name_en ASC')->paginate($limit);
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
    public function AddUsers($name,$email,$password,$last_inserted_profile_id){
        $data = ['name_en'=>$name,'email'=>$email,'password'=>$password,'status'=>1,'pid'=>$last_inserted_profile_id];
        $this->insert($data);
        return $this->getInsertID();

    }

    public function findByEmail($email)
    {
        $user = $this
                    ->asArray()
                    ->where(['email' => $email])
                    ->first();
        if(!empty($user))    
            return $user['id'];
    }

    public function findByEmailId($email)
    {
        $user = $this
                    ->asArray()
                    ->where(['email' => $email,'status' => 1])
                    ->first();
        if(!empty($user)) {    
            return $user;
        }
        return false;
    }

    public function login_verify($email , $password)
    {
        $user = $this->findByEmailId($email);
        if(!empty($user)) {
            if ( password_verify( $password , $user['password'] ) ) {
                $session = session();
                $session->set('lang',1);
                $session->set('isLoggedIn' , [ 'user_id' => $user['id'], 'pid' => $user['pid'] , 'user_name' => $user['name_en'] ]);
                return true;
            } else {
                return 0;
            }
        } else {
                return 0;
        }
    }

    public function getNotifications($limit = null)
    {
        return !$limit?$this->db->table('user_notification')
    					->where('user_id', getUserId())
                        ->orderBy('id DESC')
						->get()
						->getResultArray():
                        $this->db->table('user_notification')
    					->where('user_id', getUserId())
                        ->limit($limit)
                        ->orderBy('id DESC')
						->get()
						->getResultArray();
    }

    public function saveNotification($notification, $user_id, $link='', $category = '')
    {
        $insert = ['user_id' => $user_id, 'notification' => $notification, 'link' => $link, 'category' => $category, 'created_at' => date('Y-m-d H:i:s')];
        $this->db->table('user_notification')->insert($insert);
    }


}
<?php 

namespace App\Models;

use CodeIgniter\Model; 

class RegisterModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'register';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = [ 
                                    'username',
                                    'fname',
                                    'lname',
                                    'email',
                                    'password',
                                    'phone_code',
                                    'phone',
                                    'status',
                                    'otp',
                                    'otp_time',
                                    'account_platform',
                                    'device_id',
                                    'device_platform',
                                    'fimg',
                                    'subscribe_newsletter',
                                    'deleteStatus',
                                    'api_token',
                                    'log_status',
                                    'email_verify',
                                    'phone_verify',
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

    public function getAdminAllResult($limit=1)
    {
        $limits = 30;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        $sql = $this->where('deleteStatus',0)
                    ->orderBy('id DESC')
                    ->findAll($limits,$result_limit);
        return $sql;
    }

    public function countAdminAllResult()
    {
        $sql = $this->db->table($this->table)->where('deleteStatus',0)->countAllResults();
        return $sql;
    }

	public function getAllResult($limit)
    {
        return $this->orderBy('name_en ASC')->paginate($limit);
    }

    public function add($data = [])
    {
        // $data['status'] = 0;
        $this->save($data);
        return $this->getInsertID();
    }

    public function addd($data = [])
    {
        $data['status'] = 1;
        $this->save($data);
        return $this->getInsertID();
    }
    public function deleteR($ids)
    {
        return $this->where('id',$ids)->delete();
    }

    public function getByIdResult($id)
    {
        $user = $this->asArray()
                     ->where(['id' => $id,'status' => 1])
                     ->first();
        if(!empty($user)) {
            return $user;
        }
        return false;
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

    public function login_verify($email , $password, $api_customer = false)
    {
        self::destroySession();
        $user = $this->findByEmailId($email);
        if(!empty($user)) {
            if ( password_verify( $password , $user['password'] ) ) {
                $this->setUserSession($user,$api_customer);
                return true;
            } else {
                return 0;
            }
        } else {
                return 0;
        }
    }

    public function setUserSession($user,$api_customer = false) {
        $session = session();
        $session->set('lang',1);
        $session->set('userIsLoggedIn' , [ 'user_id' => $user['id'] , 'username' => $user['username'] ]);
        if($api_customer) {
            unset($user['password']);
            $session->set('api_customer' , $user);
        }
    }

    /**
     * Destroy the current session
     * @return void
     * @author M Nabeel Arshad
     */
    private static function destroySession() : void {
        $session = session();
        $session->remove('userIsLoggedIn');
        $session->remove('api_customer');
    }

    public function checkSocialAccountWeb($email,$name,$platform)
    {
        $pro = $this->findByEmailId($email);
        if ( !empty( $pro ) ) {
            $session = session();
            // $session->set('lang', activelang() );
            $session->set('userIsLoggedIn' , [ 'user_id' => $pro['id'], 'username' => $pro['username'] ]);
            return true;
        } else {
            $user_id = $this->add( [ 'fname' => $name ,'username' => $name , 'status' => 1 , 'email' => $email, 'account_platform' => $platform ] );
            $pro_id = $this->findByEmailId($email);
            $session = session();
            // $session->set('lang', activelang() );
            $session->set('userIsLoggedIn' , [ 'user_id' => $pro_id['id'], 'username' => $pro_id['username'] ]);
            return true;
        }
    }

    public function userZapptaDollor()
    {
        $sql = $this->db->table('zappta_earn')
                        ->select('SUM(zapta_earn) AS amount_paid')
                        ->where('user_id', getUserId())
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return ( $sql['amount_paid'] - $this->getZapptaPlay() );
        }        
        return 0;
    }

    private function getZapptaPlay()
    {
        $sql = $this->db->table('compain_players_entry')
                        ->select('SUM(play_coins) AS play_coins')
                        ->where('player_id', getUserId())
                        ->get()
                        ->getRowArray();
        if ( !empty($sql) ) {
            return $sql['play_coins'];
        }        
        return 0;
    }


    public function userWandDollor()
    {
        $sql = $this->db->table('wands')
                        ->select('SUM(wand) AS wands')
                        ->where('user_id', getUserId())
                        ->get()
                        ->getRowArray();
        // if ( !empty($sql) ) {
            return $sql['wands']??0;
        // }        
        // return 0;
    }

    public function userPowerWandDollor()
    {
        $sql = $this->db->table('power_wands')
                        ->select('SUM(wand) AS wands')
                        ->where('user_id', getUserId())
                        ->get()
                        ->getRowArray();
        // if ( !empty($sql) ) {
            return $sql['wands']??0;
        // }        
        // return 0;
    }
}
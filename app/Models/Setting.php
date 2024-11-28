<?php 

namespace App\Models;

use CodeIgniter\Model; 

/**
 * 	Setting Model for update Setting
 */
class Setting extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'setting';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = ['var_name', 'var_detail'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

	

	public function getTheme()
	{
		return $this->where('var_name','THEME_SETTING')->first();
	}

    public function getThemeVar($theme_var)
    {
        if(cache()->get('getGlobalSettings')) {
            $sql = cache()->get('getGlobalSettings');
            foreach($sql as $setting) {
                if($setting['var_name'] == $theme_var) {
                    return $setting['var_detail'];
                }
            }
        }else {
            $sql = $this->where('var_name',$theme_var)->first();
            if ( !empty($sql) ) {
                return $sql['var_detail'];
            }
        }
    }

    public function updateVar($var_name,$var_detail)
    {
        return $this->db->table($this->table)
                        ->set('var_detail',$var_detail)
                        ->where('var_name',$var_name)
                        ->update();
    }

    public function getFrontThemeVar($theme_var)
    {
        return $this->db->table('language_front')
                        ->where('var_name',$theme_var)
                        ->get()
                        ->getRow();
    }

    public function totalZapptaDollor()
    {
        return $this->db->table('zappta_earn')
                        ->selectSum('zapta_earn')
                        ->where('user_id',getUserId())
                        ->get()
                        ->getRowArray();
    }

    /*
    *   type 1 = Product view page
    *   type 2 = Login page
    *   type 3 = Register page
    */

    public function insertDollor($var,$link,$type=1,$total_amount=0)
    {
        $repeat = (int) $this->getThemeVar('ZAPPTA_REPEAT_VIEW');

        switch($repeat) {
            case 1:
                    if ( $type == 4 ) {
                        $total_zap = $this->getThemeVar($var) * $total_amount;
                    } else {
                        $total_zap = $this->getThemeVar($var);
                    }
                    $this->db->table('zappta_earn')
                             ->set('user_id',getUserId())
                             ->set('zapta_earn',$total_zap)
                             ->set('visit_link',filtreDataText($link))
                             ->set('type',$type)
                             ->set('visit_date',date('Y-m-d'))
                             ->set('created_at', date('Y-m-d H:i:s'))
                             ->insert();
                    return true;
                break;
            case 2:
                // if ( empty($this->checkAlreayVisitToday($link)) ) {
                    if ( $type == 4 ) {
                        $total_zap = $this->getThemeVar($var) * $total_amount;
                    } else {
                        $total_zap = $this->getThemeVar($var);
                    }
                    $this->db->table('zappta_earn')
                             ->set('user_id',getUserId())
                             ->set('zapta_earn',$this->getThemeVar($var))
                             ->set('visit_link',filtreDataText($link))
                             ->set('type',$type)
                             ->set('visit_date',date('Y-m-d'))
                             ->set('created_at', date('Y-m-d H:i:s'))
                             ->insert();
                    return true;
                // }
                break;
            case 3:
                if ( empty($this->checkAlreayVisit($link)) ) {
                    if ( $type == 4 ) {
                        $total_zap = $this->getThemeVar($var) * $total_amount;
                    } else {
                        $total_zap = $this->getThemeVar($var);
                    }
                    $this->db->table('zappta_earn')
                             ->set('user_id',getUserId())
                             ->set('zapta_earn',$this->getThemeVar($var))
                             ->set('visit_link',filtreDataText($link))
                             ->set('type',$type)
                             ->set('visit_date',date('Y-m-d'))
                             ->set('created_at', date('Y-m-d H:i:s'))
                             ->insert();
                    return true;
                }
                break;
        }
    }

    public function insertDollorFriend($user_id,$var)
    {
        $total_zap = $this->getThemeVar($var);
        $this->db->table('zappta_earn')
                 ->set('user_id',$user_id)
                 ->set('zapta_earn',$total_zap)
                 ->set('visit_link','Invitation success')
                 ->set('type',5)
                 ->set('visit_date',date('Y-m-d'))
                 ->set('created_at', date('Y-m-d H:i:s'))
                 ->insert();
        return $total_zap;
    }


    public function insertSelectItems($var,$store_url, $minutes)
    {
        $total_zap = $this->getThemeVar($var)*$minutes;
        $this->db->table('zappta_earn')
                 ->set('user_id',getUserId())
                 ->set('zapta_earn',$total_zap)
                 ->set('visit_link',$store_url)
                 ->set('type',7)
                 ->set('visit_date',date('Y-m-d'))
                 ->set('created_at', date('Y-m-d H:i:s'))
                 ->insert();
        return $total_zap;
    }

    public function insertDollorSocialMediaClick($social_media)
    {
        $total_zap = $this->getThemeVar('ZAPPTA_SHARING_'.strtoupper($social_media));
        $this->db->table('zappta_earn')
                 ->set('user_id',getUserId())
                 ->set('zapta_earn',$total_zap)
                 ->set('visit_link','Shared via '.$social_media)
                 ->set('type',6)
                 ->set('visit_date',date('Y-m-d'))
                 ->set('created_at', date('Y-m-d H:i:s'))
                 ->insert();
        return $total_zap;
    }

    private function checkAlreayVisitToday($link)
    {
        return $this->db->table('zappta_earn')
                        ->where('user_id',getUserId())
                        ->where('visit_link',filtreDataText($link))
                        ->where('visit_date',date('Y-m-d'))
                        ->get()
                        ->getRowArray();
    }

    private function checkAlreayVisit($link)
    {
        return $this->db->table('zappta_earn')
                        ->where('user_id',getUserId())
                        ->where('visit_link',filtreDataText($link))
                        // ->where('visit_date',date('Y-m-d'))
                        ->get()
                        ->getRowArray();
    }

    public function totalSpendZapptaDollor()
    {
        return $this->db->table('zappta_spent')
                        ->selectSum('zappta_dollor')
                        ->where('user_id',getUserId())
                        ->get()
                        ->getRowArray();
    }

    public function getResultById($var_name=[])
    {
        return $this->db->table('setting')
                        ->whereIn('var_name',$var_name)
                        ->get()
                        ->getResultArray();  
    }
    public function GetValues($var_name=[]){
        return $this->db->table('setting')
                        ->whereIn('var_name',$var_name)
                        ->get()
                        ->getResultArray(); 
    }
    public function UpdateProfile($data){
        //  print_r($data[]);
        // die();
        foreach ($data as $key => $value) {
               $this->db->table($this->table)
                        ->set('var_detail',$value)
                        ->where('var_name',$key)
                        ->update();
        }
        cache()->delete('getGlobalSettings');

    }

}
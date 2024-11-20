<?php 

namespace App\Models;

use App\Helpers\ZapptaHelper;
use CodeIgniter\Model; 

class VendorModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'vendor';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = [ 
                                'email', 
                                'store_name',
                                'store_slug',
                                'store_link',
                                'password',
                                'store_order_email',
                                'store_status',
                                'store_logo',
                                'paypal_email',
                                'earn_zappta',
                                'per_dollar',
                                'status',
                                'deleteStatus'
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
        // $this->addStoreSlug($data);
        return $data;
    }

    public function addStoreSlug($data)
    {
        if ( isset($data) && empty($data) ) {
            return $data;
        }
        if (isset($data)) {
            $link = strtolower(trim($data));
            $link = preg_replace('/[^a-z0-9-]/', '-', $link);
            $link = preg_replace('/-+/', "-", $link);
            $link = rtrim($link, '-');
            $link = preg_replace('/\s+/', '-', $link);
            $existing_lnk = $this->db->table($this->table);
            $existing_lnk->where('store_slug',$link);
            $num = $existing_lnk->get()->getResult();
            $first_total = count($num);
            for($i=0;$first_total != 0;$i++){
                if($i == 0){
                    $new_number = $first_total + 1;
                    $newlink = $link."-".$new_number;
                }
                $check_lnk = $this->db->table($this->table);
                $check_lnk->where('store_slug',$newlink);
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
                $data = $newlink;
            } else{
                $data = $link;
            }

        }
        return $data;
    }

    public function hashPassword(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function getAdminAllResult($limit=1)
    {
        $limits = 20;
        $result_limit = 0;
        if ( $limit > 1 ) {
            $result_limit = $limits * ( $limit - 1 );
        }
        return $this->db->table($this->table)
                        ->select('vendor.*, COUNT(DISTINCT(p.id)) as total_products')
                        ->join('products p','p.store_id=vendor.id','LEFT')
                        ->where('vendor.deleteStatus',0)
                        ->groupBy('vendor.id')
                        ->limit($limits,$result_limit)
                        ->orderBy('id DESC')
                        ->get()
                        ->getResultArray();
    }

    public function adminTotalVendors()
    {
        return $this->db->table($this->table)->where('deleteStatus',0)->countAllResults();
    }

    public function searchvendor($word)
    {
        return $this->db->table($this->table)
                        ->select('vendor.*, COUNT(DISTINCT(p.id)) as total_products')
                        ->join('products p','p.store_id=vendor.id','LEFT')
                        ->where('vendor.deleteStatus',0)
                        ->like('vendor.store_name',$word)
                        ->groupBy('vendor.id')
                        ->orderBy('id DESC')
                        ->get()
                        ->getResultArray();
    }

    public function getHomeResult($limit=PER_PAGE)
    {
        if(!cache()->get('getHomeResult')) {
            $result =$this->where('store_status',1)
                ->where('status',2)
                ->where('deleteStatus',0)
                ->orderBy('id DESC')
                ->paginate($limit);
            cache()->save('getHomeResult', $result ?? [], ZapptaHelper::CACHE_SECONDS);
        }
        $results = [];
        foreach(cache()->get('getHomeResult') as $key => $value) {
           $value['store_logo'] = getImageThumg('media', $value['store_logo'], 250);
           $results[] = $value;
        }
        return $results;
    }

    /**
     * Get all stores for displaying on stores page
     * @param int $limit
     * @param int $page
     * @return array
     * @author M Nabeel Arshad
     */
    public function getStores( $page = 1, $limit=PER_PAGE)
    {
        $result =$this->where('store_status',1)
            ->where('status',2)
            ->where('deleteStatus',0)
            ->orderBy('id DESC')
            ->limit($limit, ($page - 1) * $limit)
            ->get()
            ->getResultArray();
        $results = [];
        foreach($result as $key => $value) {
           $value['store_logo'] = getImageThumg('media', $value['store_logo'], 250);
           $results[] = $value;
        }
        return $results;
    }

    /**
     * Get all stores name and id
     */
    public function getStoresName() {
        if(!cache()->get('getStoresName')) {
            $result = $this->select('id, store_name')->where('store_status',1)
                ->where('status',2)
                ->where('deleteStatus',0)
                ->findAll();
            cache()->save('getStoresName', $result ?? [], ZapptaHelper::CACHE_SECONDS);
        }
        return cache()->get('getStoresName');
    }

    /**
     * Count all stores
     * @return int
     */
    public function countStores()
    {
        $result =$this->where('store_status',1)
            ->where('status',2)
            ->where('deleteStatus',0)
            ->orderBy('id DESC')
            ->countAllResults();
        return $result;
    }

    public function GetEmailsOfVendors(){

        return $this->db->table($this->table)
                        ->select('vendor.email')
                        ->get()
                        ->getResultArray();
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

    public function findIdByUrl($url)
    {
        $user = $this
                    ->asArray()
                    ->where(['store_slug' => $url,'store_status' => 1, 'status' => 2])
                    ->first();
        if(!empty($user))    
            return $user;
    }

    public function findStoreById($id)
    {
        $user = $this
                    ->asArray()
                    ->where(['id' => $id,'store_status' => 1, 'status' => 2])
                    ->first();
        if(!empty($user))    
            return $user;
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
                    ->where(['email' => $email,'status' => 2])
                    ->first();
        if(!empty($user)) {    
            return $user;
        }
        return false;
    }

    public function findByUserId()
    {
        $user = $this
                    ->asArray()
                    ->where(['id' => getVendorUserId(),'status' => 2])
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
                $session->set('vendorIsLoggedIn' , [ 'user_id' => $user['id'] , 'user_name' => $user['store_name'] ]);
                return true;
            } else {
                return 0;
            }
        } else {
                return 0;
        }
    }

    public function getOrderStats()
    {
        $select = 'SELECT 
                        ( SELECT COUNT(order_id) FROM cms_order_items WHERE store_id='.getVendorUserId().' AND MONTH(created_at) = MONTH(CURRENT_DATE()) ) as total_order , 
                        ( SELECT COUNT(order_id) FROM cms_order_items WHERE store_id='.getVendorUserId().' AND MONTH(created_at) = MONTH( CURRENT_DATE - INTERVAL 1 MONTH ) ) as last_total_order, 
                        ( SELECT COUNT(order_id) FROM cms_order_items WHERE store_id='.getVendorUserId().' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND item_status=0 ) as pending_total_order, 
                        ( SELECT COUNT(order_id) FROM cms_order_items WHERE store_id='.getVendorUserId().' AND MONTH(created_at) = MONTH( CURRENT_DATE - INTERVAL 1 MONTH ) AND item_status=0 ) as last_pending_total_order, 
                        ( SELECT SUM(subtotal) FROM cms_order_items WHERE store_id='.getVendorUserId().' AND MONTH(created_at) = MONTH(CURRENT_DATE()) ) as total_revnue , 
                        ( SELECT SUM(subtotal) FROM cms_order_items WHERE store_id='.getVendorUserId().' AND MONTH(created_at) = MONTH( CURRENT_DATE - INTERVAL 1 MONTH )  ) as last_total_revnue,

                        ( SELECT COUNT(order_id) FROM cms_order_items WHERE store_id = '.getVendorUserId().' AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) ) AS current_month_orders,
                        
                        ( SELECT COUNT(order_id) FROM cms_order_items WHERE store_id = '.getVendorUserId().' AND MONTH(created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(created_at) = YEAR(CURDATE() - INTERVAL 1 MONTH) ) AS last_month_orders
                    FROM cms_order_items WHERE store_id='.getVendorUserId().'';
        $sql = $this->db->query($select)
                        // ->get()
                        ->getRowArray();
        return $sql;
    }

    public function getChartData()
    {
        $result = [];   
        $select = 'SELECT 
            DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL numbers.n MONTH), "%M %Y") AS dmonth,
            COUNT(o.order_id) AS ocount
        FROM 
            (
                SELECT 0 as n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 
                UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 
                UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 
                UNION ALL SELECT 10 UNION ALL SELECT 11
            ) as numbers
        LEFT JOIN 
            cms_order_items o ON 
                MONTH(o.created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL numbers.n MONTH)) 
                AND YEAR(o.created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL numbers.n MONTH))
                AND o.store_id = '.getVendorUserId().'
        GROUP BY 
            numbers.n
        ORDER BY 
           o.created_at ASC;';
        $sql = $this->db->query($select)
                        ->getResultArray();
        if (  is_array( $sql ) && count($sql) > 0 ) {
            foreach ( $sql as $a ) {
                $result['months'][] = $a['dmonth'];
                $result['count'][] = $a['ocount'];
            }
        }
        return $result;
    }

    /**
     * Get sales data throughout year
     * @author M Nabeel Arshad
     * @return array
     */
    public function getsalesData() : array {
        $result = [];   
        $select = 'SELECT 
            DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL numbers.n MONTH), "%M %Y") AS dmonth,
            SUM(o.subtotal) AS osubtotal
        FROM 
            (
                SELECT 0 as n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 
                UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 
                UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 
                UNION ALL SELECT 10 UNION ALL SELECT 11
            ) as numbers
        LEFT JOIN 
            cms_order_items o ON 
                MONTH(o.created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL numbers.n MONTH)) 
                AND YEAR(o.created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL numbers.n MONTH))
                AND o.store_id = '.getVendorUserId().'
        GROUP BY 
            numbers.n
        ORDER BY 
           o.created_at ASC;';
        $sql = $this->db->query($select)
                        ->getResultArray();
        if (  is_array( $sql ) && count($sql) > 0 ) {
            foreach ( $sql as $a ) {
                $result['months'][] = $a['dmonth'];
                $result['count'][] = number_format(($a['osubtotal'] ?? 0), 2);
            }
        }
        return $result;
    }

    public function getAccount()
    {
        $sql = $this->db->table('order_items')
                        ->selectSum('subtotal')
                        ->where('store_id',getVendorUserId())
                        ->groupBy('order_id')
                        ->get()
                        ->getRowArray();
        return $sql;
    }

    public function getCommissionAccount()
    {
        $sql = $this->db->table('order_items')
                        ->selectSum('zappta_commission')
                        ->where('store_id',getVendorUserId())
                        ->groupBy('order_id')
                        ->get()
                        ->getRowArray();
        return $sql;
    }

    public function getTotalAccount()
    {
        $storeid = getVendorUserId();
         $select = 'SELECT item_name , order_id , subtotal , zappta_commission
                      FROM cms_order_items cs WHERE cs.store_id = '.getVendorUserId().' ';
        $sql = $this->db->query($select)
                        ->getResultArray();
        return $sql;
    }
     public function getTotalAccountForReport()
    {
        $storeid = getVendorUserId();
         $select = 'SELECT item_name , order_id , subtotal , zappta_commission ,item_status
                      FROM cms_order_items cs WHERE cs.store_id = '.getVendorUserId().' ';
        $sql = $this->db->query($select)
                        ->getResultArray();
        return $sql;
    }

    public function getVendorStats($limit=3, $within)
    {
        return $this->db->table('cms_order_items')
                        ->select('cms_vendor.*, SUM(cms_order_items.subtotal) as revenue, COUNT(cms_order_items.item_id) AS products')
                        ->join('cms_vendor','cms_order_items.store_id=cms_vendor.id','INNER')
                        ->where('cms_order_items.created_at between date_sub(now(),INTERVAL 1 '.$within.') and now()')
                        ->where('cms_vendor.deleteStatus', 0)
                        ->groupBy('cms_order_items.store_id')
                        ->orderBy('revenue DESC')
                        ->limit($limit)
                        ->get()
                        ->getResultArray();
    }
    public function getSprees($limit=10)
    {
        return $this->db->table('vendor_sprees')
                        ->select('vendor_sprees.*, compain.compain_name, compain.compain_s_date as start_date, compain.compain_e_date as end_date')
                        ->join('compain','compain.id=vendor_sprees.com_id')
                        // ->where('start_date between date_sub(now(),INTERVAL 1 '.$within.') and now()')
                        ->where('vendor_sprees.vendor_id', getVendorUserId())
                        ->limit($limit)
                        ->get()
                        ->getResultArray();
    }

    public function insertSpree($arr)
    {
        $this->db->table('vendor_sprees')->insert($arr);
    }

    public function getSpreesVendorsTotal()
    {
        $sql = $this->db->table('vendor_sprees')
                        ->where('vendor_id',getVendorUserId())
                        ->countAllResults();
        return $sql;
    }

    public function getSpreeById($id, $admin = false)
    {
        if($admin) {
            $sql = $this->db->table('vendor_sprees')
                            ->select("vendor_sprees.*, compain.compain_name, compain.compain_s_date, compain.compain_e_date")
                            ->join("compain", "vendor_sprees.com_id = compain.id")
                            // ->where('vendor_sprees.vendor_id',getVendorUserId())
                            ->where('vendor_sprees.id',$id)
                            ->get()
                            ->getResult();
        }else {
            $sql = $this->db->table('vendor_sprees')
                            ->select("vendor_sprees.*, compain.compain_name, compain.compain_s_date, compain.compain_e_date")
                            ->join("compain", "vendor_sprees.com_id = compain.id")
                            ->where('vendor_sprees.vendor_id',getVendorUserId())
                            ->where('vendor_sprees.id',$id)
                            ->get()
                            ->getResult();
        }
        
        return $sql?$sql[0]:[];
    }

    public function getPublicSpreeById($id)
    {
        $sql = $this->db->table('vendor_sprees')
                        ->select("vendor_sprees.*, vendor.store_name, vendor.store_logo, compain.compain_s_date, compain.compain_e_date")
                        ->join("vendor", "vendor.id = vendor_sprees.vendor_id")
                        ->join("compain", "compain.id = vendor_sprees.com_id")
                        ->where('vendor_sprees.id',$id)
                        ->get()
                        ->getResult();
        
        return $sql?$sql[0]:[];
    }
    public function getSpreeByVendorComId($vendor_id, $com_id)
    {
        $sql = $this->db->table('vendor_sprees')
                        ->where('vendor_id',$vendor_id)
                        ->where('com_id',$com_id)
                        ->get()
                        ->getResult();
        
        return $sql?$sql[0]:[];
    }

    public function updateSpree($update, $id)
    {
        $this->db->table('vendor_sprees')->update($update, ['id' => $id]);
    }

    public function deleteSpree($id, $admin = false)
    {
        if($admin) {
            $sql = $this->db->table('vendor_sprees')->where('id',$id)->delete();
        }else {
            $sql = $this->db->table('vendor_sprees')->where('vendor_id',getVendorUserId())->where('id',$id)->delete();
        }
        if($sql){
            return true;
        }
        return false;
    }

    public function checkIfSpreeAlreadyExist($com_id)
    {
        $sql = $this->db->table('vendor_sprees')
                        ->where('vendor_id',getVendorUserId())
                        ->where('com_id',$com_id)
                        ->get()
                        ->getResult();
        
        return $sql?$sql[0]:[];
    }

    public function getSpreesToDisplayUpcoming($limit=10)
    {
        if( !cache()->get('getSpreesToDisplayUpcoming') ) {
            $result = $this->db->table('vendor_sprees')
                    ->select('cms_vendor_sprees.*, cms_compain.compain_s_date, cms_vendor.store_logo, cms_vendor.store_name, cms_vendor.store_slug')
                    ->join('cms_compain', 'cms_vendor_sprees.com_id = cms_compain.id')
                    ->join('cms_vendor', 'cms_vendor.id = cms_vendor_sprees.vendor_id')
                    ->where('cms_vendor_sprees.status', 1)
                    ->where('vendor.deleteStatus',0)
                    ->where('compain.compain_s_date >= ',date('Y-m-d'))
                    ->limit($limit)
                    ->orderBy('id DESC')
                    ->get()
                    ->getResultArray();
            cache()->save('getSpreesToDisplayUpcoming', $result ?? [], ZapptaHelper::CACHE_SECONDS);
        }
        $results = [];
        foreach (cache()->get('getSpreesToDisplayUpcoming') as $key => $value) {
            $value['store_logo'] = getImageThumg('media', $value['store_logo'], 250);
            $value['cover'] = getImageThumg('media/spree', $value['cover'], 250);
            $results[] = $value;
        }
        return $results;
    }


    public function getSpreesToDisplayOnAdminCp($store_id)
    {
        // return $this->db->table('vendor_sprees')
        //                 ->select('cms_vendor_sprees.*, cms_compain.compain_s_date, cms_vendor.store_logo, cms_vendor.store_name, cms_vendor.store_slug')
        //                 ->join('cms_compain', 'cms_vendor_sprees.com_id = cms_compain.id')
        //                 ->join('cms_vendor', 'cms_vendor.id = cms_vendor_sprees.vendor_id')
        //                 ->where('vendor.deleteStatus',0)
        //                 ->where('compain.compain_s_date >= ',date('Y-m-d'))
        //                 ->orderBy('id DESC')
        //                 ->get()
        //                 ->getResultArray();

        return $this->db->table('vendor_sprees')
                        ->select('vendor_sprees.*, compain.compain_name, compain.compain_s_date as start_date, compain.compain_e_date as end_date')
                        ->join('compain','compain.id=vendor_sprees.com_id')
                        // ->where('start_date between date_sub(now(),INTERVAL 1 '.$within.') and now()')
                        ->where('compain.id', $store_id)
                        // ->limit($limit)
                        ->get()
                        ->getResultArray();
    }

    public function getSpreesToDisplayOngoing($limit=10)
    {
        if( !cache()->get('getSpreesToDisplayOngoing') ) {
            $result = $this->db->table('vendor_sprees')
                            ->select('cms_vendor_sprees.*, cms_compain.compain_e_date, cms_vendor.store_logo, cms_vendor.store_name, cms_vendor.store_slug')
                            ->join('cms_compain', 'cms_vendor_sprees.com_id = cms_compain.id')
                            ->join('cms_vendor', 'cms_vendor.id = cms_vendor_sprees.vendor_id')
                            ->where('vendor.deleteStatus',0)
                            ->where('cms_vendor_sprees.status', 1)
                            ->where('compain.compain_e_date >= ',date('Y-m-d'))
                            ->where('compain.compain_s_date < ',date('Y-m-d'))
                            ->where('compain.compain_s_date < ',date('Y-m-d'))
                            ->limit($limit)
                            ->orderBy('id DESC')
                            ->get()
                            ->getResultArray();
            cache()->save('getSpreesToDisplayOngoing', $result ?? [], ZapptaHelper::CACHE_SECONDS);
        }
        $results = [];
        foreach (cache()->get('getSpreesToDisplayOngoing') as $key => $value) {
            $value['store_logo'] = getImageThumg('media', $value['store_logo'], 250);
            $value['cover'] = getImageThumg('media/spree', $value['cover'], 250);
            $results[] = $value;
        }
        return $results;
    }


}
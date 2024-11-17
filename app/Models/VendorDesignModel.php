<?php 

namespace App\Models;

use CodeIgniter\Model; 

class VendorDesignModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table      			= 'vendor_design';
    protected $primaryKey 			= 'id';

    protected $useAutoIncrement 	= true;
	protected $insertID         	= 0;
    protected $returnType     		= 'array';
    protected $useSoftDelete 		= false;
    protected $protectFields        = true;


    protected $allowedFields = [ 
                                'vendor_id', 
                                'header_banner',
                                'category_banner_first',
                                'category_link_first',
                                'category_banner_second',
                                'category_link_second',
                                'category_banner_third',
                                'category_link_third',
                                'category_banner_fourth',
                                'category_link_fourth',
                                'middle_banner',
                                'category_title_first',
                                'category_title_second',
                                'category_title_third',
                                'category_title_fourth',
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

    
    public function getVendorDesignById($id)
    {
        $sql = $this->where('vendor_id',$id)->first();
        $sql['header_banner'] = getImageThumg('media', $sql['header_banner'], 1980);
        if ( !empty($sql) ) {
            return $sql;
        }
        return 0;
    }

    public function getVendorDesign()
    {
        $sql = $this->where('vendor_id',getVendorUserId())->first();
        if ( !empty($sql) ) {
            return $sql;
        }
        return 0;
    }

    public function getFeild($field)
    {
        if ( $this->db->fieldExists($field,$this->table) ) {
            return 1;
        }
        return 0;
    }

    public function updatedata($field,$value,$id)
    {
        if ( $this->getVendorDesign() > 0 ) {
            $this->db->table($this->table)
                     ->set($field,$value)
                     ->where('vendor_id',$id)
                     ->update();
            return true;
        } else {
            $this->db->table($this->table)
                     ->set($field,$value)
                     ->set('vendor_id',$id)
                     ->insert();
            return true;
        }
    }

}
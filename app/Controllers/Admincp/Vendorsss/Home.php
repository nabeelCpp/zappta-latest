<?php 
namespace App\Controllers\Admincp\Vendors;

use App\Controllers\Admincp\BaseController;
use App\Models\VendorModel;

class Home extends BaseController
{
    
    public function index()
    {
        $data['slider'] = (new VendorModel())->getAllResult();
        return view('admin/vendors/index',$data);
    }    
    
    public function add()
    {
        $data['slider'] = (new VendorModel())->getAllResult();
        return view('admin/vendors/index',$data);
    }  
    
}

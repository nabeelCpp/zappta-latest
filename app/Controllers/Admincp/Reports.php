<?php

namespace App\Controllers\Admincp;

use App\Models\OrderModel;
use App\Models\Setting;
class Reports extends BaseController
{
	protected $Payments;
	 public function index(){
	 	$this->Payments = new OrderModel();
	 	$data['payments'] = $this->Payments->GETrecordOfPaymentsAgain();
	 	// print_r($data['payments']);
	 	// die();
	 	$settingModel = new Setting;
	 	$data['app_commision'] = $settingModel->where('var_name', 'ZAPTA_COMMISSION')->get()->getRow()->var_detail;
	
	 	return view('admin/reports/index',$data);
	 }
}
<?php

namespace App\Controllers\Admincp;

use App\Models\OrderModel;
use App\Models\Setting;
class Payments extends BaseController
{
	protected $Payments;
	 public function index(){
	 	$this->Payments = new OrderModel();
	 	$data['payments'] = $this->Payments->GetRecordOfPayments();
	 	$settingModel = new Setting;
	 	$data['app_commision'] = $settingModel->where('var_name', 'ZAPTA_COMMISSION')->get()->getRow()->var_detail;
	//die();f
	 	return view('admin/payments/index',$data);
	 }
}
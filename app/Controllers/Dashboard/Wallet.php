<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Setting;
use App\Models\UsersNotification;

class Wallet extends BaseController
{
    
    public function index()
    {
        (new UsersNotification())->markAsRead('dashboard/wallet');
        $data['pagetitle'] = 'Wallet';
        $data['total_zappta']['zapta_earn'] = userTotalZappta();
        // $data['total_zappta'] = (new Setting())->totalZapptaDollor();
        $data['total_spend'] = (new Setting())->totalSpendZapptaDollor();
        return view('dashboard/wallet/index',$data);
    }

    public function saveZapptas()
    {
        $minutes = $this->request->getVar('minutes');
        $store_url = $this->request->getVar('store_url');
        (new Setting())->insertSelectItems('ZAPPTA_SELECT_ITEMS',$store_url,$minutes);
        echo json_encode(['zapptas' => userTotalZappta()]);
    }
    
}

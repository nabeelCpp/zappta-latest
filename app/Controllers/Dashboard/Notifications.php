<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use CodeIgniter\HTTP\ResponseInterface;

class Notifications extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Notifications',
            'notifications' => (new \App\Models\UsersNotification())->where('user_id', getUserId())->orderBy('id', 'DESC')->findAll(6),
            'assets_url' => ZapptaHelper::loadAssetsUrl()
        ];

        return view('dashboard/notifications', $data);
    }
}

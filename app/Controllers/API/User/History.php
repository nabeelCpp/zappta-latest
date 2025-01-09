<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Traits\Dashboard\HistoryTrait;
use CodeIgniter\HTTP\ResponseInterface;

class History extends BaseController
{
    use HistoryTrait;
    public function index()
    {
        $order_id = request()->getGet('order_id') ?? null;
        $data = HistoryTrait::historyTrait($order_id);

        return response()->setJSON($data);
    }
}

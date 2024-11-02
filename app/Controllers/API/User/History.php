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
        $data = HistoryTrait::historyTrait();
        return response()->setJSON($data);
    }
}

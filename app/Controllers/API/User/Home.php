<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\UserTrait;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    use UserTrait, ResponseTrait;

    /**
     * User login
     */
    public function index()
    {
        $customer = $this->request->customer ?? null;
        return $this->response->setJSON($customer);
    }
}

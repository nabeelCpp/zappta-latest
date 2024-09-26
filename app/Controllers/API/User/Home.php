<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\UserTrait;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
    use UserTrait, ResponseTrait;

    /**
     * User login
     */
    public function index()
    {
        return $this->response->setJSON(getallheaders());
    }
}

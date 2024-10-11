<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use CodeIgniter\HTTP\ResponseInterface;

class Cart extends BaseController
{
    public function index()
    {
        $data = get_cart_contents();
        $response = ZapptaHelper::response('Cart contents fetched successfully.', $data);
        return response()->setJSON($response);
    }
}

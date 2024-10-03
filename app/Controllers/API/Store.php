<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Models\VendorModel;
use App\Traits\ZapptaTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Store extends BaseController
{
    use ZapptaTrait;
    /**
     * Get all stores!
     * @return json
     */
    public function index()
    {
        $data['stores'] = (new VendorModel())->getHomeResult();
        $response = ZapptaHelper::response('Stores fetched successfully', $data);
        return $this->response->setJSON($response);
    }

    /**
     * Single Store data
     * @param string $slug
     * 
     */
    public function single($slug) {
        ZapptaHelper::makeSelectedGetParamsEncrypt();
        $data = $this->storesTrait($slug);
        if(!$data) {
            $response = ZapptaHelper::response('Store not found!', $data, 404);
            return $this->response->setJSON($response);
        }
        // $meta = $data['meta'] ?? null;
        // if(isset($data['meta'])) {
        //     unset($data['meta']);
        // }
        $response = ZapptaHelper::response('Store fetched successfully!', $data, 200);
        return $this->response->setJSON($response);
        
    }
}

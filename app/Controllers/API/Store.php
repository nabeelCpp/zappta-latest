<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Models\VendorModel;
use App\Traits\ZapptaTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Store extends BaseController
{
    protected const GET_VARIABLES_ENCRYPT = ['p'];
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
        $post = request()->getVar();
        ZapptaHelper::makeSelectedGetParamsEncrypt($this::GET_VARIABLES_ENCRYPT);
        $data = $this->storesTrait($slug);
        if(!$data) {
            $response = ZapptaHelper::response('Store not found!', $data, 404);
            return $this->response->setJSON($response);
        }
        // check if store require spree data
        if(isset($post->enable_spin_cart) && $post->enable_spin_cart) {
            $spree_data = ZapptaTrait::spreeData($post->com_id, $data['store']['id']);
            $sprees = [];
            foreach ($spree_data['spree'] as $key => $sp) {
                $sprees[] = $sp['pid'];
            }
            $spree_data['spree'] = $sprees;
            $data['spin_cart'] = $spree_data;
        }
        // $meta = $data['meta'] ?? null;
        // if(isset($data['meta'])) {
        //     unset($data['meta']);
        // }
        $response = ZapptaHelper::response('Store fetched successfully!', $data, 200);
        return $this->response->setJSON($response);
        
    }
}

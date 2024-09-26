<?php
namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\ZapptaTrait;

class Category extends BaseController {
    use ZapptaTrait;

    public function __construct() {
        
    }
    /**
     * Home controller to get all data for landing page.
     * @return json
     */
    public function index()  {
        $data['categories'] = getHomeCategory();
        $response = ZapptaHelper::response('Categories', $data);
        return $this->response->setJSON($response);
    }
    
    /**
     * Single category data
     * @param string $slug
     * 
     */
    public function single($slug) {
        ZapptaHelper::makeSelectedGetParamsEncrypt();
        $data = $this->categoryTrait($slug);
        $meta = $data['meta'] ?? null;
        if(isset($data['meta'])) {
            unset($data['meta']);
        }
        $response = ZapptaHelper::response('Single Category fetched successfully!', $data, 200, $meta);
        return $this->response->setJSON($response);
        
    }
}

?>
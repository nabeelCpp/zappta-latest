<?php
namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\ZapptaTrait;

class Home extends BaseController {
    use ZapptaTrait;

    public function __construct() {
        
    }
    /**
     * Home controller to get all data for landing page.
     * @return json
     */
    public function index()  {
        $data = $this->homeTrait();
        $response = ZapptaHelper::response('Home page data', $data);
        return $this->response->setJSON($response);
    }
}

?>
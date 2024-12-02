<?php
namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\ZapptaTrait;

class Home extends BaseController {
    use ZapptaTrait;

    /**
     * This constant is mainly for api, either to encrypt get parameter or not
     */
    protected const GET_VARIABLES_ENCRYPT = ['c'];

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

    /**
     * Display product details
     * @author M Nabeel Arshad
     */
    public function product($url, $pc) {
        $request = request();
        $sd_row = filtreData($request->getVar('sd_row'));
        $pds = filtreData($request->getVar('pds'));
        $data = $this->productTrait($url, $pc, $sd_row, $pds);
        return response()->setJSON(ZapptaHelper::response('Product details fetched successfully!', $data));
    }

    /**
     * Get image dimensions
     * @return json
     * 
     */
    public function imageDimensions() {
        $data = getImageDimensions();
        $response = ZapptaHelper::response('Image dimensions fetched successfully!', $data);
        return response()->setJSON($response);
    }

    /**
     * Global search
     */
    public function search() {
        if(isset($_GET['c']) && (int) $_GET['c'] > 0) {
            ZapptaHelper::makeSelectedGetParamsEncrypt($this::GET_VARIABLES_ENCRYPT);
        }
        $get = $_GET;
        $data = $this->globalSearchTrait($get);
        $response = ZapptaHelper::response('Search data fetched successfully!', $data);
        return response()->setJSON($response);
    }
}

?>
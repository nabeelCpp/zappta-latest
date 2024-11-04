<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\VendorModel;
use App\Models\VendorDesignModel;
use App\Models\ProductsModel;
use App\Models\CategoriesModel;
use App\Traits\ZapptaTrait;

class Stores extends BaseController
{
    use ZapptaTrait;

    protected $VendorModel;

    public function __construct() {
        $this->VendorModel = new VendorModel();
    }


    public function index()
    {
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        // $data['css'] = ZapptaHelper::loadModifiedThemeCss();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        // $data['store_id'] = (new VendorModel())->findIdByUrl($this->request->getUri()->getSegment(2));
        $data['pagetitle'] = 'Stores';
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['limit'] = $_GET['limit'] ?? ProductsModel::LIMIT;
        $data['store'] = $this->VendorModel->getStores($data['page'], $data['limit']);
        $data['total'] = $this->VendorModel->countStores();
        $data['pager'] = service('pager');
        if (!empty($data['store_id'])) {
            $data['products'] = (new ProductsModel())->getStoreListing($data['store_id']['id']);
        } else {
            $data['products'] = [];
        }
        return view('site/stores/index', $data);
        // return redirect()->to('/');
    }

    public function view()
    {
        $data =  $this->storesTrait($this->request->getUri()->getSegment(2));
        if(!$data) {
            return redirect()->to('/');
        }
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['css'] = ZapptaHelper::loadModifiedThemeCss();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        $data['sticky_header'] = true;
        if(isset($_GET['cat']) ) {
            return view('site/stores/storecat', $data);
        }else {
            return view('site/stores/view', $data);
        }
    }

    public function category()
    {
        $data['pagetitle'] = 'Adidas';
        // $data['homeslider'] = (new SliderModel())->getAllResult();
        return view('site/stores/category', $data);
    }

    public function single()
    {
        $data['pagetitle'] = 'Adidas';
        // $data['homeslider'] = (new SliderModel())->getAllResult();
        return view('site/stores/single', $data);
        // print_r(get_cart_contents());
    }

    public function cart()
    {
        $data['pagetitle'] = 'Cart';
        // $data['homeslider'] = (new SliderModel())->getAllResult();
        return view('site/stores/cart', $data);
    }
}

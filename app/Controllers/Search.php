<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\AttributeModel;
use App\Models\BrandModel;
use App\Models\ProductsModel;
use App\Models\VendorModel;
use App\Traits\ZapptaTrait;
use Google\Service\AdExchangeBuyerII\Product;

class Search extends BaseController
{
    use ZapptaTrait;
    public function index()
    {
        $data = $this->globalSearchTrait($_GET);
        $data['categories'] = getHomeCategory();
        $data['vendors'] = (new VendorModel())->getStoresName();
        $data['brands'] = (new BrandModel())->getAllBrands();
        $data['current_url'] = current_url().(isset($_GET) ? '?'.http_build_query($_GET) : '');
        $p = isset($_GET['p']) ? $_GET['p'] : '';
        if($p) {
            $price = explode('-', $p);
            $data['min_price'] = $price[0];
            $data['max_price'] = $price[1];
        }
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['css'] = '';
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        return view('site/search/index',$data);
    }

}

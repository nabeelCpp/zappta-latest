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
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        $data['categories'] = buildTree($data['categories']);
        $data['sticky_header'] = true;
        
        // if(isset($_GET['cat']) ) {
        //     return view('site/stores/storecat', $data);
        // }else {
            return view('site/stores/view', $data);
        // }
    }

    public function view_old()
    {
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['css'] = ZapptaHelper::loadModifiedThemeCss();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        $data['sticky_header'] = true;
        $data['store_id'] = (new VendorModel())->findIdByUrl($this->request->getUri()->getSegment(2));
        if ( !empty($data['store_id']) ) {
            $searchq = isset($_GET['searchq']) ? filtreData(urldecode($_GET['searchq'])) : '';
            $cat = isset($_GET['cat']) ? filtreData($_GET['cat']) : '';
            $p_cat = isset($_GET['p']) ? filtreData(my_decrypt($_GET['p'])) : '';
            $data['search_url'] = base_url().'/stores/'.$this->request->getUri()->getSegment(2);
            if ( !empty($cat) ) {
            $data['search_url'] = base_url().'/stores/'.$this->request->getUri()->getSegment(2).'/?cat='.$cat.'&p='.$_GET['p'];
            }
            $data['categories'] = (new CategoriesModel())->getStoreSelectedCat($data['store_id']['id']);
            if ( !empty($cat) ) {
                $data['proids'] = (new CategoriesModel())->getStoreProductsByCatId($data['store_id']['id'],$p_cat);
                $data['vendor_design'] = (new VendorDesignModel())->getVendorDesignById($data['store_id']['id']);
                $data['pagetitle'] = $data['store_id']['store_name'];
                if ( !empty($data['store_id']) && !empty($data['proids'])) {
                    if ( !empty($searchq) ) {
                        $data['products'] = (new ProductsModel())->getStoreListingByProBySearch($data['store_id']['id'],$searchq,$data['proids']);
                    } else {
                        $data['products'] = (new ProductsModel())->getStoreListingByPro($data['store_id']['id'],$data['proids']);
                    }
                } else {
                    $data['products'] = [];
                }
                return view('site/stores/storecat',$data);
            } else {
                $data['vendor_design'] = (new VendorDesignModel())->getVendorDesignById($data['store_id']['id']);
                $data['pagetitle'] = $data['store_id']['store_name'];
                if ( !empty($data['store_id']) ) {
                    if ( !empty($searchq) ) {
                        $data['products'] = (new ProductsModel())->getStoreListingBySearch($data['store_id']['id'],$searchq);
                    } else {
                        $data['products'] = (new ProductsModel())->getStoreListing($data['store_id']['id']);
                    }
                } else {
                    $data['products'] = [];
                }
                return view('site/stores/~view',$data);
            }
        } else {
            return redirect()->to('/');
        }
        // print '<pre>';
        // print_r($data['vendor_design']);
        // print '</pre>';
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

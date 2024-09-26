<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\AttributeModel;
use App\Models\ProductsModel;

class Search extends BaseController
{
    public function index()
    {
        // if ( ! $this->request->getVar('searchq')  ) {
        //     return redirect()->to('/');
        // }
        $data['searchq'] = !empty(filtreData(urldecode($this->request->getVar('searchq')))) ? filtreData(urldecode($this->request->getVar('searchq'))) : '';
        $data['search_cat'] = !empty(filtreData(urldecode($this->request->getVar('c')))) ? my_decrypt( filtreData(urldecode($this->request->getVar('c'))) ) : 0;
        
        $size = isset($_GET['size']) ? $_GET['size'] : ''; 
        $color = isset($_GET['color']) ? $_GET['color'] : ''; 
        $dimension = isset($_GET['dimension']) ? $_GET['dimension'] : ''; 
        $paper_type = isset($_GET['paper_type']) ? $_GET['paper_type'] : ''; 
        $p = isset($_GET['p']) ? $_GET['p'] : ''; 
        $data['filter'] = isset($_GET) ? $_GET : [];
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;

        $data['attrbutes'] = (new AttributeModel())->getAttributesValues(); 
        $data['products'] = (new ProductsModel())->getSearchProducts($data['search_cat'],$data['searchq'],$data['filter'],$data['page']);
        $data['total_products'] = (new ProductsModel())->getSearchProductsCounts($data['search_cat'],$data['searchq'],$data['filter']);
        if ( $data['total_products'] > 12 ) {
            $data['pager'] = service('pager');
        }
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['css'] = ZapptaHelper::loadModifiedThemeCss();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        return view('site/search/index',$data);
    }

}

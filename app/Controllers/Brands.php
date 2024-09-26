<?php

namespace App\Controllers;

use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\BrandModel;

class Brands extends BaseController
{

    public function index()
    {
        $data['allcat'] = (new CategoriesModel())->getAllCategoryForTree();
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        // $data['products'] = (new ProductsModel())->getAllProductByCategory($data['page']);
        // $data['total_products'] = (new ProductsModel())->getAllTotalProductByCategory();
        $data['brands'] = (new BrandModel())->getAllResult($data['page']);
        $data['total_brands'] = (new BrandModel())->getTotal();
        $data['pager'] = service('pager');
        return view('site/brands/index',$data);
        // dd((new CategoriesModel())->getAllCategoryForTree());
    }
      
    public function single()
    {

        $data['allcat'] = (new CategoriesModel())->getAllCategoryForTree();

        $data['brand_id'] = (new BrandModel())->getByUrl(filtreData($this->request->getUri()->getSegment(2)));
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['products'] = (new ProductsModel())->getProductByBrands((int)$data['brand_id']['id'],$data['page']);
        $data['total_products'] = (new ProductsModel())->getTotalProductByBrands((int)$data['brand_id']['id']);
        $data['pager'] = service('pager');
        $data['brands'] = (new BrandModel())->findAll();
        return view('site/brands/single',$data);
        // dd($data['allcat']);
    }
        
}

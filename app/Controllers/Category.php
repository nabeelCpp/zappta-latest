<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use App\Models\BrandModel;
use App\Models\AttributeModel;
use App\Traits\ZapptaTrait;

class Category extends BaseController
{
    use ZapptaTrait;

    public function index()
    {
        if(isset($_GET['c'])) {
            $cid = my_decrypt($_GET['c']);
        }
        $category = (new CategoriesModel)->where('id', $cid)->first();
        if($category) {
            return redirect()->to('/categories/'.$category['cat_url'].($_GET['searchq'] ? '?q='.$_GET['searchq'] : ''));
        }
        // $data['allcat'] = (new CategoriesModel())->getAllCategoryForTree();
        // $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        // $data['products'] = (new ProductsModel())->getAllProductByCategory($data['page']);
        // $data['total_products'] = (new ProductsModel())->getAllTotalProductByCategory();
        // $data['pager'] = service('pager');
        // $data['brands'] = (new BrandModel())->getAllResult();
        // return view('site/category/index',$data);
        // dd((new CategoriesModel())->getAllProductByCategory());
        return redirect()->to('/');
    }
      
    public function single($slug)
    {
        $data = $this->categoryTrait($slug);
        if(!$data) {
            return redirect()->to('/');
        }
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        // $data['css'] = ZapptaHelper::loadModifiedThemeCss();
        $data['exclude_attr'] = ['Color'];
        return view('site/category/index',$data);
        // dd($data['products']);
        // print '<pre>';
        // print_r(count($data['products']));
        // print '</pre>'; 
        // print '<pre>';
        // print_r($data['products']);
        // print '</pre>';
    }

    public function singlee($slug)
    {
        $data = $this->categoryTrait($slug);
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['css'] = ZapptaHelper::loadModifiedThemeCss();
        $data['exclude_attr'] = [''];
        return view('site/category/~index',$data);
        // dd($data['products']);
        // print '<pre>';
        // print_r(count($data['products']));
        // print '</pre>'; 
        // print '<pre>';
        // print_r($data['products']);
        // print '</pre>';
    }
        
}

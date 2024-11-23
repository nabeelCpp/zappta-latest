<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\ProductsModel;
use App\Models\Setting;
use App\Models\NotificationModel;
use App\Models\ReviewModel;
use App\Models\CategoriesModel;
use App\Models\VendorModel;
use App\Traits\ZapptaTrait;

class Products extends BaseController
{
    use ZapptaTrait;

    /*
    *   Get Single product
    *   return array
    */
    public function index()
    {
        $request = request();
        $data['sticky_header'] = true;
        $url = filtreData($request->getUri()->getSegment(2));
        $pc = filtreData($request->getUri()->getSegment(4));
        $sd_row = filtreData($request->getVar('sd_row'));
        $pds = filtreData($request->getVar('pds'));
        $data = $this->productTrait($url, $pc, $sd_row, $pds);
        $data['image_path'] = 'products/';
        $data['pagetitle'] = 'Adidas';
        // dd($data);
        // for new design
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        return view('site/stores/single', $data);
    }

    /**
     * Load More Products
     */
    public function loadMoreProducts()
    {
        if($this->request->isAJAX()) {
            $offset = $this->request->getGet('offset'); // Receive offset from AJAX
            $pid = $this->request->getGet('pid');  // Product IDs (if needed)
            $category_id = $this->request->getGet('cat_id');  // Product IDs (if needed)
            $proids = (new CategoriesModel())->getRelatedCategories($category_id,$pid);
            $related = (new ProductsModel())->getRelatedProduct($proids, $offset);
            $related['products'] = $this->wishlistStatusOnProducts($related['products']);
            $product = (new ProductsModel())->getProductById($pid);
            $data['store'] = (new VendorModel())->findStoreById($product['store_id']);
            $data['count'] = $related['products'];
            $data['col'] = 4;
            $data['view_more'] = $related['moreProductsAvailable'];
            $data['offset'] = $related['offset'];
            $data['product_category'] = $category_id;
            $data['id'] = $pid;
            $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
            return view('site/stores/prolist', $data);

        }
    }


    public function index_old()
    {
        $request = request();
        $data['sticky_header'] = true;
        $url = filtreData($request->getUri()->getSegment(2));
        $pc = filtreData($request->getUri()->getSegment(4));
        $sd_row = filtreData($request->getVar('sd_row'));
        $pds = filtreData($request->getVar('pds'));
        $data = $this->productTrait($url, $pc, $sd_row, $pds);
        $data['image_path'] = 'products/';
        $data['pagetitle'] = 'Adidas';
        // dd($data);
        // for new design
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        return view('site/stores/~single', $data);
    }

    public function askquestion()
    {
        if ($this->request->isAJAX()) {
            $pid = filtreData($this->request->getVar('pid'));
            $askQuestionDetail = filtreData($this->request->getVar('askQuestionDetail'));
            if ($pid == "" || $askQuestionDetail == "") {
                $data = ['code' => (int)1, 'msg' => 'Please fill all fields ( * )', 'token' => csrf_hash()];
                return json_encode($data);
            } else {
                $vendor_id = (new ProductsModel())->getProductVendorById(my_decrypt($pid));
                (new NotificationModel())->add([
                    'user_id' => getUserId(),
                    'product_id' => my_decrypt($pid),
                    'vendor_id' => $vendor_id,
                    'message' => $askQuestionDetail,
                    'status' => 1,
                ]);
                $data = ['code' => (int)2, 'msg' => 'Message Successfully Sent', 'token' => csrf_hash()];
                return json_encode($data);
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function ratecomments()
    {
        if ($this->request->isAJAX()) {
            $pid = filtreData($this->request->getVar('pid'));
            $produtRating = filtreData($this->request->getVar('produtRating'));
            $productComment = filtreData($this->request->getVar('productComment'));
            if ($pid == "" || $produtRating == "" || $productComment == "") {
                $data = ['code' => (int)1, 'msg' => 'Please fill all fields ( * )', 'token' => csrf_hash()];
                return json_encode($data);
            } else {
                $vendor_id = (new ProductsModel())->getProductVendorById(my_decrypt($pid));
                (new ReviewModel())->insertreviews(getUserId(), [
                    'user_id' => getUserId(),
                    'product_id' => my_decrypt($pid),
                    'store_id' => $vendor_id,
                    'rates' => $produtRating,
                    'comments' => $productComment,
                ]);
                $data = ['code' => (int)2, 'msg' => 'Comment Successfully add', 'token' => csrf_hash()];
                return json_encode($data);
            }
        } else {
            return redirect()->to('/');
        }
    }
}

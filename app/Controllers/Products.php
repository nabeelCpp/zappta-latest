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
        $data = ZapptaTrait::productTrait($url, $pc, $sd_row, $pds);
        $data['image_path'] = 'products/';
        $data['pagetitle'] = 'Adidas';
        // dd($data);
        // for new design
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        return view('site/stores/single',$data);
    }

    public function index_old()
    {
        $request = request();
        $data['sticky_header'] = true;
        $url = filtreData($request->getUri()->getSegment(2));
        $pc = filtreData($request->getUri()->getSegment(4));
        $sd_row = filtreData($request->getVar('sd_row'));
        $pds = filtreData($request->getVar('pds'));
        $data = ZapptaTrait::productTrait($url, $pc, $sd_row, $pds);
        $data['image_path'] = 'products/';
        $data['pagetitle'] = 'Adidas';
        // dd($data);
        // for new design
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        return view('site/stores/~single',$data);
    }

    public function askquestion()
    {
        if ($this->request->isAJAX()) {
            $pid = filtreData($this->request->getVar('pid'));
            $askQuestionDetail = filtreData($this->request->getVar('askQuestionDetail'));
            if ( $pid == "" || $askQuestionDetail == "" ) {
                $data = [ 'code' => (int)1 , 'msg' => 'Please fill all fields ( * )' , 'token' => csrf_hash() ];
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
                $data = [ 'code' => (int)2 , 'msg' => 'Message Successfully Sent' , 'token' => csrf_hash() ];
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
            if ( $pid == "" || $produtRating == "" || $productComment == "" ) {
                $data = [ 'code' => (int)1 , 'msg' => 'Please fill all fields ( * )' , 'token' => csrf_hash() ];
                return json_encode($data);
            } else {
                $vendor_id = (new ProductsModel())->getProductVendorById(my_decrypt($pid));
                (new ReviewModel())->insertreviews(getUserId(),[
                                                'user_id' => getUserId(),
                                                'product_id' => my_decrypt($pid),
                                                'store_id' => $vendor_id,
                                                'rates' => $produtRating,
                                                'comments' => $productComment,
                                            ]);
                $data = [ 'code' => (int)2 , 'msg' => 'Comment Successfully add' , 'token' => csrf_hash() ];
                return json_encode($data);
            }
        } else {
            return redirect()->to('/');
        }
    }

}

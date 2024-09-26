<?php

namespace App\Controllers;

use App\Helpers\ZapptaHelper;
use App\Models\ProductsModel;
use App\Models\Setting;
use App\Models\NotificationModel;
use App\Models\ReviewModel;
use App\Models\CategoriesModel;
use App\Models\VendorModel;

class Products extends BaseController
{

    /*
    *   Get Single product
    *   return array
    */
    public function index()
    {
        $data['sticky_header'] = true;
        $ReviewModel = new ReviewModel;
        $complete_link = implode('/',$this->request->getUri()->getSegments()).'?'.http_build_query($_GET);
        if ( getUserId() > 0 ) {
            (new Setting())->insertDollor('ZAPPTA_PRODUCT_VIEW',$complete_link,1);
        }
        $url = filtreData($this->request->getUri()->getSegment(2));
        $pc = filtreData($this->request->getUri()->getSegment(4));
        $sd_row = filtreData($this->request->getVar('sd_row'));
        $pds = filtreData($this->request->getVar('pds'));
        $data['single'] = (new ProductsModel())->getProductByUrl($url,$pc,$sd_row,$pds);
        if ( !empty($data['single']) ) {
            $data['proids'] = (new CategoriesModel())->getRelatedCategories($data['single']['product_category'],$data['single']['id']);
            $data['related_products'] = (new ProductsModel())->getRelatedProduct($data['proids']);
            // $data['store'] = $this->db->table('vendor')->where('id', $data['single']['store_id'])->get()->first();
            $data['store'] = (new VendorModel())->findStoreById($data['single']['store_id']);

        }
        $data['pagetitle'] = 'Adidas';
        $data['overal_ratings'] = $ReviewModel->select('AVG(rates) as average_ratings, COUNT(id) as total_reviews')->where(['product_id' => $data['single']['product_id']])->groupBy('product_id')->get()->getRow();
        $data['reviews'] = $ReviewModel->where(['product_id' => $data['single']['product_id']])->limit(5)->orderBy('id', 'DESC')->get()->getResult();
        // dd($data);
        // for new design
        $data['assets_url'] = ZapptaHelper::loadAssetsUrl();
        $data['css'] = ZapptaHelper::loadModifiedThemeCss();
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        return view('site/stores/single',$data);
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

<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\UserTrait;
use App\Traits\CustomerTrait;
use CodeIgniter\API\ResponseTrait;
use App\Models\Address;
use App\Models\ProductsModel;
use App\Models\WishlistModel;

class Home extends BaseController
{
    use UserTrait, ResponseTrait, CustomerTrait;
    protected $addressModel, $orderModel;
    public function __construct() {
        $this->addressModel = new Address();
        $this->orderModel = new \App\Models\OrderModel();
    }

    /**
     * User login
     */
    public function index()
    {
        $customer = $this->request->customer ?? null;
        return $this->response->setJSON($customer);
    }
    
    /**
     * Get customer's wish list
     * @author M Nabeel Arshad
     * @method wishList
     * @return json
     */
    public function wishList() {
        $customer = CustomerTrait::getLoggedInApiCustomer();
        $data = CustomerTrait::wishlist();
        return response()->setJSON($data);
        $pager = service('pager');
        $pager->makeLinks($data['page'], $data['per_page'], $data['total_list'],'front_full'); // this will intialize current page, per page and total list
        $meta = ['prev_page' => $pager->getPreviousPageURI(),'next_page' => $pager->getNextPageURI()];
        $response = ZapptaHelper::response('Wishlist fetched successfully!', $data, 200, $meta);
        return response()->setJSON($response);
    }
    
    /**
     * Remove wishlist item
     * @author M Nabeel Arshad
     * @param string|integer $id
     * @return object
     */
    public function removeWishlist() {
        $post = request()->getVar();
        $rules = [
            'product_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
            // return $this->fail($this->validator->getErrors(), 400);
        }
        $checkWishlist = (new WishlistModel())->where('product_id', $post->product_id)->where('user_id', getUserId())->first();
        if(!$checkWishlist) {
            return response()->setJSON(ZapptaHelper::response('Product not found in wishlist!', [], 400));
        }
        $data = CustomerTrait::removeWishlist($checkWishlist['id']);
        $response = ZapptaHelper::response($data['msg']);
        return response()->setJSON($response);
    }

    /**
     * Add item to wishlist
     * @author M Nabeel Arshad
     * @param string|integer $id
     * @return object
     */
    public function addToWishlist() {
        $post = request()->getVar();
        $rules = [
            'product_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
            // return $this->fail($this->validator->getErrors(), 400);
        }

        $product_id = $post->product_id;
        $product = (new ProductsModel())->find($product_id);
        $store_id = $product['store_id'];
        $data = CustomerTrait::addItemToWishList($store_id, $product_id);
        $response = ZapptaHelper::response($data['msg']);
        return response()->setJSON($response);
    }
    
    /**
     * Get wallet details of customer
     * @return json
     * @author M Nabeel Arshad
     */
    public function wallet() {
        $data['earned_zappta'] = userTotalZappta();
        $data['spent_zappta'] = (float)(new \App\Models\CompainModel())->getZapptaSpent();
        $data['total_zappta'] = $data['earned_zappta'] - $data['spent_zappta'];
        $response = ZapptaHelper::response('Wallet fetched successfully!', $data, 200);
        return response()->setJSON($response);
    }

    /**
     * Get customer's addresses
     * @return json
     */
    public function addresses() {
        $param = null;
        $get = request()->getGet();
        if(isset($get['type']) && $get['type'] == 'billing') {
            $data =  $this->addressModel->getAllResultByUser(getUserId(),Address::ADDRESS_DISPLAY_LIMIT, $this->addressModel::ADDRESS_TYPE_BILLING);
        }else {
            $data =  $this->addressModel->getAllResultByUser(getUserId(),Address::ADDRESS_DISPLAY_LIMIT, $this->addressModel::ADDRESS_TYPE_SHIPPING);
        }
        $response = ZapptaHelper::response('Addresses fetched successfully!', $data, 200);
        return response()->setJSON($response);
    }

    /** 
     * Save delivery address
     * @return json
     */
    public function saveAddresse() {
        $request = $this->request;
        $rules = [
            'first_name' => 'required',
            'phone' => 'required',
            'stree_address' => 'required',
            'town_city' => 'required',
            'country' => 'required',
            // 'zip' => 'required',
            // 'type' => 'required'
        ];
        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
            // return $this->fail($this->validator->getErrors(), 400);
        }
        $data = (array)$request->getVar();
        $res = $this->orderModel->addOrderAddress($data, $data['type']??$this->addressModel::ADDRESS_TYPE_BILLING);
        $response = ZapptaHelper::response('Address successfully saved!', ['id' => $res], 200);
        return response()->setJSON($response);

    }

    /**
     * Update address
     * @param string|integer $id
     * @return json
     */
    public function editAddress($id) {
        $request = $this->request;
        $address = $this->addressModel->find($id);
        if(!$address) {
            $response = ZapptaHelper::response('Address not found!', [], 404);
            return response()->setJSON($response, 404);
        }
        $data = (array)$request->getVar();
        $this->orderModel->editOrderAddress($data, $id);
        $response = ZapptaHelper::response('Address successfully updated!', null, 200);
        return response()->setJSON($response);
    }

    /**
     * Remove address
     * @param string|integer $id
     * @return json
     */
    public function removeAddress($id) {
        (new Address())->deleteRecord($id);
        $response = ZapptaHelper::response('Address successfully deleted!', null, 200);
        return response()->setJSON($response);
    }

    /**
     * Add review
     * @return json
     * @author M Nabeel Arshad
     */
    public function giveReview() {
        $rules = [
            'order_id' => 'required',
            'rating' => 'required',
            'review' => 'required'
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response, 400);
        }
        $post = $this->request->getVar();
        $order_id = $post->order_id;
        $data = CustomerTrait::giveReviewTrait($order_id, $post);
        if($data['success']) {
            $response = ZapptaHelper::response($data['msg'], $data['review']);
            return response()->setJSON($response);
        }else {
            $response = ZapptaHelper::response($data['msg'], [], 400);
            return response()->setJSON($response, $response['code']);
        }
    }
}

<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\UserTrait;
use App\Traits\CustomerTrait;
use CodeIgniter\API\ResponseTrait;
use App\Models\Address;
class Home extends BaseController
{
    use UserTrait, ResponseTrait, CustomerTrait;

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
    public function removeWishlist($id) {
        $data = CustomerTrait::removeWishlist($id);
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
            'product_id' => 'required',
            'store_id' => 'required',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
            // return $this->fail($this->validator->getErrors(), 400);
        }
        $store_id = $post->store_id;
        $product_id = $post->product_id;
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
        $data = (new Address())->getAllResultByUser(getUserId(),20,2);
        $response = ZapptaHelper::response('Addresses fetched successfully!', $data, 200);
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
}

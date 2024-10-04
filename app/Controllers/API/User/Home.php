<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Traits\UserTrait;
use App\Traits\CustomerTrait;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

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
}

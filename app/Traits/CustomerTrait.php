<?php

namespace App\Traits;

use App\Helpers\ZapptaHelper;
use App\Models\OrderModel;
use App\Models\RegisterModel;
use App\Models\ReviewModel;
use App\Models\WishlistModel;
use CodeIgniter\HTTP\Response;

trait CustomerTrait {

    /**
     * Get API customer loggedin details
     * @return  object|null
     */
    public static function getLoggedInApiCustomer() : object|null {
        $customer = request()->customer ?? null;
        return $customer;
    }
    


    /**
     * Wish list of logged in user
     * @author M Nabeel Arshad
     * @return array
     */
    public static function wishlist() : array {
        $data['total_list'] = (new WishlistModel())->getUserTotalList();
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['per_page'] = $_GET['limit'] ?? PER_PAGE;
        $data['total_pages'] = ceil($data['total_list'] / $data['per_page']);
        $data['wishlist'] = (new WishlistModel())->getUserOrderList($data['page'], $data['per_page']);
        return $data;
    }

    /**
     * Remove item from wishlist
     * @param integer|string $id
     * @return array
     * @author M Nabeel Arshad
     */
    public static function removeWishlist($id) : array {
        if((new WishlistModel())->deleteR($id)) {
            return ['error' => 2, 'msg' => 'Product successfully removed from wishlist'];
        }else {
            return ['error' => 3, 'msg' => 'Error while removing Product from wishlist'];
        }
    }

    /**
     * Add item to wishlist
     * @param string|integer $store_id
     * @param string|integer $product_id
     * @return array
     * @author M Nabeel Arshad
     */
    public static function addItemToWishList($store_id, $product_id) : array {
        $wishlist = new WishlistModel();
        if ( $wishlist->checkWishList( $store_id,$product_id,getUserId() ) == false ) {
            $wid = $wishlist->add(['product_id' => $product_id,'store_id' => $store_id,'user_id' => getUserId() , 'created_at' => date('Y-m-d H:i:s')]);
            $data = ['error' => 2, 'msg' => 'Product successfully added in your wishlist', 'wishlist_id' => my_encrypt($wid)];
        } else {
            $data = ['error' => 3, 'msg' => 'Product already Added in your wishlist'];
        }
        $data['_cc'] = csrf_hash();
        return $data;
    }

    /**
     * Update customer password
     * @param object $request
     * @return array
     * @author M Nabeel Arshad
     */
    public static function updatePasswordTrait($current_pass, $new_pass, $confirm_pass) : array {
        $db = \Config\Database::connect();
        $user = $db->table('register')->where('id', getUserId())->get()->getResultArray();
        if(!password_verify($current_pass , $user[0]['password'] )){
            $data = ['success' => false, 'msg' => 'Invalid current password provided!'];
        }else if($new_pass !== $confirm_pass){
            $data = ['success' => false, 'msg' => 'New password and confirm password does not match!'];

        } else {
            (new RegisterModel())->add(['id' => getUserId() , 'password' => $confirm_pass]);
            $data = ['success' => true, 'msg' => 'Password successfully updated'];
        }
        $data['_cc'] = csrf_hash();
        return $data;
    }

    /**
     * Get referral Link
     * @author M Nabeel Arshad
     * @return string
     */
    public function getReferralLink() : string {
        return '?ref='. my_encrypt(getUserId());
    }

    /**
     * Save customer review trait
     * @param string|integer $order_id
     * @return array
     */
    public static function giveReviewTrait($order_id, $post) : array {
        $ReviewModel = new ReviewModel();
        $order = (new OrderModel())->getUserSingleOrder($order_id);
        $orderStatus = $order['order']['order_status'] ?? null;
        if(!$orderStatus || $orderStatus != 4) {
            return ['success' => false, 'msg' => 'You can not review current order!'];
        }
        $items = array_values(array_column($order['items'], null, 'item_id'));
        foreach ($items as $key => $item) {
            $review = [
                'order_id' => $order_id,
                'product_id' => $item['item_id'],
                'user_id' => getUserId(),
                'rates' => $post->rating,
                'comments' => $post->review,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $ReviewModel->insert($review);
        }
        return ['success' => true, 'msg' => 'Review submitted successfully!', 'review' => $ReviewModel->where('order_id', $order_id)->get()->getResult()];
    }

}
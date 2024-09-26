<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\RegisterModel;
use App\Models\WishlistModel;
use App\Models\ReviewModel;
use App\Models\OrderModel;

class Home extends BaseController
{
    
    public function index()
    {
        $wishList = new WishlistModel;
        $data['pagetitle'] = 'My Account';
        $data['user'] = (new RegisterModel())->getByIdResult(getUserId());
        $data['items'] = $wishList->getUserTotalList();
        return view('dashboard/index',$data);
    }

    public function saveReview($order_id)
    {
        $ReviewModel = new ReviewModel;
        $order_id = my_decrypt($order_id);
        $order = (new OrderModel())->getUserSingleOrder($order_id);
        $items = array_values(array_column($order['items'], null, 'item_id'));
        foreach ($items as $key => $item) {
            $review = [
                'order_id' => $order_id,
                'product_id' => $item['item_id'],
                'user_id' => getUserId(),
                'rates' => $this->request->getVar('rating'),
                'comments' => $this->request->getVar('review'),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $ReviewModel->insert($review);
        }
        return $this->response->setJson(['code' => 200, 'msg' => 'Review submitted successfully!', 'review' => $ReviewModel->where(['order_id' => $order_id, 'user_id' => getUserId()])->get()->getResult()]);
    }
    
}

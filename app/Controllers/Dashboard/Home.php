<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\RegisterModel;
use App\Models\WishlistModel;
use App\Models\ReviewModel;
use App\Models\OrderModel;
use App\Traits\CustomerTrait;

class Home extends BaseController
{
    use CustomerTrait;
    
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
        $order_id = my_decrypt($order_id);
        $post = $this->request->getVar();
        $data = CustomerTrait::giveReviewTrait($order_id, $post);
        return $this->response->setJson(['code' => 200, 'msg' => $data['msg'], 'review' => $data['review']]);
    }
    
}

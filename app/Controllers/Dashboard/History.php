<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ReviewModel;
use App\Models\UsersNotification;
use App\Traits\Dashboard\HistoryTrait;

class History extends BaseController
{
    use HistoryTrait;
    
    public function index()
    {
        $data = HistoryTrait::historyTrait();
        $data['pagetitle'] = 'History';
        return view('dashboard/history/index',$data);
    }
    
    public function view()
    {
        $db = \Config\Database::connect();
        $data['pagetitle'] = 'Order Detail';
        $data['order_id'] = my_decrypt($this->request->getVar('order_id'));
        $data['order'] = (new OrderModel())->getUserSingleOrder($data['order_id']);
        $data['address'] = (new OrderModel())->getUserAddressByOrder($data['order_id']);
        $data['coupons'] = $db->table('used_coupons')->where(['order_id' => $data['order_id']])->get()->getResult();
        return view('dashboard/history/view',$data);
    }

    public function status()
    {
        $url = get_current_url(false);
        (new UsersNotification())->markAsRead($url);
        $db = \Config\Database::connect();
        $ReviewModel = new ReviewModel;
        $order_id = my_decrypt($this->request->getVar('order_id'));
        $check_review = $ReviewModel->where(['order_id' => $order_id, 'user_id' => getUserId()])->get()->getResult();
        $data['pagetitle'] = 'Order Status';
        $data['order_id'] = $order_id;
        $data['order_timeline'] = (new OrderModel())->getOrderTimelimeList($data['order_id']);
        $data['review'] = $check_review;
        $order = $db->table('order')->where('id', $order_id)->get()->getResult();
        $possible_arrival = date('Y-m-d', strtotime($order[0]->created_at));
        $data['possible_arrival'] = date('Y-m-d', strtotime("+7 day", strtotime($possible_arrival)));
        return view('dashboard/history/status',$data);
    }

    public function invoice()
    {
        $data['pagetitle'] = 'Order Invoice';
        $data['order_id'] = my_decrypt($this->request->getVar('order_id'));
        $data['order'] = (new OrderModel())->getUserSingleOrder($data['order_id']);
        $data['address'] = (new OrderModel())->getUserAddressByOrder($data['order_id']);
        $html = view('dashboard/history/pdf',$data);
        $mpdf = new \Mpdf\Mpdf(['tempDir' => FCPATH.'/upload/pdf']);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('Order-'.$this->request->getVar('order_id').'.pdf','D');
    }

}

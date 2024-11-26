<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\UsersModel;

class Orders extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Dashboard';
        $data['pag'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['orders'] = (new OrderModel())->getOrderListByStores($data['pag']);
        $data['total_orders'] = (new OrderModel())->getTotalStoreOrders();
        if ( $data['total_orders'] > 20 ) {
            $data['pager'] = service('pager');
        }

        return view('vendors/orders/index',$data);
        // print '<pre>';
        // print_r($data['orders']);
        // print '</pre>';
    }    

    public function view()
    {
        $data['pagetitle'] = 'Dashboard';
        $data['order_id'] = my_decrypt($this->request->getUri()->getSegment(4));
        $data['order'] = (new OrderModel())->getStoreOrderBYId($data['order_id']);
        $data['address'] = (new OrderModel())->getUserAddressByOrder($data['order_id']);
        return view('vendors/orders/view',$data);
        // print '<pre>';
        // print_r($data['order']);
        // print '</pre>';
    }

    public function status()
    {
        if ($this->request->isAJAX()) {
            $ship_status = orderCartOnStatusCode(filtreData($this->request->getVar('ship')));
            $oid = my_decrypt(filtreData($this->request->getVar('oid')));
            $ids = my_decrypt(filtreData($this->request->getVar('ids')));
            (new OrderModel())->updateOrderItems($oid,$ids,$ship_status);
            (new OrderModel())->addOrderTimelime($oid,$ship_status,$ids);
            $data = [ 'code' => (int)1 , 'msg' => 'Please enter valid email.' , 'token' => csrf_hash() ];
            // Notification to user!
            $order = (new OrderModel())->getUserIdByOrder($oid)[0];
            $status = $this->request->getVar('ship');
            $link = base_url().'dashboard/history/status?order_id='.my_encrypt($order['id']).'&key='.csrf_hash();
            (new UsersModel())->saveNotification("Your Order <b style='color: #FB5000;'>{$order['order_serial']}</b> has been {$status}!", $order['user_id'], $link, 'order-'.strtolower($status));

            return json_encode($data);
        } else {
            return redirect()->to('/');
        }
    }
    public function GetLatestOrders(){
       
        $OrderModel = new OrderModel;
         $data =  $OrderModel->GetLatestOrders();
         return $this->response->setJSON($data);
       //  print_r($data);
         //  die();
    }


}
<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Models\OrderModel;
use App\Traits\Dashboard\HistoryTrait;
use CodeIgniter\HTTP\ResponseInterface;

class History extends BaseController
{
    use HistoryTrait;
    public function index()
    {
        try {
            //code...
            $order_id = request()->getGet('order_id') ?? null;
            if($order_id){
                $data = (new OrderModel())->getUserSingleOrder($order_id);
                unset($data['order']);
                if(!isset($data['items']) && empty($data['items'])) {
                    $response = ZapptaHelper::response('Order items not found', [], ResponseInterface::HTTP_NOT_FOUND);
                    return response()->setJSON($response)->setStatusCode($response['code']);
                }
                $response = ZapptaHelper::response('Order items fetched successfully', $data);
            }else{
                $data = HistoryTrait::historyTrait($order_id);
                $orders = [];
                foreach ($data['order_list']['order'] as $key => $order) {
                    $order['status'] = orderCartOnAdminStatus($order['status']);
                    $orders[] = $order;
                }
                unset($data['order_list'], $data['pager']);
                $data['orders'] = $orders;
                $response = ZapptaHelper::response('Orders fetched successfully', $data);
            }
            return response()->setJSON($response);
        } catch (\Throwable $th) {
            return response()->setJSON(['error' => "something went wrong! :".$th->getMessage()])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace App\Traits\Dashboard;

use App\Models\OrderModel;

trait HistoryTrait {
    /**
     * Get user order history
     * @return array
     */
    public static function historyTrait($orderid = null)
    {
        $data['total_order'] = (new OrderModel())->getUserTotalOrder();
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['order_list'] = (new OrderModel())->getUserOrderList($data['page'], $orderid);
        $data['pager'] = service('pager');
        return $data;
    }
}
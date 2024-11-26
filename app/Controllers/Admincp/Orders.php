<?php

namespace App\Controllers\Admincp;

use App\Models\OrderModel;

class Orders extends BaseController
{
    
    public function index()
    {
        $data['perm'] = perm('orders');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['sql'] = (new OrderModel())->getAllResult($data['page']);
        $data['total_result'] = (new OrderModel())->getTotalOrder();
        if ( $data['total_result'] > 20 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/orders/index',$data);
    }    

    public function view()
    {
        $data['perm'] = perm('orders');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->view == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $order_id = my_decrypt($this->request->getUri()->getSegment(4));
        $data['orders'] = (new OrderModel())->getAdminStoreOrderBYId($order_id);
        $data['address'] = (new OrderModel())->getUserAddressByOrder($order_id);
        return view('admin/orders/view',$data);
    }

    public function search()
    {
        $data['perm'] = perm('orders');
        $postForm = $this->request->getGet();
        $sql = (new OrderModel())->adminsearch(filtreData($postForm['word']));
        $html = '';
        if(is_array($sql)){
            foreach($sql as $row){
                $html .= '<tr>
                            <td><input type="checkbox" name=""></td>
                            <td>'.$row['order_serial'].'</td>';
                $html .=    '<td>'.$row['fname'].'</td>';
                $html .=    '<td>'.$row['phone'].'</td>';
                $html .=    '<td>'.$row['total_amount'].'</td>';
                $html .=    '<td>'.$row['payment_method'].'</td>';
                $html .=    '<td>'.$row['total_orders'].'</td>';
                $html .=    '<td>'.$row['total_stores'].'</td>';
                $html .=    '<td>';
                if ( $data['perm']->view == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/orders/view/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">View</a>';
                }      
                $html .= '</td>
                        </tr>';  
            }
        } else {
            $sql = (new OrderModel())->getAllResult(1);
            if(is_array($sql)){
                foreach($sql as $row){
                $html .= '<tr>
                            <td><input type="checkbox" name=""></td>
                            <td>'.$row['order_serial'].'</td>';
                $html .=    '<td>'.$row['fname'].'</td>';
                $html .=    '<td>'.$row['phone'].'</td>';
                $html .=    '<td>'.$row['total_amount'].'</td>';
                $html .=    '<td>'.$row['payment_method'].'</td>';
                $html .=    '<td>'.$row['total_orders'].'</td>';
                $html .=    '<td>'.$row['total_stores'].'</td>';
                $html .=    '<td>';
                if ( $data['perm']->view == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/orders/view/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">View</a>';
                }      
                $html .= '</td>
                        </tr>';  
                }
            }
        }
        print json_encode( [ 'token' => csrf_hash(), 'html' => $html ]);
    }


}

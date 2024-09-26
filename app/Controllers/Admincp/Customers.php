<?php

namespace App\Controllers\Admincp;

use App\Models\RegisterModel;
use App\Models\VendorModel;

class Customers extends BaseController
{
    
    public function index()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['vendors'] = (new RegisterModel())->getAdminAllResult($data['page']);
        $data['total_result'] = (new RegisterModel())->countAdminAllResult();
        if ( $data['total_result'] > 30 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/customers/index',$data);
    }


    public function activate()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $store_id = my_decrypt($this->request->getUri()->getSegment(4));
        $datastore['users'] = (new RegisterModel())->find($store_id);
        (new RegisterModel())->addd(['id' => $store_id,'status' => 2]);
        (new \App\Models\EmailModel())->sendMail($datastore['users']['email'],'Activation Confirmation','vendorconfirm',$datastore);
        $this->session->setFlashdata('success', 'Account Successfully Activate');
        return redirect()->to('/admincp/customers');
    } 

    public function blocked()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $store_id = my_decrypt($this->request->getUri()->getSegment(4));
        $datastore['users'] = (new RegisterModel())->find($store_id);
        (new RegisterModel())->add(['id' => $store_id,'status' => 3]);
        (new \App\Models\EmailModel())->sendMail($datastore['users']['email'],'Account Blocked','vendorblocked',$datastore);
        $this->session->setFlashdata('success', 'Account Successfully Blocked');
        return redirect()->to('/admincp/customers');
    }

    public function delete()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->deletep == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $store_id = my_decrypt($this->request->getUri()->getSegment(4));
        (new \App\Models\ProductsModel())->deleteVendorProduct($store_id);
        (new RegisterModel())->add(['id' => $store_id,'status' => 3,'deleteStatus' => 1]);
        $this->session->setFlashdata('success', 'Account Successfully deleted');
        return redirect()->to('/admincp/customers');
    } 

    public function search()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $postForm = $this->request->getGet();
        $sql = (new RegisterModel())->searchvendor(filtreData($postForm['word']));
        $html = '';
        if(is_array($sql)){
            foreach($sql as $row){
                $html .= '<tr>
                            <td><input type="checkbox" name=""></td>
                            <td>'.$row['id'].'</td>';
                    if( ! empty( $row['store_logo'] ) ) {
                        $ext_name = explode('.',$row['store_logo']);
                        $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100" class="border rounded" alt=""></td>';
                    } else {
                        $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'/images/product/img-not-found/jpg/100" alt=""/></td>';
                    }
                $html .=    '<td>'.$row['store_name'].'</td>';
                $html .=    '<td>'.$row['email'].'</td>';
                $html .=    '<td>'.$row['store_link'].'</td>';
                $html .=    '<td>'.$row['total_products'].'</td>';
                $html .=    '<td>'.vendorStatus($row['status']).'</td>';
                $html .=    '<td>';
                if ( $data['perm']->editp == 1 ) {
                    if ( $row['status'] == 1 || $row['status'] == 3 ) {
                    $html .= '<a href="'.base_url().'/admincp/customers/activate/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-warning mr-1">Activate</a>';
                    } else {
                    $html .= '<a href="'.base_url().'/admincp/customers/blocked/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-warning mr-1">Block</a>';
                    }
                    $html .= '<a href="'.base_url().'/admincp/customers/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">Edit</a>';
                }     
                if ( $data['perm']->deletep == 1 ) {
                    $html .= '<a href="'.base_url().'/admincp/customers/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                }      
                $html .= '</td>
                        </tr>'; 
            }
        } else {
            $sql = (new VendorModel())->getAdminAllResult(1);
            if(is_array($sql)){
                foreach($sql as $row){
                    $html .= '<tr>
                                <td><input type="checkbox" name=""></td>
                                <td>'.$row['id'].'</td>';
                        if( ! empty( $row['store_logo'] ) ) {
                            $ext_name = explode('.',$row['store_logo']);
                            $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100" class="border rounded" alt=""></td>';
                        } else {
                            $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'/images/product/img-not-found/jpg/100" alt=""/></td>';
                        }
                    $html .=    '<td>'.$row['store_name'].'</td>';
                    $html .=    '<td>'.$row['email'].'</td>';
                    $html .=    '<td>'.$row['store_link'].'</td>';
                    $html .=    '<td>'.$row['total_products'].'</td>';
                    $html .=    '<td>'.vendorStatus($row['status']).'</td>';
                    $html .=    '<td>';
                    if ( $data['perm']->editp == 1 ) {
                        if ( $row['status'] == 1 || $row['status'] == 3 ) {
                        $html .= '<a href="'.base_url().'/admincp/customers/activate/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-warning mr-1">Activate</a>';
                        } else {
                        $html .= '<a href="'.base_url().'/admincp/customers/blocked/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-warning mr-1">Block</a>';
                        }
                        $html .= '<a href="'.base_url().'/admincp/customers/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">Edit</a>';
                    }     
                    if ( $data['perm']->deletep == 1 ) {
                        $html .= '<a href="'.base_url().'/admincp/customers/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                    }      
                    $html .= '</td>
                            </tr>'; 
                }
            }
        }
        print json_encode( [ 'token' => csrf_hash(), 'html' => $html ]);
    } 




    
}

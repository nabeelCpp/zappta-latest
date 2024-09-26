<?php

namespace App\Controllers\Admincp;

use App\Models\VendorModel;

class Vendors extends BaseController
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
        $data['vendors'] = (new VendorModel())->getAdminAllResult($data['page']);
        $data['total_result'] = (new VendorModel())->adminTotalVendors();
        if ( $data['total_result'] > 20 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/vendors/index',$data);
    }

    public function add()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->addp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        return view('admin/vendors/add');
    } 

    public function insert()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->addp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $name = filtreData($this->request->getPost('store_name'));
        $email = filtreData($this->request->getPost('email'));
        $password = filtreData($this->request->getPost('password'));
        $store_link = filtreData($this->request->getPost('store_link'));
        $store_order_email = filtreData($this->request->getPost('store_order_email'));
        $paypal_email = filtreData($this->request->getPost('paypal_email'));
        $earn_zappta = filtreData($this->request->getPost('earn_zappta'));
        $per_dollar = filtreData($this->request->getPost('per_dollar'));
        $status = filtreData($this->request->getPost('status'));
        if ( $name == "" || $email == "" || $password == "" ) {
            $this->session->setFlashdata('error', 'Please fill required fields( * )');
            return redirect()->to('/admincp/vendors/add');
        }

        if ( !valid_email($email) || (new VendorModel())->findByEmail($email) > 0 ) {
            $this->session->setFlashdata('error', 'Please enter valid email');
            return redirect()->to('/admincp/vendors/add');
        }

        $v_id = (new VendorModel())->add(['store_name' => $name,'store_slug' => (new VendorModel())->addStoreSlug(url_title($name, '-', true)),'email' => $email,'password' => $password,'store_link' => $store_link,'store_order_email' => $store_order_email,'paypal_email' => $paypal_email,'status' => $status, 'per_dollar'=>$per_dollar, 'earn_zappta'=>$earn_zappta]);
        if ( $_FILES['store_logo']['size'] != 0 ) {
            $file = $this->request->getFile('store_logo');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => $v_id, 'store_logo' => $newName ];
            (new VendorModel())->add($post);
        }
        $this->session->setFlashdata('success', 'Account Successfully Created');
        return redirect()->to('/admincp/vendors');
    } 

    public function edit()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $store_id = my_decrypt($this->request->getUri()->getSegment(4));
        $data['users'] = (new VendorModel())->find($store_id);
        return view('admin/vendors/edit',$data);
    } 

    public function update()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $id = filtreData($this->request->getPost('_id'));
        $name = filtreData($this->request->getPost('store_name'));
        // $email = filtreData($this->request->getPost('email'));
        $password = filtreData($this->request->getPost('password'));
        $store_link = filtreData($this->request->getPost('store_link'));
        $store_order_email = filtreData($this->request->getPost('store_order_email'));
        $paypal_email = filtreData($this->request->getPost('paypal_email'));
        $earn_zappta = filtreData($this->request->getPost('earn_zappta'));
        $per_dollar = filtreData($this->request->getPost('per_dollar'));
        $status = filtreData($this->request->getPost('status'));
        if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill required fields( * )');
            return redirect()->to('/admincp/vendors/edit/'.$id);
        }
        (new VendorModel())->add(['id' => my_decrypt($id),'store_name' => $name,'store_link' => $store_link,'store_order_email' => $store_order_email,'paypal_email' => $paypal_email,'status' => $status, 'per_dollar'=>$per_dollar, 'earn_zappta'=>$earn_zappta]);
        if ( !empty($password) ) {
            (new VendorModel())->add(['id' => my_decrypt($id),'password' => $password]);
        }
        if ( $_FILES['store_logo']['size'] != 0 ) {
            $file = $this->request->getFile('store_logo');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => my_decrypt($id), 'store_logo' => $newName ];
            (new VendorModel())->add($post);
        }
        $this->session->setFlashdata('success', 'Account Successfully Update');
        return redirect()->to('/admincp/vendors');
    } 

    public function activate()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $store_id = my_decrypt($this->request->getUri()->getSegment(4));
        $datastore['users'] = (new VendorModel())->find($store_id);
        (new VendorModel())->add(['id' => $store_id,'status' => 2]);
        (new \App\Models\EmailModel())->sendMail($datastore['users']['email'],'Activation Confirmation','vendorconfirm',$datastore);
        $this->session->setFlashdata('success', 'Account Successfully Activate');
        return redirect()->to('/admincp/vendors');
    } 

    public function blocked()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $store_id = my_decrypt($this->request->getUri()->getSegment(4));
        $datastore['users'] = (new VendorModel())->find($store_id);
        (new VendorModel())->add(['id' => $store_id,'status' => 3]);
        (new \App\Models\EmailModel())->sendMail($datastore['users']['email'],'Account Blocked','vendorblocked',$datastore);
        $this->session->setFlashdata('success', 'Account Successfully Blocked');
        return redirect()->to('/admincp/vendors');
    }

    public function delete()
    {
        $data['perm'] = perm('stores');
        if ( $data['perm']->deletep == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $store_id = my_decrypt($this->request->getUri()->getSegment(4));
        (new \App\Models\ProductsModel())->deleteVendorProduct($store_id);
        (new VendorModel())->add(['id' => $store_id,'status' => 3,'deleteStatus' => 1]);
        $this->session->setFlashdata('success', 'Account Successfully deleted');
        return redirect()->to('/admincp/vendors');
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
        $sql = (new VendorModel())->searchvendor(filtreData($postForm['word']));
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
                    $html .= '<a href="'.base_url().'/admincp/vendors/activate/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-warning mr-1">Activate</a>';
                    } else {
                    $html .= '<a href="'.base_url().'/admincp/vendors/blocked/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-warning mr-1">Block</a>';
                    }
                    $html .= '<a href="'.base_url().'/admincp/vendors/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">Edit</a>';
                }     
                if ( $data['perm']->deletep == 1 ) {
                    $html .= '<a href="'.base_url().'/admincp/vendors/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
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
                        $html .= '<a href="'.base_url().'/admincp/vendors/activate/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-warning mr-1">Activate</a>';
                        } else {
                        $html .= '<a href="'.base_url().'/admincp/vendors/blocked/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-warning mr-1">Block</a>';
                        }
                        $html .= '<a href="'.base_url().'/admincp/vendors/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">Edit</a>';
                    }     
                    if ( $data['perm']->deletep == 1 ) {
                        $html .= '<a href="'.base_url().'/admincp/vendors/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                    }      
                    $html .= '</td>
                            </tr>'; 
                }
            }
        }
        print json_encode( [ 'token' => csrf_hash(), 'html' => $html ]);
    } 




    
}

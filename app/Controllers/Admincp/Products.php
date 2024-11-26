<?php

namespace App\Controllers\Admincp;

use App\Models\ProductsModel;

class Products extends BaseController
{
    
    public function index()
    {
        $data['perm'] = perm('products');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['sql'] = (new ProductsModel())->getAdminAllResult($data['page']);
        $data['total_result'] = (new ProductsModel())->getTotalAdminProduct();
        if ( $data['total_result'] > 20 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/products/index',$data);
    }    

    public function view()
    {
        $data['perm'] = perm('products');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->view == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $pid = my_decrypt($this->request->getUri()->getSegment(4));
        $data['default'] = (new ProductsModel())->getAdminProductById($pid);
        return view('admin/products/view',$data);
    }

    public function delete()
    {
        $data['perm'] = perm('products');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $pid = $this->request->getUri()->getSegment(4);
        (new ProductsModel())->add( ['id' => filtreData(my_decrypt($pid)) ,'status' => 2, 'deleteStatus' => 1] );
        $this->session->setFlashdata('success','Product successfully deleted');
        return redirect()->to('/admincp/products');
    }

    public function search()
    {
        $data['perm'] = perm('orders');
        $postForm = $this->request->getGet();
        $sql = (new ProductsModel())->adminsearch(filtreData($postForm['word']));
        $html = '';
        if(is_array($sql)){
            foreach($sql as $row){
                $html .= '<tr>
                            <td><input type="checkbox" name=""></td>
                            <td>'.$row['id'].'</td>';
                    if( ! empty( $row['cover'] ) ) {
                        $ext_name = explode('.',$row['cover']);
                        $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/product/'.$ext_name[0].'/'.$ext_name[1].'/100" class="border rounded" alt=""></td>';
                    } else {
                        $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/product/img-not-found/jpg/100" alt=""/></td>';
                    }
                $html .=    '<td>'.short($row['name'],50).'</td>';
                $html .=    '<td>'.$row['store_name'].'</td>';
                $html .=    '<td>'.$row['bname'].'</td>';
                $html .=    '<td>'.$row['reference'].'</td>';
                $html .=    '<td>'.productConditionStatus($row['conditions']).'</td>';
                $html .=    '<td>'.$row['total_items'].'</td>';
                $html .=    '<td>';
                if ( $data['perm']->view == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/products/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">View</a>';
                }     
                if ( $data['perm']->deletep == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/products/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                }      
                $html .= '</td>
                        </tr>';  
            }
        } else {
            $sql = (new ProductsModel())->getAdminAllResult(1);
            if(is_array($sql)){
                foreach($sql as $row){
                    $html .= '<tr>
                                <td><input type="checkbox" name=""></td>
                                <td>'.$row['id'].'</td>';
                        if( ! empty( $row['cover'] ) ) {
                            $ext_name = explode('.',$row['cover']);
                            $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/product/'.$ext_name[0].'/'.$ext_name[1].'/100" class="border rounded" alt=""></td>';
                        } else {
                            $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/product/img-not-found/jpg/100" alt=""/></td>';
                        }
                    $html .=    '<td>'.short($row['name'],50).'</td>';
                    $html .=    '<td>'.$row['store_name'].'</td>';
                    $html .=    '<td>'.$row['bname'].'</td>';
                    $html .=    '<td>'.$row['reference'].'</td>';
                    $html .=    '<td>'.productConditionStatus($row['conditions']).'</td>';
                    $html .=    '<td>'.$row['total_items'].'</td>';
                    $html .=    '<td>';
                    if ( $data['perm']->view == 1 ) {
                        $html .= '<a href="'.base_url().'admincp/products/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">View</a>';
                    }     
                    if ( $data['perm']->deletep == 1 ) {
                        $html .= '<a href="'.base_url().'admincp/products/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                    }      
                    $html .= '</td>
                            </tr>';  
                }
            }
        }
        print json_encode( [ 'token' => csrf_hash(), 'html' => $html ]);
    }


}

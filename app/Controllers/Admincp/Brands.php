<?php

namespace App\Controllers\Admincp;

use App\Models\CategoriesModel;
use App\Models\BrandModel;

class Brands extends BaseController
{
    
    public function index()
    {
        $data['perm'] = perm('brands');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }

        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['sql'] = (new BrandModel())->getTotalBrandAllResult($data['page']);
        $data['total_result'] = (new BrandModel())->getAdminTotalResult();
        if ( $data['total_result'] > 20 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/brands/index',$data);
    }


    public function add()
    {
        $data['perm'] = perm('brands');
        if ( $data['perm']->addp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $data['allcat'] = (new CategoriesModel())->getAllCategoryTree();
        return view('admin/brands/add',$data);
    }

    public function insert()
    {
        $data['perm'] = perm('brands');
        if ( $data['perm']->addp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $postForm = $this->request->getPost();

        $name = $postForm['name'];
        $description = $postForm['description'];
        $category_id = $postForm['category_id'];
        $status = $postForm['status'];

        if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to('/admincp/brands/add'); 
        }
        
        $post = [
                    // 'category_id' => filtreData($category_id),
                    'name' => filtreData($name),
                    'urls' => filtreData($name),
                    'description' => filtreData($description),
                    'status' => filtreData($status)
                ];

        $parent_ids = (new BrandModel())->add($post);
        (new BrandModel())->addBrandCategories(filtreData($category_id),filtreData($parent_ids));
        if ( $_FILES['logo']['size'] != 0 ) {
            $file = $this->request->getFile('logo');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => $parent_ids, 'logo' => $newName ];
            (new BrandModel())->add($post);
        }

        if ( $_FILES['brand_banner']['size'] != 0 ) {
            $file = $this->request->getFile('brand_banner');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => $parent_ids, 'brand_banner' => $newName ];
            (new BrandModel())->add($post);
        }

        $this->session->setFlashdata('success', 'Brand Successfully added in list');
        return redirect()->to('/admincp/brands');
    }

    public function edit()
    {
        $data['perm'] = perm('brands');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $ids = $this->request->getUri()->getSegment(4);
        $data['sql'] = (new BrandModel())->getSingleBrand(my_decrypt($ids));
        $data['allcat'] = (new CategoriesModel())->getAllCategoryTree();
        return view('admin/brands/edit',$data);
    }

    public function update()
    {
        $data['perm'] = perm('brands');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $postForm = $this->request->getPost();

        $id = my_decrypt($postForm['id']);
        $name = $postForm['name'];
        $description = $postForm['description'];
        $category_id = $postForm['category_id'];
        $status = $postForm['status'];

        if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to('/admincp/brands/edit/'.$postForm['id']); 
        }
        
        $post = [
                    'id' => filtreData($id),
                    // 'category_id' => filtreData($category_id),
                    'name' => filtreData($name),
                    'description' => filtreData($description),
                    'status' => filtreData($status)
                ];
        (new BrandModel())->add($post);
        (new BrandModel())->updateBrandCategories(filtreData($category_id),filtreData($id));
        if ( $_FILES['logo']['size'] != 0 ) {
            $file = $this->request->getFile('logo');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            (new BrandModel())->add([ 'id' => filtreData($id), 'logo' => $newName ]);
        }

        if ( $_FILES['brand_banner']['size'] != 0 ) {
            $file = $this->request->getFile('brand_banner');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            (new BrandModel())->add([ 'id' => filtreData($id), 'brand_banner' => $newName ]);
        }

        $this->session->setFlashdata('success', 'Brand Successfully updated in list');
        return redirect()->to('/admincp/brands');
    }


    public function delete()
    {
        $data['perm'] = perm('brands');
        if ( $data['perm']->deletep == 0 ) {
            return redirect()->to('/admincp/'); 
        }

        $ids = $this->request->getUri()->getSegment(4);
        (new BrandModel())->add([ 'id' => filtreData(my_decrypt($ids)), 'deleteStatus' => 1 ]);
        $this->session->setFlashdata('success', 'Brand Successfully deleted');
        return redirect()->to('admincp/brands');
    }

    public function search()
    {
        $data['perm'] = perm('brands');
        $postForm = $this->request->getGet();
        $sql = (new BrandModel())->searchBrands(filtreData($postForm['word']));
        $html = '';
        if(is_array($sql)){
            foreach($sql as $row){
                $html .= '<tr>
                            <td><input type="checkbox" name=""></td>
                            <td>'.$row['id'].'</td>';
                    if( ! empty( $row['logo'] ) ) {
                        $ext_name = explode('.',$row['logo']);
                        $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/media/'.$ext_name[0].'/'.$ext_name[1].'/100" class="border rounded" alt=""></td>';
                    } else {
                        $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/product/img-not-found/jpg/100" alt=""/></td>';
                    }
               $html .=    '<td>'.$row['name'].'</td>';
               $html .=    '<td>'.$row['total_products'].'</td>';
               $html .=    '<td>'.$row['total_stores'].'</td>';
                $html .=    '<td>';
                if ( $data['perm']->editp == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/brands/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">Edit</a>';
                }     
                if ( $data['perm']->deletep == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/brands/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                }      
                $html .= '</td>
                        </tr>';  
            }
        } else {
            $sql = (new BrandModel())->getAllResult(1);
            if(is_array($sql)){
                foreach($sql as $row){
                    $html .= '<tr>
                                <td><input type="checkbox" name=""></td>
                                <td>'.$row['id'].'</td>';
                        if( ! empty( $row['logo'] ) ) {
                            $ext_name = explode('.',$row['logo']);
                            $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/media/'.$ext_name[0].'/'.$ext_name[1].'/100" class="border rounded" alt=""></td>';
                        } else {
                            $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/product/img-not-found/jpg/100" alt=""/></td>';
                        }
               $html .=    '<td>'.$row['name'].'</td>';
               $html .=    '<td>'.$row['total_products'].'</td>';
               $html .=    '<td>'.$row['total_stores'].'</td>';
                    $html .=    '<td>';
                    if ( $data['perm']->editp == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/brands/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">Edit</a>';
                    }     
                    if ( $data['perm']->deletep == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/brands/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                    }      
                    $html .= '</td>
                            </tr>';  
                }
            }
        }
        print json_encode( [ 'token' => csrf_hash(), 'html' => $html ]);
    }

}

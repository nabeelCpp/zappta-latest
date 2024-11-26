<?php

namespace App\Controllers\Admincp;

use App\Models\CategoriesModel;

class Categories extends BaseController
{
    
    public function index()
    {
        $data['perm'] = perm('categories');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }

        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['sql'] = (new CategoriesModel())->getAllResult($data['page']);
        $data['total_result'] = (new CategoriesModel())->getAdminTotalResult();
        if ( $data['total_result'] > 20 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/categories/index',$data);
    }


    public function add()
    {
        $data['perm'] = perm('categories');
        if ( $data['perm']->addp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        // $data['category'] = new CategoriesModel();
        // $data['parent'] = $data['category']->getcat(0,'-');
        $data['allcat'] = (new CategoriesModel())->getAllCategoryTree();
        return view('admin/categories/add',$data);
    }

    public function insert()
    {
        $data['perm'] = perm('categories');
        if ( $data['perm']->addp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        cache()->delete('allcategories');
        cache()->delete('home_category');
        $postForm = $this->request->getPost();

        $name = $postForm['cat_name'];
        $description = $postForm['description'];
        $metakey = $postForm['metakey'];

        $parent_id = $postForm['parent_id'];
        $type = $postForm['type'];
        $status = $postForm['status'];
        $brands = isset($postForm['brands']) ? filter_var_array($postForm['brands'],FILTER_SANITIZE_STRING) : [];
        $attributes = isset($postForm['brands']) ? filter_var_array($postForm['attributes'],FILTER_SANITIZE_STRING) : [];

        if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to('/admincp/categories/add'); 
        }
        
        $post = [
                    'cat_name' => filtreData($name),
                    'cat_url' => filtreData($name),
                    'description' => filtreData($description),
                    'metakey' => filtreData($metakey),
                    'parent_id' => filtreData(my_decrypt($parent_id)),
                    'status' => filtreData($status),
                    'type' => $type,
                    'brands' => serialize($brands),
                    'attributes' => serialize($attributes),
                ];

        $parent_ids = (new CategoriesModel())->add($post);
        
        if ( $_FILES['cat_icon']['size'] != 0 ) {
            $file = $this->request->getFile('cat_icon');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => $parent_ids, 'cat_icon' => $newName ];
            (new CategoriesModel())->add($post);
        }

        if ( $_FILES['catimg']['size'] != 0 ) {
            $file = $this->request->getFile('catimg');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => $parent_ids, 'cat_img' => $newName ];
            (new CategoriesModel())->add($post);
        }

        if ( is_array($attributes) && count($attributes) > 0 ) {
            foreach( $attributes as $attr ) {
                (new \App\Models\AttributeModel())->addAttributeCategories($parent_ids,$attr);
            }
        }

        if ( is_array($brands) && count($brands) > 0 ) {
            foreach( $brands as $br ) {
                (new \App\Models\BrandModel())->addBrandCategories($parent_ids,$br);
            }
        }

        cache()->save('allcategories', (new CategoriesModel())->getAllCategoryTree());
        $this->session->setFlashdata('success', 'Category Successfully added in list');
        return redirect()->to('/admincp/categories');
    }

    public function edit()
    {
        $data['perm'] = perm('categories');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $ids = $this->request->getUri()->getSegment(4);
        // $data['category'] = new CategoriesModel();
        $data['sql'] = (new CategoriesModel())->find(my_decrypt($ids));
        // $data['parent'] = $data['category']->getcat(0,'-');
        $data['allcat'] = (new CategoriesModel())->getAllCategoryTree();
        return view('admin/categories/edit',$data);
    }

    public function update()
    {
        $data['perm'] = perm('categories');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        cache()->delete('allcategories');
        cache()->delete('home_category');

        $postForm = $this->request->getPost();

        $id = my_decrypt($postForm['id']);
        $name = $postForm['cat_name'];
        $description = $postForm['description'];
        $metakey = $postForm['metakey'];

        $parent_id = $postForm['parent_id'];
        $type = $postForm['type'];
        $status = $postForm['status'];
        $brands = isset($postForm['brands']) ? filter_var_array($postForm['brands'],FILTER_SANITIZE_STRING) : [];
        $attributes = isset($postForm['brands']) ? filter_var_array($postForm['attributes'],FILTER_SANITIZE_STRING) : [];

        if ( $name == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to('/admincp/categories/edit/'.$postForm['id']); 
        }
        
        $post = [
                    'id' => filtreData($id),
                    'cat_name' => filtreData($name),
                    'description' => filtreData($description),
                    'metakey' => filtreData($metakey),
                    'parent_id' => filtreData(my_decrypt($parent_id)),
                    'status' => filtreData($status),
                    'type' => $type,
                    'brands' => serialize($brands),
                    'attributes' => serialize($attributes),
                ];
        (new CategoriesModel())->add($post);
        // $parent_ids = 
        
        if ( $_FILES['cat_icon']['size'] != 0 ) {
            $file = $this->request->getFile('cat_icon');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => $id, 'cat_icon' => $newName ];
            (new CategoriesModel())->add($post);
        }

        if ( $_FILES['catimg']['size'] != 0 ) {
            $file = $this->request->getFile('catimg');
            $newName = $file->getRandomName();
            $dir = ROOTPATH . 'public/upload/media';
            $file->move($dir,$newName);
            $path = $dir.'/'.$newName;
            imageThumb($path,$dir,$newName);
            $post = [ 'id' => $id, 'cat_img' => $newName ];
            (new CategoriesModel())->add($post);
        }

        if ( is_array($attributes) && count($attributes) > 0 ) {
            (new \App\Models\AttributeModel())->deleteAttributeByCategories(filtreData($id));
            foreach( $attributes as $attr ) {
                (new \App\Models\AttributeModel())->addAttributeCategories(filtreData($id),$attr);
            }
        }

        if ( is_array($brands) && count($brands) > 0 ) {
            (new \App\Models\BrandModel())->deleteBrandByCategories(filtreData($id));
            foreach( $brands as $br ) {
                (new \App\Models\BrandModel())->addBrandCategories(filtreData($id),$br);
            }
        }

        cache()->save('allcategories', (new CategoriesModel())->getAllCategoryTree());
        $this->session->setFlashdata('success', 'Category Successfully updated in list');
        return redirect()->to('/admincp/categories');
    }


    public function delete()
    {
        $data['perm'] = perm('categories');
        if ( $data['perm']->deletep == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $ids = $this->request->getUri()->getSegment(4);
        (new CategoriesModel())->deleteR(my_decrypt($ids));
        cache()->delete('home_category');
        $this->session->setFlashdata('success', 'Category Successfully deleted');
        return redirect()->to('admincp/categories');
    }

    public function search()
    {
        $data['perm'] = perm('categories');
        $postForm = $this->request->getGet();
        $sql = (new CategoriesModel())->searchCategories(filtreData($postForm['word']));
        $html = '';
        if(is_array($sql)){
            foreach($sql as $row){
                $html .= '<tr>
                            <td><input type="checkbox" name=""></td>
                            <td>'.$row['id'].'</td>';
                    if( ! empty( $row['cat_icon'] ) ) {
                        $ext_name = explode('.',$row['cat_icon']);
                        $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/media/'.$ext_name[0].'/'.$ext_name[1].'/100" class="border rounded" alt=""></td>';
                    } else {
                        $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/product/img-not-found/jpg/100" alt=""/></td>';
                    }
               $html .=    '<td>'.$row['cat_name'].'</td>';
               $html .=    '<td>'.$row['total_items'].'</td>';
               $html .=    '<td>'.$row['total_stores'].'</td>';
                $html .=    '<td>';
                if ( $data['perm']->editp == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/categories/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">Edit</a>';
                }     
                if ( $data['perm']->deletep == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/categories/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                }      
                $html .= '</td>
                        </tr>';  
            }
        } else {
            $sql = (new CategoriesModel())->getAllResult(1);
            if(is_array($sql)){
                foreach($sql as $row){
                    $html .= '<tr>
                                <td><input type="checkbox" name=""></td>
                                <td>'.$row['id'].'</td>';
                        if( ! empty( $row['cat_icon'] ) ) {
                            $ext_name = explode('.',$row['cat_icon']);
                            $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/media/'.$ext_name[0].'/'.$ext_name[1].'/100" class="border rounded" alt=""></td>';
                        } else {
                            $html .=    '<td class="lo-stats__image"><img class="border rounded" src="'.base_url().'images/product/img-not-found/jpg/100" alt=""/></td>';
                        }
               $html .=    '<td>'.$row['cat_name'].'</td>';
               $html .=    '<td>'.$row['total_items'].'</td>';
               $html .=    '<td>'.$row['total_stores'].'</td>';
                    $html .=    '<td>';
                    if ( $data['perm']->editp == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/categories/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">Edit</a>';
                    }     
                    if ( $data['perm']->deletep == 1 ) {
                    $html .= '<a href="'.base_url().'admincp/categories/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                    }      
                    $html .= '</td>
                            </tr>';  
                }
            }
        }
        print json_encode( [ 'token' => csrf_hash(), 'html' => $html ]);
    }

    public function getajaxbrand()
    {
        $result = [];
        $postForm = $this->request->getVar('search');
        $brand = (new \App\Models\BrandModel())->searchBrands(filtreData($postForm));
        if ( is_array($brand) && count($brand) > 0 ) {
            foreach( $brand as $ids ) {
                $result[] = [ 'id' => $ids['id'] , 'text' => $ids['name']  ];
            }
        }
        print json_encode( $result );
        exit;
    }

    public function getajaxattributes()
    {
        $result = [];
        $postForm = $this->request->getVar('search');
        $brand = (new \App\Models\AttributeModel())->searchAttribute(filtreData($postForm));
        if ( is_array($brand) && count($brand) > 0 ) {
            foreach( $brand as $ids ) {
                $result[] = [ 'id' => $ids['id'] , 'text' => $ids['name_en']  ];
            }
        }
        print json_encode( $result );
        exit;
    }


}

<?php

namespace App\Controllers\Admincp;

use App\Models\AttributeModel;
use App\Models\AttributeValueModel;
use App\Models\CategoriesModel;

class Attributes extends BaseController
{
    
    public function index()
    {
        $data['perm'] = perm('attributes');
        if ( isset($data['perm']) && $data['perm']->allview == 0 ) {
            if ( isset($data['perm']) && $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/');
        }
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['sql'] = (new AttributeModel())->getAdminAllResult($data['page']);
        $data['total_result'] =  (new AttributeModel())->getAdminTotalResult();
        if ( $data['total_result'] > 20 ) {
            $data['pager'] = service('pager');
        }
        return view('admin/attributes/index',$data);
    }

    public function add()
    {
        $data['perm'] = perm('attributes');
        if ( isset($data['perm']) && $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/');
        }
        $data['allcat'] = (new CategoriesModel())->getAllCategoryTree();
        return view('admin/attributes/add',$data);
    }

    public function insert()
    {
        $data['perm'] = perm('attributes');
        if ( $data['perm']->addp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $postForm = $this->request->getPost();

        $name_en = $postForm['name_en'];
        $opt = $postForm['opt'];
        $category_id = $postForm['category_id'];

        if ( $name_en == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to('/admincp/attributes/add'); 
        }
        
        $post = [ 'name_en' => filtreData($name_en),'opt' => filtreData($opt) ];

        $parent_ids = (new AttributeModel())->add($post);
        
        if ( is_array($category_id) && count($category_id) > 0 ) {
            foreach( $category_id as $cat ) {
                (new AttributeModel())->addAttributeCategories(filtreData(my_decrypt($cat)),$parent_ids);
            }
        }

        $this->session->setFlashdata('success', 'Attributes Successfully added in list');
        return redirect()->to('/admincp/attributes');
    }

    public function edit()
    {
        $data['perm'] = perm('attributes');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $data['ids'] = $this->request->getUri()->getSegment(4);
        $data['sql'] = (new AttributeModel())->getSingleAttribute(my_decrypt($data['ids']));
        $data['allcat'] = (new CategoriesModel())->getAllCategoryTree();
        return view('admin/attributes/edit',$data);
    }

    public function update()
    {
        $data['perm'] = perm('attributes');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }

        $postForm = $this->request->getPost();

        $id = my_decrypt($postForm['id']);
        $name_en = $postForm['name_en'];
        $opt = $postForm['opt'];
        $category_id = $postForm['category_id'];

        if ( $name_en == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to('/admincp/attributes/edit/'.$postForm['id']); 
        }
        
        $post = [
                    'id' => filtreData($id),
                    'name_en' => filtreData($name_en),
                    'opt' => filtreData($opt)
                ];
        (new AttributeModel())->add($post);
        
        if ( is_array($category_id) && count($category_id) > 0 ) {
            (new AttributeModel())->deleteAttributeCategories($id);
            foreach( $category_id as $cat ) {
                (new AttributeModel())->addAttributeCategories(filtreData(my_decrypt($cat)),$id);
            }
        }

        $this->session->setFlashdata('success', 'Attributes Successfully updated in list');
        return redirect()->to('/admincp/attributes');
    }


    public function delete()
    {
        $data['perm'] = perm('attributes');
        if ( $data['perm']->deletep == 0 ) {
            return redirect()->to('/admincp/'); 
        }

        $ids = $this->request->getUri()->getSegment(4);
        (new AttributeModel())->add([ 'id' => my_decrypt($ids), 'deleteStatus' => 1 ]);
        $this->session->setFlashdata('success', 'Attributes Successfully deleted');
        return redirect()->to('admincp/attributes');
    }

    public function search()
    {
        $data['perm'] = perm('attributes');
        $attributesvalues = perm('attributesvalues');
        $postForm = $this->request->getGet();
        $sql = (new AttributeModel())->searchAttribute(filtreData($postForm['word']));
        $html = '';
        if(is_array($sql)){
            foreach($sql as $row){
                $html .= '<tr>
                            <td><input type="checkbox" name=""></td>
                            <td>'.$row['id'].'</td>';
               $html .=    '<td>'.$row['name_en'].'</td>';
               $html .=    '<td>'.getAttributeType($row['opt']).'</td>';
               $html .=    '<td>'.$row['total_items'].'</td>';
               $html .=    '<td>';
                if ( $data['perm']->editp == 1 ) {
                    $html .= '<a href="'.base_url().'/admincp/attributes/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">Edit</a>';
                }     
                if ( $data['perm']->deletep == 1 ) {
                    $html .= '<a href="'.base_url().'/admincp/attributes/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                }       
                if ( $attributesvalues->allview == 1 && $attributesvalues->view == 1 ) {
                    $html .= '<a href="'.base_url().'/admincp/attributes/values/'.my_encrypt($row['id']).'?type='.$row['opt'].'" class="mb-2 btn btn-sm btn-warning mr-1">Values</a>';
                }
                $html .= '</td>
                        </tr>';  
            }
        } else {
            $sql = (new AttributeModel())->getAdminAllResult();
            if(is_array($sql)){
                foreach($sql as $row){
                    $html .= '<tr>
                                <td><input type="checkbox" name=""></td>
                                <td>'.$row['id'].'</td>';
                   $html .=    '<td>'.$row['name_en'].'</td>';
                   $html .=    '<td>'.getAttributeType($row['opt']).'</td>';
                   $html .=    '<td>'.$row['total_items'].'</td>';
                   $html .=    '<td>';
                if ( $data['perm']->editp == 1 ) {
                    $html .= '<a href="'.base_url().'/admincp/attributes/edit/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-success mr-1">Edit</a>';
                }     
                if ( $data['perm']->deletep == 1 ) {
                    $html .= '<a href="'.base_url().'/admincp/attributes/delete/'.my_encrypt($row['id']).'" class="mb-2 btn btn-sm btn-danger mr-1" onclick="return confirm(Are you sure to delete this?);">Delete</a>';
                }       
                if ( $attributesvalues->allview == 1 && $attributesvalues->view == 1 ) {
                    $html .= '<a href="'.base_url().'/admincp/attributes/values/'.my_encrypt($row['id']).'?type='.$row['opt'].'" class="mb-2 btn btn-sm btn-warning mr-1">Values</a>';
                }  
                    $html .= '</td>
                            </tr>';  
                }
            }
        }
        print json_encode( [ 'token' => csrf_hash(), 'html' => $html ]);
    }

    public function values()
    {
        $data['perm'] = perm('attributesvalues');
        if ( $data['perm']->allview == 0 ) {
            if ( $data['perm']->addp == 0 || $data['perm']->editp == 0 || $data['perm']->view == 0 || $data['perm']->deletep == 0 ) {
                return redirect()->to('/admincp/'); 
            }
            return redirect()->to('/admincp/'); 
        }
        $data['attr_id'] = $this->request->getUri()->getSegment(4);
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : '';
        if ( !empty($data['type']) && $data['type'] > 0 ) {
            $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
            $data['sql'] = (new AttributeValueModel())->getAdminAllResult(my_decrypt($data['attr_id']),$data['page']);
            $data['total_result'] = (new AttributeValueModel())->countAdminresult(my_decrypt($data['attr_id']));
            if ( $data['total_result'] > 20 ) {
                $data['pager'] = service('pager');
            }
            return view('admin/attributes/values/index',$data);
        } else {
            return redirect()->to('/admincp/attributes');
        }
    }

    public function valuesadd()
    {
        $data['perm'] = perm('attributesvalues');
        if ( $data['perm']->addp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $data['attr_id'] = $this->request->getUri()->getSegment(4);
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : '';
        if ( !empty($data['type']) && $data['type'] > 0 ) {
            return view('admin/attributes/values/add',$data);
        } else {
            return redirect()->to('/admincp/attributes');
        }
    }

    public function valuesinsert()
    {
        $data['perm'] = perm('attributesvalues');
        if ( $data['perm']->addp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $attr_id = my_decrypt(filtreData($this->request->getVar('attr_id')));
        $value_opt = filtreData($this->request->getVar('value_opt'));
        $name_en = filtreData($this->request->getVar('name_en'));
        if ( $name_en == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to('/admincp/attributes/valuesadd/'.$this->request->getVar('attr_id').'?type='.$value_opt);
        }
        $data = [
                    'attr_id' => $attr_id, 
                    'value_opt' => $value_opt,
                    'name_en' => $name_en,
                ];
        $parent_id = (new AttributeValueModel())->add($data);
        if ( $value_opt == 2 ) {
            if ( $_FILES['fimg']['size'] != 0 ) {
                $file = $this->request->getFile('fimg');
                $newName = $file->getRandomName();
                $dir = ROOTPATH . 'public/upload/media';
                $file->move($dir,$newName);
                $path = $dir.'/'.$newName;
                imageThumb($path,$dir,$newName);
                (new AttributeValueModel())->add(['id' => $parent_id, 'value_img' => $newName]);
            }
            $color = str_replace('#','',filtreData($this->request->getVar('color_code')));
            (new AttributeValueModel())->add(['id' => $parent_id, 'color_code' => $color]);
        }
        $this->session->setFlashdata('success', 'Value Successfully added');
        return redirect()->to('/admincp/attributes/values/'.$this->request->getVar('attr_id').'?type='.$value_opt);
    }

    public function valuesedit()
    {
        $data['perm'] = perm('attributesvalues');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $data['attr_id'] = $this->request->getUri()->getSegment(5);
        $data['value_id'] = $this->request->getUri()->getSegment(4);
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : '';
        if ( !empty($data['type']) && $data['type'] > 0 ) {
            $data['sql'] = (new AttributeValueModel())->find(my_decrypt($data['value_id']));
            return view('admin/attributes/values/edit',$data);
        } else {
            return redirect()->to('/admincp/attributes');   
        }
    }

    public function valuesupdate()
    {
        $data['perm'] = perm('attributesvalues');
        if ( $data['perm']->editp == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $attr_id = my_decrypt(filtreData($this->request->getVar('attr_id')));
        $value_id = my_decrypt(filtreData($this->request->getVar('value_id')));
        $value_opt = filtreData($this->request->getVar('value_opt'));
        $name_en = filtreData($this->request->getVar('name_en'));
        if ( $name_en == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to('/admincp/attributes/valuesedit/'.$this->request->getVar('value_id').'/'.$this->request->getVar('attr_id').'?type='.$value_opt);
        }
        $data = [
                    'id' => $value_id,
                    'attr_id' => $attr_id, 
                    'value_opt' => $value_opt,
                    'name_en' => $name_en,
                ];
        (new AttributeValueModel())->add($data);
        if ( $value_opt == 2 ) {
            if ( $_FILES['fimg']['size'] != 0 ) {
                $file = $this->request->getFile('fimg');
                $newName = $file->getRandomName();
                $dir = ROOTPATH . 'public/upload/media';
                $file->move($dir,$newName);
                $path = $dir.'/'.$newName;
                imageThumb($path,$dir,$newName);
                (new AttributeValueModel())->add(['id' => $value_id, 'value_img' => $newName]);
            }
            $color = str_replace('#','',filtreData($this->request->getVar('color_code')));
            (new AttributeValueModel())->add(['id' => $value_id, 'color_code' => $color]);
        }
        $this->session->setFlashdata('success', 'Value Successfully added');
        return redirect()->to('/admincp/attributes/values/'.$this->request->getVar('attr_id').'?type='.$value_opt);
    }

    public function valuesdelete()
    {
        $data['perm'] = perm('attributesvalues');
        if ( $data['perm']->deletep == 0 ) {
            return redirect()->to('/admincp/'); 
        }
        $attr_id = $this->request->getUri()->getSegment(5);
        $value_id = $this->request->getUri()->getSegment(4);
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        (new AttributeValueModel())->add(['id' => my_decrypt($value_id), 'deleteStatus' => 1]);
        $this->session->setFlashdata('success', 'Value Successfully deleted');
        return redirect()->to('/admincp/attributes/values/'.$attr_id.'?type='.$type);
    }

}

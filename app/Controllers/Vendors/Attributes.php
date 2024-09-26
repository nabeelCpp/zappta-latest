<?php

namespace App\Controllers\Vendors;

use App\Controllers\BaseController;
use App\Models\AttributeModel;
use App\Models\AttributeValueModel;
use App\Models\CategoriesModel;

class Attributes extends BaseController
{

    public function index()
    {
        $data['pagetitle'] = 'Attributes';
        $data['result'] = (new AttributeModel())->getAllResult();
        return view('vendors/attributes/index',$data);
    }


    public function data()
    {
        $pag = filtreData($this->request->getVar('length')) ? filtreData($this->request->getVar('length')) : 10;
        $server = [];
        $data = (new AttributeModel())->getAllResult($pag);
        if ( is_array($data) && count($data) > 0 ) {
            foreach( $data as $q ) {
                $server[] = [
                                'id' => my_encrypt($q['id']),
                                'name' => ucfirst($q['name_en']),
                                'value' => ( new \App\Models\AttributeValueModel())->countresult($q['id']),
                                'edit' => my_encrypt($q['id']).'__'.my_encrypt($q['opt']),
                            ]; 
            }
        }
        return json_encode(['recordsTotal' => (new AttributeModel())->countTotalStoreAttr() , 'recordsFiltered' => (new AttributeModel())->countTotalStoreAttr(), 'data' => $server ]);
    }

    public function add()
    {
        $data['pagetitle'] = 'Attributes';
        $data['allcat'] = (new CategoriesModel())->getAllCategoryTree();
        return view('vendors/attributes/add',$data);
    }

    public function save()
    {
        $id = filtreData($this->request->getVar('id'));
        $name_en = filtreData($this->request->getVar('name_en'));
        $opt = filtreData($this->request->getVar('opt'));
        $category_id = $this->request->getVar('category_id');
        if ( $name_en == "" || $opt == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to(previous_url());
        }
        if ( my_decrypt($id) == 0 ) {
            $id = (new AttributeModel())->add([ 'name_en' => $name_en, 'opt' => $opt, 'store_id' => getVendorUserId() ]);
            $this->session->setFlashdata('success', 'Attribute successfully added');
        } else {
            (new AttributeModel())->add([ 'id' => my_decrypt($id), 'name_en' => $name_en, 'opt' => $opt, 'store_id' => getVendorUserId() ]);
            $id = my_decrypt($id);
            $this->session->setFlashdata('success', 'Attribute successfully update');
        }
        if ( is_array($category_id) && count($category_id) > 0 ) {
            (new AttributeModel())->deleteAttributeCategories($id);
            foreach( $category_id as $cat ) {
                (new AttributeModel())->addAttributeCategories(filtreData(my_decrypt($cat)),$id);
            }
        }
        return redirect()->to('/vendors/attributes');
    }

    public function edit()
    {
        $data['pagetitle'] = 'Attributes';
        $id = filtreData($this->request->getUri()->getSegment(4));
        $data['rows'] = (new AttributeModel())->getById(my_decrypt($id));
        $data['sql'] = (new AttributeModel())->getSingleAttribute(my_decrypt($id));
        $data['allcat'] = (new CategoriesModel())->getAllCategoryTree();
        return view('vendors/attributes/edit',$data);
    }

    public function trash()
    {
        $id = filtreData($this->request->getUri()->getSegment(4));
        (new AttributeModel())->deleteR(my_decrypt($id));
        $this->session->setFlashdata('success', 'Attribute successfully deleted');
        return redirect()->to('/vendors/attributes');
    }

    /*
    *   Attribute values
    */
    public function values()
    {
        $data['id'] = filtreData($this->request->getUri()->getSegment(4));
        $data['pagetitle'] = 'Attributes';
        $data['attrtitle'] = (new AttributeModel())->findById(my_decrypt($data['id']));
        $data['result'] = (new AttributeValueModel())->getAllResult(my_decrypt($data['id']));
        return view('vendors/attributes/values/index',$data);      
    }

    public function valuesdata()
    {
        $pag = filtreData($this->request->getVar('length')) ? filtreData($this->request->getVar('length')) : 10;
        $id = filtreData($this->request->getUri()->getSegment(4));
        $server = [];
        $data = (new AttributeValueModel())->getAllResult(my_decrypt($id),$pag);
        if ( is_array($data) && count($data) > 0 ) {
            foreach( $data as $q ) {

                switch ($q['value_opt']) {
                    case 1:
                            $value_opt = 'Size';
                        break;
                    
                    case 2:
                            $value_opt = 'Color';
                        break;
                    
                    case 3:
                            $value_opt = 'Dimension';
                        break;
                    
                    default:
                            $value_opt = 'Paper Type';
                        break;
                }
                $server[] = [
                                'id' => my_encrypt($q['id']),
                                'name' => ucfirst($q['name_en']),
                                'value_opt' => $value_opt,
                                'edit' => my_encrypt($q['id']).'__'.my_encrypt($q['attr_id']).'__'.my_encrypt($q['value_opt']),
                            ]; 
            }
        }
        return json_encode(['recordsTotal' => (new AttributeValueModel())->countresult(my_decrypt($id)) , 'recordsFiltered' => (new AttributeValueModel())->countresult(my_decrypt($id)), 'data' => $server ]);   
    }

    public function valueadd()
    {
        $data['id'] = filtreData($this->request->getUri()->getSegment(4));
        $data['pagetitle'] = 'Attributes';
        $data['attrtitle'] = (new AttributeModel())->findById(my_decrypt($data['id']));
        $data['result'] = (new AttributeModel())->getAllResult(100);
        return view('vendors/attributes/values/valueadd',$data);
    }

    public function valueedit()
    {
        $data['id'] = filtreData($this->request->getUri()->getSegment(4));
        $data['attr_id'] = filtreData($this->request->getUri()->getSegment(5));
        $data['pagetitle'] = 'Attributes';
        $data['sql'] = (new AttributeValueModel())->getById(my_decrypt($data['id']));
        $data['attrtitle'] = (new AttributeModel())->findById(my_decrypt($data['attr_id']));
        $data['result'] = (new AttributeModel())->getAllResult(100);
        return view('vendors/attributes/values/valueedit',$data);
    }

    public function valueinsert()
    {
        $attr_id = my_decrypt(filtreData($this->request->getVar('attr_id')));
        $valueid = my_decrypt(filtreData($this->request->getVar('_valueid')));
        $value_opt = filtreData($this->request->getVar('value_opt'));
        $name_en = filtreData($this->request->getVar('name_en'));
        $color_code = filtreData($this->request->getVar('color_code'));
        $price_enable = filtreData($this->request->getVar('price_enable'));
        $price_value = filtreData($this->request->getVar('price_value'));
        $filenamevalue = filtreData($this->request->getVar('filenamevalue'));
        $fimg = filtreData($this->request->getVar('fimg'));
        if ( $attr_id == "" || $name_en == "" || $value_opt == "" ) {
            $this->session->setFlashdata('error', 'Please fill all fields');
            return redirect()->to(previous_url());
        }
        if ( $valueid == 0 ) {
            // $newName = '';
            // if ( $_FILES['fimg']['size'] != 0 ) {
            //     $file = $this->request->getFile('fimg');
            //     $newName = $file->getRandomName();
            //     $dir = ROOTPATH . 'public/upload/media';
            //     $file->move($dir,$newName);
            //     $path = $dir.'/'.$newName;
            //     imageThumb($path,$dir,$newName);
            // }
            $data = [
                        'attr_id' => $attr_id, 
                        'value_opt' => my_decrypt($value_opt),
                        'name_en' => $name_en,
                        'color_code' => $color_code,
                        'price_enable' => $price_enable,
                        'price_value' => $price_value,
                        'value_img' => $fimg,
                        'store_id' => getVendorUserId()
                    ];
            (new AttributeValueModel())->add($data);
            $this->session->setFlashdata('success', 'Attribute successfully added');
        } else {
            // $newName = $filenamevalue;
            // if ( $_FILES['fimg']['size'] != 0 ) {
            //     $file = $this->request->getFile('fimg');
            //     $newName = $file->getRandomName();
            //     $dir = ROOTPATH . 'public/upload/media';
            //     $file->move($dir,$newName);
            //     $path = $dir.'/'.$newName;
            //     imageThumb($path,$dir,$newName);
            // }
            $data = [
                        'id' => $valueid, 
                        'attr_id' => $attr_id, 
                        'value_opt' => my_decrypt($value_opt),
                        'name_en' => $name_en,
                        'color_code' => $color_code,
                        'price_enable' => $price_enable,
                        'price_value' => $price_value,
                        'value_img' => $fimg,
                        'store_id' => getVendorUserId()
                    ];
            (new AttributeValueModel())->add($data);
            $this->session->setFlashdata('success', 'Attribute successfully updated');
        }
        // $this->session->setFlashdata('success', 'Attribute successfully deleted');
        return redirect()->to('/vendors/attributes/values/'.filtreData($this->request->getVar('attr_id')).'/?t='.$value_opt);
    }

    public function valuetrash()
    {
        $id = filtreData($this->request->getUri()->getSegment(4));
        $attr_id = filtreData($this->request->getUri()->getSegment(5));
        $value_opt = filtreData($this->request->getVar('t'));
        (new AttributeValueModel())->deleteR(my_decrypt($id));
        $this->session->setFlashdata('success', 'Attribute successfully deleted');
        return redirect()->to('/vendors/attributes/values/'.$attr_id.'/?t='.$value_opt);
    }


}
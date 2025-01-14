<?php
namespace App\Controllers\Vendors;


use App\Controllers\BaseController;
use App\Models\CategoriesModel;
use App\Models\ProductsModel;
// use App\Models\Setting;

class Products extends BaseController
{
    
    public function index()
    {
        $data['pagetitle'] = 'Products';
        $data['pag'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['product'] = (new ProductsModel())->getStoreProductByVendors($data['pag']);
        $data['total_orders'] = (new ProductsModel())->getStoreProductByVendorsTotal();
        if ( $data['total_orders'] > 10 ) {
            $data['pager'] = service('pager');
        }
        return view('vendors/products/index',$data);
    }
    
    public function data()
    {
        $pag = filtreData($this->request->getVar('length')) ? filtreData($this->request->getVar('length')) : 10;
        $server = [];
        $data = (new ProductsModel())->getAllResult($pag);
        if ( is_array($data) && count($data) > 0 ) {
            $itme = 1;
            foreach( $data as $q ) {
                $product_detail = ( new \App\Models\ProductsDetailModel())->getById($q['id']);
                if( ! empty( $q['cover'] ) ) { 
                    $ext_name = explode('.',$q['cover']);
                    $url = base_url().'images/product/'.$ext_name[0].'/'.$ext_name[1].'/100';
                } else {
                    $url = base_url().'images/product/img-not-found/jpg/100';
                }
                if ( !empty($product_detail['retail_price_notax']) ) {
                    $price = !empty($product_detail) ? number_format($product_detail['retail_price_notax'],2) : '0.00';
                } else {
                    $price = !empty($product_detail) ? number_format($product_detail['retail_price_tax'],2) : '0.00';
                }
                $quantity = !empty($product_detail) ? $product_detail['quantity'] : 0;
                $server[] = [
                                'id' => my_encrypt($q['id']),
                                'item_id' => $itme,
                                'fimg' => $url,
                                'name' => ucfirst($q['name']).'__'.$url,
                                'reference' => $q['reference'],
                                'category' => ( new CategoriesModel())->getCategoryProduct($q['id']),
                                'price' => $price,
                                'quantity' => $quantity,
                                'status' => $q['status'],
                                'edit' => my_encrypt($q['id']).'__'.$q['status'],
                            ]; 
                $itme++;
            }
        }
        return json_encode(['recordsTotal' => (new ProductsModel())->countTotalStorePro() , 'recordsFiltered' => (new ProductsModel())->countTotalStorePro(), 'data' => $server ]);
    }
    
    public function add()
    {
        $data['pagetitle'] = 'Add';
        $data['getData'] = session()->get('vpf');
        return view('vendors/products/add',$data);
    }

    public function insert()
    {
        session()->set('vpf',$_POST);
        $name = $_POST['product']['default']['name'];
        $retail_price_notax = $_POST['product']['detail']['retail_price_notax'];
        $retail_price_tax = $_POST['product']['detail']['retail_price_tax'];
        $product_category = isset($_POST['product_category']) ? $_POST['product_category'][0] : '';
        if ( filtreData($name) == "" ) {
            $this->session->setFlashdata('error', 'Please fill all required fields. ( * )');
            return redirect()->to('/vendors/products/add');
        }
        if ( filtreData($product_category) == "" ) {
            $this->session->setFlashdata('error', 'Please select atleast one category');
            return redirect()->to('/vendors/products/add');
        }
        
        if ( filtreData($retail_price_notax) >=  filtreData($retail_price_tax) ) {
            $this->session->setFlashdata('error', 'The sale price is greater than the Regular price. Please change the Sale price');
            return redirect()->to('/vendors/products/add');
        }
        $ids = (new ProductsModel())->addproduct($this->request->getPost());        
        if ( $ids > 0 ) {
            unset($_SESSION['vpf']);
            $this->session->setFlashdata('success', 'Product successfully added.');
            return redirect()->to('/vendors/products');
        } else {
            $this->session->setFlashdata('error', 'There is some error, please try again.');
            return redirect()->to('/vendors/products/add');
        }
    }
    
    public function edit()
    {
        $ids = $this->request->getUri()->getSegment(4);
        $data['pagetitle'] = 'Edit';
        $data['default'] = (new ProductsModel())->getById(my_decrypt($ids));
        $data['gallery'] = (new ProductsModel())->getProductGallery(my_decrypt($ids));
        // $data['detail'] = (new ProductsModel())->getProductDetail(my_decrypt($ids));
        // $data['category'] = (new ProductsModel())->getProductCategory(my_decrypt($ids));
        // $data['seo'] = (new ProductsModel())->getProductSeo(my_decrypt($ids));
        return view('vendors/products/edit',$data);
    }

    public function update()
    {
        $name = $_POST['product']['default']['name'];
        $retail_price_notax = $_POST['product']['detail']['retail_price_notax'];
        $retail_price_tax = $_POST['product']['detail']['retail_price_tax'];
        $_id = filtreData($_POST['_id']);
        if ( filtreData($name) == "" ) {
            $this->session->setFlashdata('error', 'Please fill all required fields. ( * )');
            return redirect()->to('/vendors/products/edit/'.$_id);
        }
        
        if ( filtreData($retail_price_notax) >=  filtreData($retail_price_tax) ) {
            $this->session->setFlashdata('error', 'The sale price is greater than the Regular price. Please change the Sale price');
            return redirect()->to('/vendors/products/edit/'.$_id);
        }

        $ids = (new ProductsModel())->updateproduct($this->request->getPost());        
        if ( $ids > 0 ) {
            unset($_SESSION['vpf']);
            $this->session->setFlashdata('success', 'Product successfully updated.');
            return redirect()->to('/vendors/products');
        } else {
            $this->session->setFlashdata('error', 'There is some error, please try again.');
            return redirect()->to('/vendors/products/edit/'.$_id);
        }
    }
    
    public function draft()
    {
        $ids = $this->request->getUri()->getSegment(4);
        (new ProductsModel())->add(['id' => my_decrypt($ids), 'status' => 2]);
        $this->session->setFlashdata('success', 'Product successfully update.');
        return redirect()->to('/vendors/products');
    }

    public function publish()
    {
        $ids = $this->request->getUri()->getSegment(4);
        (new ProductsModel())->add(['id' => my_decrypt($ids), 'status' => 1]);
        $this->session->setFlashdata('success', 'Product successfully update.');
        return redirect()->to('/vendors/products');
    }

    public function trash()
    {
        $ids = $this->request->getUri()->getSegment(4);
        (new ProductsModel())->add(['id' => my_decrypt($ids), 'deleteStatus' => 1]);
        $this->session->setFlashdata('success', 'Product successfully update.');
        return redirect()->to('/vendors/products');
    }

    public function related()
    {
        $result = [];
        $postForm = filtreData($this->request->getVar('search'));
        $searchproduct = (new ProductsModel())->searchproduct($postForm);
        if ( is_array($searchproduct) && count($searchproduct) > 0 ) {
            foreach( $searchproduct as $product ) {
                $image = base_url().'images/product/img-not-found/jpg/100';
                if ( !empty($product['cover']) ) {
                    $ext_fimg = explode('.',$product['cover']);
                    $image = base_url().'images/product/'.$ext_fimg[0].'/'.$ext_fimg[1].'/100';
                }
                $result[] = [ 'id' => $product['id'] , 'text' => $product['name'] , 'image' => $image  ];
            }
        }
        print json_encode( $result );
        exit;
    }

    public function getbrand()
    {
        $catid = filtreData($this->request->getVar('catid'));
        $new_cat = explode('.',$catid);
        $result = (new CategoriesModel())->getSelectBrand($new_cat[0]);
        $result_attribute = (new CategoriesModel())->getSelectAttribute($new_cat[0]);
        if ( is_array($result) && count($result) > 0 || is_array($result_attribute) && count($result_attribute) > 0 ) {
            return json_encode([ 'brands' => $result,'brandsall' => my_encrypt(serialize($result)), 'attributes' => $result_attribute, 'attributesall' => my_encrypt(serialize($result_attribute)) ]);
        } else {
            return json_encode(0);
        }
    }

    public function getAttributes()
    {
        $catid = filtreData($this->request->getVar('productAttributes'));
        $newId = explode('.',$catid);
        $result = (new \App\Models\AttributeValueModel())->getValueByAttrbuteForProduct($newId[0], false);
        if ( is_array($result) && count($result) > 0 ) {
            $r = [];
            $html = '<div class="valueblock" id="vvb_'.$catid.'">
                        <h3>'.$result[0]['attr_name'].'</h3>
                        <div class="value_row d-flex">
                               <div class="check"></div>
                               <div class="name">Name</div>
                               <div class="price">Price Increament</div>
                               <div class="price mx-1">Quantity</div>
                          </div>';
            foreach ( $result as $rr ) {
                if ( $rr['value_opt'] == 2 ) {
                    if($rr['value_img']) {
                        $img = getImageThumg('products',$rr['value_img'],100);
                        $img = '<span class="color"><img src="'.$img.'" alt="" class="rounded"></span>';
                    }else{
                        $img = '<span class="color" style="background-color: #'.$rr['color_code'].';"></span>';
                    }
                    $html .= '<div class="value_row d-flex">
                                   <div class="check"><input type="checkbox" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][name]" class="valuecheck" value="'.my_encrypt($catid.'_'.$rr['attr_id'].'_'.$rr['id'].'_'.$rr['value_opt']).'" id="vbv_'.$rr['id'].'" onclick="enablepriceblock('.$rr['id'].');"></div>
                                   <div class="name">'.$img.'<span>'.$rr['name_en'].'</span></div>
                                   <div class="price"><input type="number" id="vsvs_'.$rr['id'].'" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][price]" value="0" disabled></div>
                                    <div class="price mx-1"><input type="number" id="vq_'.$rr['id'].'" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][qty]" value="0" disabled></div>
                              </div>';
                } else {
                    $html .= '<div class="value_row d-flex">
                                   <div class="check"><input type="checkbox" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][name]" class="valuecheck" value="'.my_encrypt($catid.'_'.$rr['attr_id'].'_'.$rr['id'].'_'.$rr['value_opt']).'" id="vbv_'.$rr['id'].'" onclick="enablepriceblock('.$rr['id'].');"></div>
                                   <div class="name">'.$rr['name_en'].'</div>
                                   <div class="price"><input type="number" id="vsvs_'.$rr['id'].'" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][price]" value="0" disabled></div>
                                    <div class="price mx-1"><input type="number" id="vq_'.$rr['id'].'" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][qty]" value="0" disabled></div>
                              </div>';
                }
            }
            $html .= '</div>
                      <input type="hidden" name="product_attribute[selected]['.$catid.']" value="'.my_encrypt($newId[0]).'"/>';
            $r[] = $html;
            return json_encode($r);
        } else {
            return json_encode(0);
        }
    }

    public function updateattr()
    {
        (new ProductsModel())->updateproattrsss();
    }

    public function compaign()
    {
        $pro = filtreData($this->request->getVar('pro'));
        $cc = filtreData($this->request->getVar('cc'));
        if ( $pro == 1 ) {
            (new \App\Models\CompainModel())->updateCompainForVendors(2,my_decrypt($cc));
        } else {
            (new \App\Models\CompainModel())->updateCompainForVendors(3,my_decrypt($cc));
        }
        return redirect()->to('/vendors');
    }

    // public function giveway()
    // {
    //     $pro = filtreData($this->request->getUri()->getSegment(4));
    //     $cc = filtreData($this->request->getUri()->getSegment(5));
    //     (new \App\Models\CompainModel())->addProductInCompaign( my_decrypt($cc) , my_decrypt($pro) );
    //     $this->session->setFlashdata('success', 'Product successfully add into Giveway.');
    //     return redirect()->to('/vendors/products');
    // }


    // public function removegiveway()
    // {
    //     $pro = filtreData($this->request->getUri()->getSegment(4));
    //     $cc = filtreData($this->request->getUri()->getSegment(5));
    //     (new \App\Models\CompainModel())->removeProductInCompaign( my_decrypt($cc) , my_decrypt($pro) );
    //     $this->session->setFlashdata('success', 'Product successfully removed from Giveway.');
    //     return redirect()->to('/vendors/products');
    // }

}

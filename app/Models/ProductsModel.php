<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'products';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDelete        = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'item_id',
        'store_id',
        'sd_row',
        'pds',
        'pc',
        'name',
        'url',
        'short',
        'description',
        'conditions',
        'reference',
        'isbn',
        'ean',
        'upcbarcode',
        'mpncode',
        'brand_id',
        'status',
        'cover',
        'deleteStatus',
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = ['update_product'];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    /**
     * Constant limit for products.
     * @author M Nabeel Arshad
     */

    const LIMIT = 12;


    public function update_product($id)
    {
        $pid = $id['id'];
        $psid = uuid_creat($id['data']['store_id']);
        $pc = uuid_product() . $pid;
        $sd_row = uuid_creat($pid);
        $this->add(['id' => $pid, 'pc' => $pc, 'sd_row' => $sd_row, 'pds' => $psid]);
    }

    public function getAdminAllResult($limit = 1)
    {
        $limits = 12;
        $result_limit = 0;
        if ($limit > 1) {
            $result_limit = $limits * ($limit - 1);
        }
        return $this->db->table($this->table)
            ->select('products.*,b.name as bname,st.store_name, COUNT(ot.item_id) as total_items ')
            ->join('brands b', 'b.id=products.brand_id', 'LEFT')
            ->join('vendor st', 'st.id=products.store_id', 'LEFT')
            ->join('order_items ot', 'ot.item_id=products.id', 'LEFT')
            ->where('products.deleteStatus', 0)
            ->groupBy('products.id')
            ->limit($limits, $result_limit)
            ->orderBy('products.id DESC')
            ->get()
            ->getResultArray();
    }

    public function adminsearch($word)
    {
        return $this->db->table($this->table)
            ->select('products.*,b.name as bname,st.store_name, COUNT(ot.item_id) as total_items ')
            ->join('brands b', 'b.id=products.brand_id', 'LEFT')
            ->join('vendor st', 'st.id=products.store_id', 'LEFT')
            ->join('order_items ot', 'ot.item_id=products.id', 'LEFT')
            ->where('products.deleteStatus', 0)
            ->like('products.name', $word)
            ->groupBy('products.id')
            ->orderBy('products.id DESC')
            ->get()
            ->getResultArray();
    }

    public function getAdminProductById($id)
    {
        $sql = $this->db->table('products')
            ->select('products.*, products.id as pid, product_detail.*,shipping_preference.handlingcharges,shipping_preference.freeshipat,shipping_preference.freeshipatweight')
            ->join('product_detail', 'product_detail.product_id=products.id', 'LEFT')
            ->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT')
            // ->join('product_attribute','product_attribute.product_id=products.id','LEFT')
            ->where('products.id', $id)
            ->where('products.deleteStatus', 0)
            ->get()
            ->getRowArray();
        if (!empty($sql)) {
            // $sql['attributes'] = $this->getStoreAttrbute($sql['store_id'],$sql['product_id']);
            $sql['gallery'] = (new \App\Models\ProductsGalleryModel())->getAllById($sql['product_id']);
            return $sql;
        }
        return NULL;
    }

    public function getTotalAdminProduct()
    {
        return $this->db->table($this->table)->where('deleteStatus', 0)->countAllResults();
    }


    public function getAllResult($limit = 20)
    {
        return $this->where('deleteStatus', 0)
            ->where('store_id', getVendorUserId())
            ->orderBy('id DESC')
            ->paginate($limit);
    }

    public function countTotalStorePro()
    {
        return $this->db->table($this->table)->where('deleteStatus', 0)->where('store_id', getVendorUserId())->countAllResults();
    }

    public function add($data = [])
    {
        $this->save($data);
        return $this->getInsertID();
    }

    public function deleteR($ids)
    {
        $builder = $this->db->table($this->table);
        $builder->set('deleteStatus', 1);
        $builder->where('id', $ids);
        $builder->where('deleted_at', date('Y-m-d H:i:s'));
        $builder->update();
    }

    public function searchproduct($name)
    {
        return $this->db->table($this->table)
            ->select('name,cover,id')
            ->like('name', $name, 'both')
            ->where('deleteStatus', 0)
            ->where('store_id', getVendorUserId())
            ->get()
            ->getResultArray();
    }

    public function getById($id)
    {
        $sql = $this->db->table('products')
            ->select('products.*, products.id as pid,product_detail.*,meta_detail.*')
            ->join('product_detail', 'product_detail.product_id=products.id', 'left')
            ->join('meta_detail', 'meta_detail.entry_id=products.id', 'left')
            ->where('products.id', $id)
            ->where('products.store_id', getVendorUserId())
            ->where('products.deleteStatus', 0)
            ->where('meta_detail.type', 1)
            ->get()
            ->getRowArray();
        return $sql;
    }

    public function findById($id)
    {
        $user = $this->asArray()
            ->where(['id' => $id, 'store_id' => getVendorUserId(), 'deleteStatus' => 0])
            ->first();
        if (!empty($user)) {
            return $user['name'];
        }
        return false;
    }

    public function getProductDetail($id)
    {
        return (new \App\Models\ProductsDetailModel())->getById($id);
    }

    public function getProductGallery($id)
    {
        return (new \App\Models\ProductsGalleryModel())->getAllById($id);
    }

    /*
    *   type = 1 for products
    */
    public function getProductSeo($id)
    {
        return (new \App\Models\MetaModel())->findById($id, 1);
    }

    private function getProductUrl($data)
    {
        if (isset($data) && empty($data)) {
            return $data;
        }
        if (isset($data)) {
            $link = strtolower(trim($data));
            $link = preg_replace('/[^a-z0-9-]/', '-', $link);
            $link = preg_replace('/-+/', "-", $link);
            $link = rtrim($link, '-');
            $link = preg_replace('/\s+/', '-', $link);
            $existing_lnk = $this->db->table($this->table);
            $existing_lnk->where('url', $link);
            // $existing_lnk->where('type',1);
            $num = $existing_lnk->get()->getResult();
            $first_total = count($num);
            for ($i = 0; $first_total != 0; $i++) {
                if ($i == 0) {
                    $new_number = $first_total + 1;
                    $newlink = $link . "-" . $new_number;
                }
                $check_lnk = $this->db->table($this->table);
                $check_lnk->where('url', $newlink);
                // $check_lnk->where('type',1);
                $other = $check_lnk->get()->getResult();
                $other_total = count($other);
                if ($other_total != 0) {
                    $first_total = $first_total + $other_total;
                    $new_number = $first_total;
                    $newlink = $link . "-" . $new_number;
                } elseif ($other_total == 0) {
                    $first_total = 0;
                }
            }

            if ($i > 0) {
                $data = $newlink;
            } else {
                $data = $link;
            }
        }
        return $data;
    }

    public function addproduct($post = [])
    {
        $default = [];
        $detail = [];
        $categories = [];
        $gallery = [];
        $urls = $this->getProductUrl(filtreData($post['product']['default']['name']));
        if (is_array($post['product']['default']) && count($post['product']['default']) > 0) {
            foreach ($post['product']['default'] as $d => $v) {
                if ($d == 'brand_id') {
                    $default[$d] = filtreData($v);
                } elseif ($d == 'short' || $d == 'description') {
                    $default[$d] = filtreDataText($v);
                } else {
                    $default[$d] = filtreData($v);
                }
            }
            $default['store_id'] = getVendorUserId();
            $default['url'] = $urls;
        }

        $product_id = $this->add($default);

        if (is_array($post['product']['detail']) && count($post['product']['detail']) > 0) {
            foreach ($post['product']['detail'] as $ds => $vs) {
                $detail[$ds] = filtreData($vs);
            }
        }
        $detail['product_value'] = isset($post['product_attribute']['value']) ? serialize($post['product_attribute']['value']) : '';
        $detail['product_selected'] = !empty($post['product_attribute']) ? serialize($post['product_attribute']['selected']) : '';
        $detail['product_id'] = $product_id;
        $detail['store_id'] = getVendorUserId();
        $detail['deal_enable'] = isset($post['product']['detail']['deal_enable']) ? $post['product']['detail']['deal_enable'] : 0;
        (new \App\Models\ProductsDetailModel())->add($detail);

        if (isset($post['product_category']) && is_array($post['product_category']) && count($post['product_category']) > 0) {
            $cc = $post['product_category'][0];
            $ncc = explode('.', $cc);
            foreach ($ncc as $ds => $vs) {
                if ($vs > 0) {
                    $categories['catid'] = filtreData($vs);
                    $categories['product_id'] = $product_id;
                    $categories['store_id'] = getVendorUserId();
                    (new \App\Models\ProductsCategoriesModel())->add($categories);
                }
            }
        }

        if (isset($post['product_gallery']) && is_array($post['product_gallery']) && count($post['product_gallery']) > 0) {
            foreach ($post['product_gallery'] as $ds => $vs) {
                $gallery['fimg'] = filtreData($vs);
                $gallery['product_id'] = $product_id;
                (new \App\Models\ProductsGalleryModel())->add($gallery);
            }
            if (empty($post['product']['default']['cover'])) {
                if (isset($post['product_gallery']) && !empty(filtreData($post['product_gallery'][0]))) {
                    $this->add(['id' => $product_id, 'cover' => filtreData($post['product_gallery'][0])]);
                }
            }
        }

        if (isset($post['product_attribute']['value']) && is_array($post['product_attribute']['value']) && count($post['product_attribute']['value']) > 0) {
            // $cc = $post['product_category'][0];
            // $ncc = explode('.',$cc);
            foreach ($post['product_attribute']['value'] as $attr => $va) {
                foreach ($va as $v => $k) {
                    (new \App\Models\ProductsAttributeModel())->insertAttr($product_id, $attr, $v, my_decrypt($k['name']), $k['price']);
                }
            }
            $this->updateproattr($product_id);
        }

        if (isset($post['product']['seo']) && is_array($post['product']['seo'])) {
            $metatitle = !empty(filtreData($post['product']['seo']['metatitle'])) ? filtreData($post['product']['seo']['metatitle']) : filtreData($post['product']['default']['name']);
            $description = !empty(filtreData($post['product']['seo']['description'])) ? filtreData($post['product']['seo']['description']) : filtreData($post['product']['default']['short'] ?? '');
            $keywords = !empty(filtreData($post['product']['seo']['keywords'])) ? filtreData($post['product']['seo']['keywords']) : '';
            (new \App\Models\MetaModel())->add(['type' => 1, 'entry_id' => $product_id, 'urls' => $urls, 'meta_title' => $metatitle, 'meta_description' => $description, 'meta_keywords' => $keywords]);
        }

        return $product_id;
    }

    public function updateproduct($post = [])
    {
        $default = [];
        $detail = [];
        $categories = [];
        $gallery = [];
        $urls = $this->getProductUrl(filtreData($post['product']['default']['name']));
        if (is_array($post['product']['default']) && count($post['product']['default']) > 0) {
            foreach ($post['product']['default'] as $d => $v) {
                if ($d == 'brand_id') {
                    $default[$d] =  filtreData($v);
                } elseif ($d == 'short' || $d == 'description') {
                    $default[$d] = filtreDataText($v);
                } else {
                    $default[$d] = filtreData($v);
                }
            }
            $default['id'] = filtreData(my_decrypt($post['_id']));
        }
        $this->add($default);
        $product_id = filtreData(my_decrypt($post['_id']));

        if (is_array($post['product']['detail']) && count($post['product']['detail']) > 0) {
            foreach ($post['product']['detail'] as $ds => $vs) {
                $detail[$ds] = filtreData($vs);
            }
        }
        // $detail['product_id'] = $product_id;
        $detail['product_value'] = !empty($post['product_attribute']) ? serialize($post['product_attribute']['value']) : '';
        $detail['product_selected'] = !empty($post['product_attribute']) ? serialize($post['product_attribute']['selected']) : '';
        $detail['deal_enable'] = isset($post['product']['detail']['deal_enable']) ? $post['product']['detail']['deal_enable'] : 0;
        (new \App\Models\ProductsDetailModel())->updateData($detail, $product_id);

        if (isset($post['product_category']) && is_array($post['product_category']) && count($post['product_category']) > 0) {
            (new \App\Models\ProductsCategoriesModel())->deleteCategory($product_id);
            $cc = $post['product_category'][0];
            $ncc = explode('.', $cc);
            foreach ($ncc as $ds => $vs) {
                if ($vs > 0) {
                    $categories['catid'] = filtreData($vs);
                    $categories['product_id'] = $product_id;
                    $categories['store_id'] = getVendorUserId();
                    (new \App\Models\ProductsCategoriesModel())->add($categories);
                }
            }
        }

        if (isset($post['product_gallery']) && is_array($post['product_gallery']) && count($post['product_gallery']) > 0) {
            (new \App\Models\ProductsGalleryModel())->deleteImage($product_id);
            foreach ($post['product_gallery'] as $ds => $vs) {
                $gallery['fimg'] = filtreData($vs);
                $gallery['product_id'] = $product_id;
                (new \App\Models\ProductsGalleryModel())->add($gallery);
            }
            if (empty($post['product']['default']['cover'])) {
                if (isset($post['product_gallery']) && !empty(filtreData($post['product_gallery'][0]))) {
                    $this->add(['id' => $product_id, 'cover' => filtreData($post['product_gallery'][0])]);
                }
            }
        }

        if (isset($post['product_attribute']['value']) && is_array($post['product_attribute']['value']) && count($post['product_attribute']['value']) > 0) {
            (new \App\Models\ProductsAttributeModel())->deleteAllAttr($product_id);
            foreach ($post['product_attribute']['value'] as $attr => $va) {
                foreach ($va as $v => $k) {
                    (new \App\Models\ProductsAttributeModel())->insertAttr($product_id, $attr, $v, my_decrypt($k['name']), $k['price']);
                }
            }
            $this->updateproattr($product_id);
        }

        if (isset($post['product']['seo']) && is_array($post['product']['seo'])) {
            $metatitle = !empty(filtreData($post['product']['seo']['metatitle'])) ? filtreData($post['product']['seo']['metatitle']) : filtreData($post['product']['default']['name']);
            
            $description = !empty(filtreData($post['product']['seo']['description'])) ? filtreData($post['product']['seo']['description']) : filtreData($post['product']['default']['short'] ?? '');

            $keywords = !empty(filtreData($post['product']['seo']['keywords'])) ? filtreData($post['product']['seo']['keywords']) : '';
            (new \App\Models\MetaModel())->updateData(1, $product_id, $metatitle, $description, $keywords);
        }

        return $product_id;
    }


    public function updateproattr($product_id)
    {
        $re = [];
        $sql = $this->db->table('product_attribute')
            ->where('product_id', $product_id)
            ->get()
            ->getResultArray();
        if (is_array($sql) && count($sql) > 0) {
            foreach ($sql as $q) {
                $re[$q['product_id']][$q['type']][] = $q['value_id'];
            }
        }
        foreach ($re as $rr => $rk) {
            foreach ($rk as $ti => $tt) {
                switch ($ti) {
                    case 1:
                        // code...
                        $this->uppro('sizes', serialize($tt), $rr, $ti);
                        break;

                    case 2:
                        // code...
                        $this->uppro('colors', serialize($tt), $rr, $ti);
                        break;

                    case 3:
                        // code...
                        $this->uppro('dimension', serialize($tt), $rr, $ti);
                        break;

                    default:
                        // code...
                        $this->uppro('paper_type', serialize($tt), $rr, $ti);
                        break;
                }
            }
        }
    }

    private function uppro($filename, $sizes, $product_id, $type)
    {
        $this->db->table('product_attribute')
            ->set($filename, $sizes)
            ->where('product_id', $product_id)
            ->update();
        return true;
    }


    public function getStoreListing($store_id)
    {
        return $this->db->table('products')
            ->select('products.id as pid,products.name as pname,products.short as pshort,products.url as purl,products.cover as pcover,products.sd_row as sd_row,products.pds as pds,products.pc as pc,product_detail.retail_price_tax,product_detail.retail_price_notax,product_detail.deal_enable,product_detail.final_price,product_detail.zappta_commission,product_detail.deal_final_price,product_detail.outofstockorder,shipping_preference.handlingcharges,shipping_preference.freeshipat,shipping_preference.freeshipatweight')
            ->join('product_detail', 'product_detail.product_id=products.id', 'LEFT')
            ->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT')
            ->where('products.store_id', $store_id)
            ->where('products.deleteStatus', 0)
            ->where('products.status', 1)
            ->get()
            ->getResultArray();
    }

    public function getStoreListingBySearch($store_id, $search)
    {
        return $this->db->table('products')
            ->select('products.id as pid,products.name as pname,products.short as pshort,products.url as purl,products.cover as pcover,products.sd_row as sd_row,products.pds as pds,products.pc as pc,product_detail.retail_price_tax,product_detail.retail_price_notax,product_detail.deal_enable,product_detail.final_price,product_detail.zappta_commission,product_detail.deal_final_price,product_detail.outofstockorder,shipping_preference.handlingcharges,shipping_preference.freeshipat,shipping_preference.freeshipatweight')
            ->join('product_detail', 'product_detail.product_id=products.id', 'LEFT')
            ->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT')
            ->where('products.store_id', $store_id)
            ->where('products.deleteStatus', 0)
            ->where('products.status', 1)
            ->like('products.name', $search)
            ->get()
            ->getResultArray();
    }

    public function getStoreListingByPro($store_id, $proid = [])
    {
        return $this->db->table('products')
            ->select('products.id as pid,products.name as pname,products.short as pshort,products.url as purl,products.cover as pcover,products.sd_row as sd_row,products.pds as pds,products.pc as pc,product_detail.retail_price_tax,product_detail.retail_price_notax,product_detail.deal_enable,product_detail.final_price,product_detail.zappta_commission,product_detail.deal_final_price,product_detail.outofstockorder,shipping_preference.handlingcharges,shipping_preference.freeshipat,shipping_preference.freeshipatweight')
            ->join('product_detail', 'product_detail.product_id=products.id', 'LEFT')
            ->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT')
            ->whereIn('products.id', $proid)
            ->where('products.store_id', $store_id)
            ->where('products.deleteStatus', 0)
            ->where('products.status', 1)
            ->get()
            ->getResultArray();
    }

    public function getStoreListingByProBySearch($store_id, $search, $proid = [])
    {
        return $this->db->table('products')
            ->select('products.id as pid,products.name as pname,products.short as pshort,products.url as purl,products.cover as pcover,products.sd_row as sd_row,products.pds as pds,products.pc as pc,product_detail.retail_price_tax,product_detail.retail_price_notax,product_detail.deal_enable,product_detail.final_price,product_detail.zappta_commission,product_detail.deal_final_price,product_detail.outofstockorder,shipping_preference.handlingcharges,shipping_preference.freeshipat,shipping_preference.freeshipatweight')
            ->join('product_detail', 'product_detail.product_id=products.id', 'LEFT')
            ->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT')
            ->whereIn('products.id', $proid)
            ->where('products.store_id', $store_id)
            ->where('products.deleteStatus', 0)
            ->where('products.status', 1)
            ->like('products.name', $search)
            ->get()
            ->getResultArray();
    }

    public function getProductByUrl($url, $pc, $sd_row, $pds)
    {
        $sql = $this->db->table('products')
            ->select('products.*, product_detail.*,shipping_preference.handlingcharges,shipping_preference.freeshipat,shipping_preference.freeshipatweight,vendor.store_name as store_name, vendor.store_slug as store_slug,product_category.catid as product_category')
            ->join('product_detail', 'product_detail.product_id=products.id', 'LEFT')
            ->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT')
            ->join('vendor', 'vendor.id=products.store_id', 'LEFT')
            ->join('product_category', 'product_category.product_id=products.id', 'LEFT')
            ->where('products.url', $url)
            ->where('products.pc', $pc)
            ->where('products.sd_row', $sd_row)
            ->where('products.pds', $pds)
            ->where('products.deleteStatus', 0)
            ->get()
            ->getRowArray();
        if (!empty($sql)) {
            $sql['attributes'] = $this->getStoreAttrbute($sql['store_id'], $sql['product_id']);
            $sql['gallery'] = (new \App\Models\ProductsGalleryModel())->getAllById($sql['product_id']);
            return $sql;
        }
        return NULL;
    }

    public function getProductById($id)
    {
        $sql = $this->db->table('products')
            ->select('products.*, product_detail.*,shipping_preference.handlingcharges,shipping_preference.freeshipat,shipping_preference.freeshipatweight,vendor.store_name as store_name, vendor.store_slug as store_slug,product_category.catid as product_category')
            ->join('product_detail', 'product_detail.product_id=products.id', 'LEFT')
            ->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT')
            ->join('vendor', 'vendor.id=products.store_id', 'LEFT')
            ->join('product_category', 'product_category.product_id=products.id', 'LEFT')
            ->where('products.id', $id)
            ->where('products.deleteStatus', 0)
            ->get()
            ->getRowArray();
        if (!empty($sql)) {
            $sql['attributes'] = $this->getStoreAttrbute($sql['store_id'], $sql['product_id']);
            $sql['gallery'] = (new \App\Models\ProductsGalleryModel())->getAllById($sql['product_id']);
            return $sql;
        }
        return NULL;
    }

    private function getStoreAttrbute($store_id, $product_id)
    {
        $result = [];
        $sql = $this->db->table('product_attribute')
            ->select('attributes.name_en as pattr_name,attributes.opt as opt, product_attribute.attr_id as pattr_id')
            ->join('attributes', 'attributes.id=product_attribute.attr_id')
            ->where('product_attribute.product_id', $product_id)
            ->groupBy('product_attribute.attr_id')
            ->get()
            ->getResultArray();
        if (is_array($sql) && count($sql) > 0) {
            foreach ($sql as $q) {
                $result[] = [
                    'attr_id' => $q['pattr_id'],
                    'attribute_name' => $q['pattr_name'],
                    'attr_option' => $q['opt'],
                    'values' => $this->getStoreAttrbuteValues($q['pattr_id'], $product_id)
                ];
            }
        }
        return $result;
    }

    private function getStoreAttrbuteValues($attr_id, $product_id)
    {
        $result = [];
        $sql = $this->db->table('product_attribute')
            ->select('product_attribute.product_id as pidattr,product_attribute.type as pattrtype,product_attribute.attr_id as pattr_id,product_attribute.value_id as pattr_value_id,attributes_value.store_id as sid,attributes_value.name_en as value_name,attributes_value.color_code as color_code,product_attribute.price as price_value,attributes_value.value_img as value_img')
            ->join('attributes_value', 'attributes_value.id=product_attribute.value_id')
            ->where('product_attribute.attr_id', $attr_id)
            ->where('product_attribute.product_id', $product_id)
            // ->groupBy('product_attribute.value_id')
            ->get()
            ->getResultArray();
        if (is_array($sql) && count($sql) > 0) {
            foreach ($sql as $q) {
                $result[] = $q;
            }
        }
        return $result;
    }

    public function getProductByCategory($catid, $limit = 1, $filter = [])
    {
        $limits = $_GET['limit'] ?? ProductsModel::LIMIT;
        $result_limit = 0;
        if ($limit > 1) {
            $result_limit = $limits * ($limit - 1);
        }


        $select_word = 'product_category.catid,
                              products.id as pid,
                              products.name as pname,
                              products.short as pshort,
                              products.url as purl,
                              products.cover as pcover,
                              products.sd_row as sd_row,
                              products.pds as pds,
                              products.pc as pc,
                              product_detail.retail_price_tax,
                              product_detail.retail_price_notax,
                              product_detail.deal_enable,
                              product_detail.final_price,
                              product_detail.zappta_commission,
                              product_detail.deal_final_price,
                              product_detail.outofstockorder,
                              shipping_preference.handlingcharges,
                              shipping_preference.freeshipat,
                              shipping_preference.freeshipatweight';

        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])) {
            $select_word .= ',
                            GROUP_CONCAT(cms_product_attribute.attr_id,"_", cms_product_attribute.value_id,"_",cms_product_attribute.price ) as value_price,
                            GROUP_CONCAT(cms_product_attribute.value_id) as product_id_value_price';
        }

        $sql = $this->db->table('product_category')->select($select_word);
        $sql->join('products', 'products.id=product_category.product_id', 'LEFT');
        $sql->join('product_detail', 'product_detail.product_id=products.id', 'LEFT');
        $sql->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT');

        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])) {
            $sql->join('product_attribute', 'product_attribute.product_id=products.id', 'LEFT');
        }

        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type']) || !empty($filter['p'])) {
            $attr_result = [];

            if (!empty($filter['size'])) {
                $attr_value = explode('|', $filter['size']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        // $attr_result[] = filtreData(my_decrypt($vv));
                        $sql->where("cms_product_attribute.sizes REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 1;
                }
            }

            if (!empty($filter['color'])) {
                $attr_value = explode('|', $filter['color']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.colors REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 2;
                }
            }

            if (!empty($filter['dimension'])) {
                //$attr_result = [];
                $attr_value = explode('|', $filter['dimension']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.dimension REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 3;
                }
            }

            if (!empty($filter['paper_type'])) {
                //$attr_result = [];
                $attr_value = explode('|', $filter['paper_type']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.paper_type REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 4;
                }
            }

            if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])) {
                $sql->whereIn('cms_product_attribute.type', $attr_result);
            }

            if (!empty($filter['p'])) {
                $price = explode('-', filtreData($filter['p']));
                $price_from = filtreData($price[0]);
                $price_end = filtreData($price[1]);
                if (!empty($price) && is_array($price) && end($price) == 'a') {
                    $sql->where('product_detail.final_price >', filtreData($price[0]));
                } else {
                    $sql->where("product_detail.final_price BETWEEN '$price_from' AND '$price_end' ");
                }
            }
        }


        $sql->where('products.deleteStatus', 0);
        if (!empty($filter['b'])) {
            $sql->where('products.brand_id', my_decrypt($filter['b']));
        }
        $sql->where('product_category.catid', $catid);
        if(isset($filter['q']) && !empty($filter['q'])){
            $sql->like('products.name', $filter['q']);
        }
        $sql->groupBy('products.id');
        $sql->limit($limits, $result_limit);
        $q = $sql->get()->getResultArray();
        return $q;
    }

    public function getTotalProductByCategory($catid, $filter = [])
    {
        $sql = $this->db->table('product_category')->select('products.id as pid');
        $sql->join('products', 'products.id=product_category.product_id', 'LEFT');
        $sql->join('product_detail', 'product_detail.product_id=products.id', 'LEFT');
        $sql->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT');

        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])) {
            $sql->join('product_attribute', 'product_attribute.product_id=products.id', 'LEFT');
        }

        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type']) || !empty($filter['p'])) {
            $attr_result = [];

            if (!empty($filter['size'])) {
                $attr_value = explode('|', $filter['size']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        // $attr_result[] = filtreData(my_decrypt($vv));
                        $sql->where("cms_product_attribute.sizes REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 1;
                }
            }

            if (!empty($filter['color'])) {
                $attr_value = explode('|', $filter['color']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.colors REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 2;
                }
            }

            if (!empty($filter['dimension'])) {
                //$attr_result = [];
                $attr_value = explode('|', $filter['dimension']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.dimension REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 3;
                }
            }

            if (!empty($filter['paper_type'])) {
                //$attr_result = [];
                $attr_value = explode('|', $filter['paper_type']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.paper_type REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 4;
                }
            }

            if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])) {
                $sql->whereIn('cms_product_attribute.type', $attr_result);
            }

            if (!empty($filter['p'])) {
                $price = explode('-', filtreData($filter['p']));
                $price_from = filtreData($price[0]);
                $price_end = filtreData($price[1]);
                if (!empty($price) && is_array($price) && end($price) == 'a') {
                    $sql->where('product_detail.final_price >', filtreData($price[0]));
                } else {
                    $sql->where("product_detail.final_price BETWEEN '$price_from' AND '$price_end' ");
                }
            }
        }

        $sql->where('products.deleteStatus', 0);

        $sql->where('products.deleteStatus', 0);
        if (!empty($filter['b'])) {
            $sql->where('products.brand_id', my_decrypt($filter['b']));
        }
        $sql->where('product_category.catid', $catid);
        $sql->groupBy('products.id');
        return $sql->countAllResults();
    }

    public function getAllProductByCategory($limit = 1)
    {
        $limits = 12;
        $result_limit = 0;
        if ($limit > 1) {
            $result_limit = $limits * ($limit - 1);
        }
        $sql = $this->db->table('products')
            ->select('products.id as pid,
                                  products.name as pname,
                                  products.short as pshort,
                                  products.url as purl,
                                  products.cover as pcover,
                                  products.sd_row as sd_row,
                                  products.pds as pds,
                                  products.pc as pc,
                                  product_detail.retail_price_tax,
                                  product_detail.retail_price_notax,
                                  product_detail.deal_enable,
                                  product_detail.final_price,
                                  product_detail.zappta_commission,
                                  product_detail.deal_final_price,
                                  product_detail.outofstockorder,
                                  shipping_preference.handlingcharges,
                                  shipping_preference.freeshipat,
                                  shipping_preference.freeshipatweight,
                                  GROUP_CONCAT(product_attribute.`price`) as `value_price`
                                ')
            ->join('product_detail', 'product_detail.product_id=products.id')
            ->join('product_attribute', 'product_attribute.id=products.id', 'LEFT')
            ->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT')
            ->where('products.deleteStatus', 0)
            ->limit($limits, $result_limit)
            ->get()
            ->getResultArray();
        return $sql;
    }

    public function getAllTotalProductByCategory()
    {
        $sql = $this->db->table('products')
            ->join('product_detail', 'product_detail.product_id=products.id')
            ->where('products.deleteStatus', 0)
            ->countAllResults();
        return $sql;
    }

    /*
    *   get Product By Brands
    */

    public function getProductByBrands($catid, $limit = 1)
    {
        $limits = 12;
        $result_limit = 0;
        if ($limit > 1) {
            $result_limit = $limits * ($limit - 1);
        }
        $sql = $this->db->table('products')
            ->select('products.id as pid,products.name as pname,products.short as pshort,products.url as purl,products.cover as pcover,products.sd_row as sd_row,products.pds as pds,products.pc as pc,product_detail.retail_price_tax,product_detail.retail_price_notax,product_detail.deal_enable,product_detail.final_price,product_detail.zappta_commission,product_detail.deal_final_price,
                              product_detail.outofstockorder, shipping_preference.handlingcharges, shipping_preference.freeshipat, shipping_preference.freeshipatweight ')
            // ->join('products','products.id=product_category.product_id','LEFT')
            ->join('product_detail', 'product_detail.product_id=products.id', 'LEFT')
            ->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT')
            ->where('products.deleteStatus', 0)
            ->where('products.brand_id', $catid)
            ->limit($limits, $result_limit)
            ->get()
            ->getResultArray();
        return $sql;
    }

    public function getTotalProductByBrands($catid)
    {
        $sql = $this->db->table('products')
            ->join('product_detail', 'product_detail.product_id=products.id', 'LEFT')
            ->where('products.deleteStatus', 0)
            ->where('products.brand_id', $catid)
            ->countAllResults();
        return $sql;
    }

    public function getStoreProductByVendors($limit = 1)
    {
        $limits = 10;
        $result_limit = 0;
        if ($limit > 1) {
            $result_limit = $limits * ($limit - 1);
        }
        $sql = $this->db->table('products')
            ->select('products.id as pid,products.cover,products.name as pname,products.reference,products.status as pstatus,product_detail.deal_enable,product_detail.final_price,product_detail.deal_final_price,product_detail.quantity, categories.cat_name')
            ->join('product_detail', 'product_detail.product_id=products.id', 'left')
            ->join('product_category', 'product_category.product_id=products.id', 'left')
            ->join('categories', 'categories.id=product_category.catid', 'left')
            ->where('products.store_id', getVendorUserId())
            ->where('products.deleteStatus', 0)
            ->groupBy('products.id')
            ->limit($limits, $result_limit)
            ->get()
            ->getResultArray();
        return $sql;
    }

    public function getStoreProductByVendorsTotal()
    {
        $sql = $this->db->table('products')
            ->where('products.store_id', getVendorUserId())
            ->groupBy('products.id')
            ->countAllResults();
        return $sql;
    }

    public function getSearchProducts($catid = 0, $word = null, $filter = [], $limit = 1)
    {
        $limits = 12;
        $result_limit = 0;
        if ($limit > 1) {
            $result_limit = $limits * ($limit - 1);
        }

        $select_word = 'products.id as pid,
                          products.name as pname,
                          products.short as pshort,
                          products.url as purl,
                          products.cover as pcover,
                          products.sd_row as sd_row,
                          products.pds as pds,
                          products.pc as pc,
                          product_detail.retail_price_tax,
                          product_detail.retail_price_notax,
                          product_detail.deal_enable,
                          product_detail.final_price,
                          product_detail.zappta_commission,
                          product_detail.deal_final_price,
                          product_detail.outofstockorder,
                          shipping_preference.handlingcharges,
                          shipping_preference.freeshipat,
                          shipping_preference.freeshipatweight';
        if ($catid > 0) {
            $select_word .= ',product_category.catid';
        }
        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])) {
            $select_word .= ',
                            GROUP_CONCAT(cms_product_attribute.attr_id,"_", cms_product_attribute.value_id,"_",cms_product_attribute.price ) as value_price,
                            GROUP_CONCAT(cms_product_attribute.value_id) as product_id_value_price';
        }

        $sql = $this->db->table('products')->select($select_word);

        $sql->join('product_detail', 'product_detail.product_id=products.id', 'LEFT');
        $sql->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT');
        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])) {
            $sql->join('product_attribute', 'product_attribute.product_id=products.id', 'LEFT');
        }

        if ($catid > 0) {
            $sql->join('product_category', 'product_category.product_id=products.id', 'LEFT');
        }

        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type']) || !empty($filter['p'])) {
            $attr_result = [];

            if (!empty($filter['size'])) {
                $attr_value = explode('|', $filter['size']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        // $attr_result[] = filtreData(my_decrypt($vv));
                        $sql->where("cms_product_attribute.sizes REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 1;
                }
            }

            if (!empty($filter['color'])) {
                $attr_value = explode('|', $filter['color']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.colors REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 2;
                }
            }

            if (!empty($filter['dimension'])) {
                //$attr_result = [];
                $attr_value = explode('|', $filter['dimension']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.dimension REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 3;
                }
            }

            if (!empty($filter['paper_type'])) {
                //$attr_result = [];
                $attr_value = explode('|', $filter['paper_type']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.paper_type REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 4;
                }
            }

            if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])) {
                $sql->whereIn('cms_product_attribute.type', $attr_result);
            }

            if (!empty($filter['p'])) {
                $price = explode('-', filtreData($filter['p']));
                $price_from = filtreData($price[0]);
                $price_end = filtreData($price[1]);
                if (!empty($price) && is_array($price) && end($price) == 'a') {
                    $sql->where('product_detail.final_price >', filtreData($price[0]));
                } else {
                    $sql->where("product_detail.final_price BETWEEN '$price_from' AND '$price_end' ");
                }
            }
        }

        if ($catid  > 0) {
            $sql->where('product_category.catid', $catid);
        }

        $sql->where('products.deleteStatus', 0);
        $sql->like('products.name', $word);
        $sql->groupBy('products.id');
        $sql->limit($limits, $result_limit);
        $query = $sql->get()->getResultArray();
        return $query;
    }

    public function getSearchProductsCounts($catid = 0, $word = null, $filter = [])
    {
        $sql = $this->db->table('products')->select('products.id as pid');
        $sql->join('product_detail', 'product_detail.product_id=products.id', 'LEFT');
        $sql->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT');
        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])) {
            $sql->join('product_attribute', 'product_attribute.product_id=products.id', 'LEFT');
        }
        if ($catid > 0) {
            $sql->join('product_category', 'product_category.product_id=products.id', 'LEFT');
        }

        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type']) || !empty($filter['p'])) {
            $attr_result = [];

            if (!empty($filter['size'])) {
                $attr_value = explode('|', $filter['size']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.sizes REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 1;
                }
            }

            if (!empty($filter['color'])) {
                $attr_value = explode('|', $filter['color']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.colors REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 2;
                }
            }

            if (!empty($filter['dimension'])) {
                $attr_value = explode('|', $filter['dimension']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.dimension REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 3;
                }
            }

            if (!empty($filter['paper_type'])) {
                //$attr_result = [];
                $attr_value = explode('|', $filter['paper_type']);
                if (!empty($attr_value) && is_array($attr_value)) {
                    foreach ($attr_value as $vv) {
                        $sql->where("cms_product_attribute.paper_type REGEXP " . filtreData(my_decrypt($vv)));
                    }
                    $attr_result[] = 4;
                }
            }

            if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])) {
                $sql->whereIn('cms_product_attribute.type', $attr_result);
            }

            if (!empty($filter['p'])) {
                $price = explode('-', filtreData($filter['p']));
                $price_from = filtreData($price[0]);
                $price_end = filtreData($price[1]);
                if (!empty($price) && is_array($price) && end($price) == 'a') {
                    $sql->where('product_detail.final_price >', filtreData($price[0]));
                } else {
                    $sql->where("product_detail.final_price BETWEEN '$price_from' AND '$price_end' ");
                }
            }
        }

        if ($catid  > 0) {
            $sql->where('product_category.catid', $catid);
        }

        $sql->where('products.deleteStatus', 0);
        $sql->like('products.name', $word);
        $sql->groupBy('products.id');
        $query = $sql->countAllResults();
        return $query;
    }

    public function updateproattrsss()
    {
        $re = [];
        $sql = $this->db->table('product_attribute')
            ->get()
            ->getResultArray();
        if (is_array($sql) && count($sql) > 0) {
            foreach ($sql as $q) {
                // $attr = (new \App\Models\AttributeModel())->getAttrbuteById($q['attr_id']);
                // $this->upprossattr('type',$attr['opt'],$q['product_id'],$q['attr_id']);
                $re[$q['product_id']][$q['type']][] = $q['value_id'];
            }
        }
        foreach ($re as $rr => $rk) {
            foreach ($rk as $ti => $tt) {
                switch ($ti) {
                    case 1:
                        // code...
                        $this->uppross('sizes', serialize($tt), $rr);
                        break;

                    case 2:
                        // code...
                        $this->uppross('colors', serialize($tt), $rr);
                        break;

                    case 3:
                        // code...
                        $this->uppross('dimension', serialize($tt), $rr);
                        break;

                    default:
                        // code...
                        $this->uppross('paper_type', serialize($tt), $rr);
                        break;
                }
            }
        }
    }

    private function uppross($filename, $sizes, $product_id)
    {
        $this->db->table('product_attribute')
            ->set($filename, $sizes)
            ->where('product_id', $product_id)
            ->update();
        return true;
    }

    private function upprossattr($filename, $sizes, $product_id, $attr_id)
    {
        $this->db->table('product_attribute')
            ->set($filename, $sizes)
            ->where('product_id', $product_id)
            ->where('attr_id', $attr_id)
            ->update();
        return true;
    }

    public function deleteVendorProduct($store_id)
    {
        return $this->db->table($this->table)
            ->set('deleteStatus', 1)
            ->where('store_id', $store_id)
            ->update();
    }

    public function getRelatedCategory($product_id)
    {
        $sql = $this->db->table('product_category')
            ->select('catid')
            ->where('product_id', $product_id)
            ->get()
            ->getRowArray();
        return;
    }

    public function getProductByUrlOnPlay($url)
    {
        $sql = $this->db->table('products')
            ->select('id')
            ->where('url', $url)
            ->get()
            ->getRowArray();
        if (!empty($sql)) {
            return $sql['id'];
        }
        return 0;
    }

    public function getProductVendorById($id)
    {
        $sql = $this->db->table('products')
            ->select('store_id')
            ->where('id', $id)
            ->get()
            ->getRowArray();
        if (!empty($sql)) {
            return $sql['store_id'];
        }
        return 0;
    }

    /*
    *   Get Compaign Products
    */
    public function getCompaignProducts($limit = 4, $status = 'ongoing')
    {
        if ($status == 'ongoing') {

            $sql = $this->db->table('products p')
                ->select('p.id as pid,
                    p.name as pname,
                    p.store_id,
                    p.sd_row,
                    p.pds,
                    p.pc,
                    p.url as purl,
                    p.cover as pcover,
                    pd.final_price,
                    v.store_logo,
                    c.compain_e_date,
                    c.id as com_id
                    ')
                ->join('product_detail pd', 'pd.product_id=p.id')
                ->join('vendor v', 'v.id=p.store_id')
                ->join('products_vendor', 'products_vendor.product_id=p.id')
                ->join('compain c', 'c.id=products_vendor.compaign_id')
                ->where('c.compain_s_date <=', date('Y-m-d'))
                ->where('c.compain_e_date >=', date('Y-m-d'))
                ->where('c.active', 1)
                ->where('c.status', 1)
                ->limit($limit)
                ->get()
                ->getResultArray();
        }

        if ($status == 'upcoming') {
            $sql = $this->db->table('products p')
                ->select('p.id as pid,
                    p.name as pname,
                    p.store_id,
                    p.sd_row,
                    p.pds,
                    p.pc,
                    p.url as purl,
                    p.cover as pcover,
                    pd.final_price,
                    v.store_logo,
                    v.store_slug,
                    c.compain_s_date,
                    c.id as com_id
                    ')
                ->join('product_detail pd', 'pd.product_id=p.id')
                ->join('vendor v', 'v.id=p.store_id')
                ->join('products_vendor', 'products_vendor.product_id=p.id')
                ->join('compain c', 'c.id=products_vendor.compaign_id')
                ->where('c.compain_s_date >=', date('Y-m-d'))
                ->where('c.compain_e_date >=', date('Y-m-d'))
                ->where('c.active', 1)
                ->where('c.status', 1)
                ->limit($limit)
                ->get()
                ->getResultArray();
        }

        return $sql;
    }

    /*
    *   Get All Compaign Products
    */
    public function getAllCompaignProducts($limit = 1)
    {
        $limits = 12;
        $result_limit = 0;
        if ($limit > 1) {
            $result_limit = $limits * ($limit - 1);
        }

        $sql = $this->db->table('products p')
            ->select('p.id as pid,
                                  p.name as pname,
                                  p.store_id,
                                  p.sd_row,
                                  p.pds,
                                  p.pc,
                                  p.url as purl,
                                  p.cover as pcover,
                                  pd.final_price,
                                  v.store_logo,
                                  c.compain_e_date
                                ')
            ->join('product_detail pd', 'pd.product_id=p.id')
            ->join('vendor v', 'v.id=p.store_id')
            ->join('products_vendor', 'products_vendor.product_id=p.id')
            ->join('compain c', 'c.id=products_vendor.compaign_id')
            ->where('c.compain_e_date >=', date('Y-m-d'))
            ->where('c.active', 1)
            ->where('c.status', 2)
            ->limit($limits, $result_limit)
            ->orderBy('products_vendor.product_id DESC')
            ->get()
            ->getResultArray();
        return $sql;
    }

    public function getAllPlayCompaignProducts($product_id)
    {
        $sql = $this->db->table('products p')
            ->select('p.id as pid,
                                  p.name as pname,
                                  p.store_id,
                                  p.sd_row,
                                  p.pds,
                                  p.pc,
                                  p.url as purl,
                                  p.cover as pcover,
                                  pd.final_price,
                                  v.store_logo,
                                  c.compain_e_date
                                ')
            ->join('product_detail pd', 'pd.product_id=p.id')
            ->join('vendor v', 'v.id=p.store_id')
            ->join('products_vendor', 'products_vendor.product_id=p.id')
            ->join('compain c', 'c.id=products_vendor.compaign_id')
            ->where('products_vendor.product_id <>', $product_id)
            ->where('c.compain_e_date >=', date('Y-m-d'))
            ->where('c.active', 1)
            ->where('c.status', 2)
            ->limit(8)
            ->orderBy('products_vendor.product_id DESC')
            ->get()
            ->getResultArray();
        return $sql;
    }


    public function getSinglePlayCompaignProducts($product_id)
    {
        $sql = $this->db->table('products p')
            ->select('p.id as pid,
                                  p.name as pname,
                                  p.store_id,
                                  p.sd_row,
                                  p.pds,
                                  p.pc,
                                  p.url as purl,
                                  p.cover as pcover,
                                  pd.final_price,
                                  v.store_logo,
                                  c.compain_e_date,
                                  c.compain_s_date,
                                  c.id as com_id
                                ')
            ->join('product_detail pd', 'pd.product_id=p.id')
            ->join('vendor v', 'v.id=p.store_id')
            ->join('products_vendor', 'products_vendor.product_id=p.id')
            ->join('compain c', 'c.id=products_vendor.compaign_id')
            ->where('products_vendor.product_id', $product_id)
            ->where('c.compain_e_date >=', date('Y-m-d'))
            ->where('c.active', 1)
            ->where('c.status', 1)
            ->limit(8)
            ->orderBy('products_vendor.product_id DESC')
            ->get()
            ->getRowArray();
        return $sql;
    }

    /*
    *   Get Total Compaign Products
    */
    public function getTotalCompaignProducts()
    {
        $sql = $this->db->table('products p')
            ->select('p.id as pid,
                                  p.name as pname,
                                  p.store_id,
                                  p.sd_row,
                                  p.pds,
                                  p.pc,
                                  p.url as purl,
                                  p.cover as pcover,
                                  pd.final_price,
                                  v.store_logo,
                                  c.compain_e_date
                                ')
            ->join('product_detail pd', 'pd.product_id=p.id')
            ->join('vendor v', 'v.id=p.store_id')
            ->join('products_vendor', 'products_vendor.product_id=p.id')
            ->join('compain c', 'c.id=products_vendor.compaign_id')
            ->where('c.compain_e_date >=', date('Y-m-d'))
            ->where('c.active', 1)
            ->where('c.status', 2)
            ->countAllResults();
        return $sql;
    }

    public function getProductForCommentOrder($product_id)
    {
        $sql = $this->db->table('products p')
            ->select('p.id as pid')
            //->join('product_review pr','pr.product_id=p.id')
            ->join('order_items oi', 'oi.item_id=p.id')
            ->where('oi.user_id', getUserId())
            ->where('oi.item_id', $product_id)
            ->get()
            ->getRowArray();
        if (!empty($sql)) {
            return $sql['pid'];
        }
        return 0;
    }

    public function getProductForComment($product_id)
    {
        $sql = $this->db->table('products p')
            ->select('p.id as pid')
            ->join('product_review pr', 'pr.product_id=p.id')
            ->join('order_items oi', 'oi.item_id=p.id')
            ->where('oi.user_id', getUserId())
            ->where('oi.item_id', $product_id)
            ->get()
            ->getRowArray();
        if (!empty($sql)) {
            return $sql['pid'];
        }
        return 0;
    }


    public function getRelatedProduct($proid = [], $offset = 0)
    {
        $limit = self::LIMIT;
        $products = $this->relatedProductsQuery($proid)
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
        // Check if there are more products after this batch
        $totalCount = $this->relatedProductsQuery($proid)->countAllResults();
        $moreProductsAvailable = $totalCount > $offset + $limit;

        return [
            'products' => $products,
            'moreProductsAvailable' => $moreProductsAvailable,
            'offset' => $offset + $limit
        ];
    }

    private function relatedProductsQuery($proid = []) {
        return $this->db->table('products')
        ->select('products.id as pid,products.name as pname,products.short as pshort,products.url as purl,products.cover as pcover,products.sd_row as sd_row,products.pds as pds,products.pc as pc,product_detail.retail_price_tax,product_detail.retail_price_notax,product_detail.deal_enable,product_detail.final_price,product_detail.zappta_commission,product_detail.deal_final_price,product_detail.outofstockorder,shipping_preference.handlingcharges,shipping_preference.freeshipat,shipping_preference.freeshipatweight')
        ->join('product_detail', 'product_detail.product_id=products.id', 'LEFT')
        ->join('shipping_preference', 'shipping_preference.store_id=products.store_id', 'LEFT')
        ->join('vendor', 'vendor.id=products.store_id', 'LEFT')
        ->where('cms_vendor.status != ', '3')
        ->whereIn('products.id', $proid)
        ->where('products.deleteStatus', 0)
        ->where('products.status', 1);
    }

    public function getTopVendorProduct($id, $limit = 3, $within)
    {
        return $this->db->table('cms_order_items')
            ->select('cms_products.*, COUNT(cms_order_items.item_id) AS products')
            ->join('cms_products', 'cms_order_items.item_id=cms_products.id', 'INNER')
            ->where('cms_order_items.store_id', $id)
            ->where('cms_products.deleteStatus', 0)
            ->where('cms_order_items.created_at between date_sub(now(),INTERVAL 1 ' . $within . ') and now()')
            ->groupBy('cms_order_items.item_id')
            ->orderBy('products DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function addRemoveSpreeProduct($post)
    {
        $spree = $this->db->table('spree')
            ->where([
                'com_id' => $post['com_id'],
                'pid' => $post['pid'],
                'store_id' => $post['store_id'],
                'user_id' => getUserId()
            ])->get()->getResultArray();
        if ($spree) {
            $this->db->table('spree')->where(['id' => $spree[0]['id']])->delete();
            return false;
        } else {
            $this->db->table('spree')->insert($post);
            return true;
        }
    }

    public function fetchSprees($com_id, $store_id)
    {
        return $this->db->table('spree')
            ->select('pid')
            ->where([
                'com_id' => $com_id,
                'store_id' => $store_id,
                'user_id' => getUserId()
            ])->get()->getResultArray();
    }

    public function fetchSpreesDetails($com_id, $store_id)
    {
        return $this->db->table('vendor_sprees')
            ->select('vendor_sprees.price, compain.compain_s_date, compain.compain_e_date')
            ->join('compain', 'vendor_sprees.com_id  = compain.id')
            ->where([
                'vendor_sprees.com_id' => $com_id,
                'vendor_sprees.vendor_id' => $store_id,
            ])->get()->getResultArray();
    }

    public function getUserSprees()
    {
        $this->db->table('spree')
            ->set('is_read', 1)
            ->where('is_read', 0)
            ->update();
        return $this->db->table('spree')
            ->select('products.name, vendor.store_name, vendor.store_slug, compain.compain_name, compain.compain_s_date, compain.compain_e_date, spree.id, product_detail.deal_enable,product_detail.deal_final_price, product_detail.final_price, products.cover, vendor.id as store_id, compain.id AS compain_id')
            ->join('vendor', 'spree.store_id = vendor.id')
            ->join('compain', 'spree.com_id = compain.id')
            ->join('products', 'spree.pid = products.id')
            ->join('product_detail', 'products.id = product_detail.product_id')
            ->where('spree.user_id', getUserId())
            ->where('compain.compain_e_date > ', date('Y-m-d'))
            ->get()
            ->getResultArray();
    }

    public function removeProductFromSpree($id)
    {
        $spree = $this->db->table('spree')
            ->where([
                'id' => $id,
                'user_id' => getUserId()
            ])->get()->getResultArray();
        if ($spree) {
            $this->db->table('spree')->where(['id' => $id])->delete();
            return true;
        }
        return false;
    }

    public function prevSpreeCount($com_id, $store_id)
    {
        $sql = $this->db->table('cms_spree')
            // ->select('SUM(cms_product_detail.deal_final_price) as total')
            ->select('cms_product_detail.deal_final_price, cms_product_detail.final_price, cms_product_detail.deal_enable')
            ->join('cms_product_detail', 'cms_spree.pid = cms_product_detail.product_id')
            ->join('cms_products', 'cms_products.id = cms_spree.pid')
            ->where('cms_spree.user_id', getUserId())
            ->where('cms_spree.com_id', $com_id)
            ->where('cms_spree.store_id', $store_id)
            ->where('cms_products.deleteStatus', 0)
            ->groupBy('cms_spree.com_id')
            ->get()
            ->getResultArray();
        $add = 0;
        foreach ($sql as $key => $value) {
            $add += $value['deal_enable'] ? $value['deal_final_price'] : $value['final_price'];
        }
        return $add;
    }
}

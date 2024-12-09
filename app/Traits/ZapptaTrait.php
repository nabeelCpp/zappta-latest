<?php

namespace App\Traits;

use App\Helpers\ZapptaHelper;
use App\Models\AttributeModel;
use App\Models\BrandModel;
use App\Models\CarriersPreferenceModel;
use App\Models\CategoriesModel;
use App\Models\CompainModel;
use App\Models\VendorModel;
use App\Models\Setting;
use App\Models\ProductsModel;
use App\Models\ReviewModel;
use App\Models\VendorDesignModel;
use App\Models\WishlistModel;
use Config\Pager;

trait ZapptaTrait
{
    /**
     * Home page content
     */
    public function homeTrait()
    {
        $data['homeslider'] = getHeaderSlider();
        $data['categories'] = getHomeCategory();
        $data['store'] = (new VendorModel())->getHomeResult(10);
        // $data['compaign'] = (new ProductsModel())->getCompaignProducts(10);
        $data['globalSettings'] = ZapptaHelper::getGlobalSettings(['company_name', 'frontend_logo']);
        $data['compaign'] = (new VendorModel())->getSpreesToDisplayOngoing(10);
        $data['compaign_upcoming'] = (new VendorModel())->getSpreesToDisplayUpcoming(10);
        $vendor_display_setting = (new Setting())->getThemeVar('vendor_display');
        $vendors_stats = (new VendorModel())->getVendorStats(3, $vendor_display_setting);
        for ($i = 0; $i < count($vendors_stats); $i++) {
            $top_products = (new ProductsModel())->getTopVendorProduct($vendors_stats[$i]['id'], 3, $vendor_display_setting);
            $vendors_stats[$i]['top_products'] = $top_products;
        }
        $data['top_vendors'] = $vendors_stats;
        $data['vendor_display_setting'] = $vendor_display_setting;
        return $data;
    }

    /**
     * Category Trait
     * @param string $slug
     * @return array
     */
    public function categoryTrait($slug): array
    {
        $data['category_id'] = (new CategoriesModel())->getCatIdByUrl(filtreData($slug));
        if(!$data['category_id']) {
            return [];
        }

        $allcat = (new CategoriesModel())->getAllCategoryForTree((int)$data['category_id']['id']);
        if (is_array($allcat) && count($allcat) > 0) {
            $data['allcat'] = $allcat;
        } else {
            $data['allcat'] = (new CategoriesModel())->getAllCategoryForTree();
        }

        foreach ($data['category_id'] as $key => $value) {
            if(isset($data['category_id'][$key]) && $key == 'cat_img') {
                $data['category_id'][$key] = getImageFull('media', $value);
            }
        }

        $size = isset($_GET['size']) ? $_GET['size'] : '';
        $color = isset($_GET['color']) ? $_GET['color'] : '';
        $dimension = isset($_GET['dimension']) ? $_GET['dimension'] : '';
        $paper_type = isset($_GET['paper_type']) ? $_GET['paper_type'] : '';
        $p = isset($_GET['p']) ? $_GET['p'] : '';
        $data['filter'] = isset($_GET) ? $_GET : [];
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['product_limit'] = $_GET['limit'] ?? ProductsModel::LIMIT;

        $data['products'] = $this->wishlistStatusOnProducts((new ProductsModel())->getProductByCategory((int)$data['category_id']['id'], $data['page'], $data['filter']));
        $data['total_products'] = (new ProductsModel())->getTotalProductByCategory((int)$data['category_id']['id'], $data['filter']);
        if ($data['total_products'] >  $data['product_limit']) {
            $data['pager'] = service('pager');
        }
        $data['brands'] = (new BrandModel())->getAllResult((int)$data['category_id']['id']);
        $data['getCatAttr'] = (new AttributeModel())->getCatAttr((int)$data['category_id']['id']);
        $data['meta'] = ZapptaHelper::createMeta($data['page'], $data['total_products'], $data['product_limit']);
        return $data;
    }

    /**
     * Append products data with is_wishlist
     * @param array $products
     * @return array
     * @author M nabeel Arshad
     */
    protected function wishlistStatusOnProducts($products) : array {
        $wishlist = getUserId() > 0 ? (new WishlistModel())->getAllResultByUserId(getUserId()) : [];
        // Extract product_ids from wishlist
        $wishlistProductIds = !empty($wishlist) ? array_column($wishlist, 'product_id') : [];
        foreach ($products as $key => $product) {
            $wish = array_values(array_filter($wishlist, function($w) use ($product) {
                return $product['pid'] == $w['product_id'];
            }));
            if($wish) {
                $wish = $wish[0];
                $products[$key]['is_wishlist'] = true;
                $products[$key]['wishlist_id'] = $wish['id'];
            }else{
                $products[$key]['is_wishlist'] = false;
                $products[$key]['wishlist_id'] = null;
            }
        }
        return $products;
    }

    /**
     * Fetch single store data
     * @param string $slug
     * @return array
     * @author M Nabeel Arshad
     */
    public function storesTrait($slug): array|bool
    {
        $store = (new VendorModel())->findIdByUrl($slug);
        if (!$store) {
            return [];
        }
        $data['store'] = $store;
        $searchq = isset($_GET['searchq']) ? filtreData(urldecode($_GET['searchq'])) : '';
        $cat = isset($_GET['cat']) ? filtreData($_GET['cat']) : '';
        $p_cat = isset($_GET['p']) ? filtreData(my_decrypt($_GET['p'])) : '';
        $data['search_url'] = base_url() . 'stores/' . $slug;
        if (!empty($cat)) {
            $data['search_url'] = base_url() . 'stores/' . $slug . '/?cat=' . $cat . '&p=' . $_GET['p'];
        }
        $data['categories'] = (new CategoriesModel())->getStoreSelectedCat($store['id']);
        if (!empty($cat)) {
            $data['proids'] = (new CategoriesModel())->getStoreProductsByCatId($store['id'], $p_cat);
            $data['vendor_design'] = (new VendorDesignModel())->getVendorDesignById($store['id']);
            $data['pagetitle'] = $store['store_name'];
            if (!empty($store) && !empty($data['proids'])) {
                if (!empty($searchq)) {
                    $data['products'] = $this->wishlistStatusOnProducts((new ProductsModel())->getStoreListingByProBySearch($store['id'], $searchq, $data['proids']));
                } else {
                    $data['products'] = $this->wishlistStatusOnProducts((new ProductsModel())->getStoreListingByPro($store['id'], $data['proids']));
                }
            } else {
                $data['products'] = [];
            }
        } else {
            $data['vendor_design'] = (new VendorDesignModel())->getVendorDesignById($store['id']);
            $data['pagetitle'] = $store['store_name'];
            if (!empty($store)) {
                if (!empty($searchq)) {
                    $data['products'] = $this->wishlistStatusOnProducts((new ProductsModel())->getStoreListingBySearch($store['id'], $searchq));
                } else {
                    $data['products'] = $this->wishlistStatusOnProducts((new ProductsModel())->getStoreListing($store['id']));
                }
            } else {
                $data['products'] = [];
            }
        }

        return $data;
    }
    

    /**
     * Product trait
     * @author M Nabeel Arshad
     * @param
     * @return array
     */
    public function productTrait($url, $pc, $sd_row, $pds) : array {
        $request = request();
        $ReviewModel = new ReviewModel;
        $complete_link = implode('/',$request->getUri()->getSegments()).'?'.http_build_query($_GET);
        if ( getUserId() > 0 ) {
            (new Setting())->insertDollor('ZAPPTA_PRODUCT_VIEW',$complete_link,1);
        }
        $data['single'] = (new ProductsModel())->getProductByUrl($url,$pc,$sd_row,$pds);
        if ( !empty($data['single']) ) {
            $data['proids'] = (new CategoriesModel())->getRelatedCategories($data['single']['product_category'],$data['single']['id']);
            $related = (new ProductsModel())->getRelatedProduct($data['proids']);
            $related['products'] = $this->wishlistStatusOnProducts($related['products']);
            $data['related'] = $related;
            // $data['store'] = $this->db->table('vendor')->where('id', $data['single']['store_id'])->get()->first();
            $data['store'] = (new VendorModel())->findStoreById($data['single']['store_id']);
            $data['single']['cover'] = getImageThumg('products', $data['single']['cover'], 100);
        }
        

        if(isset($data['single']['attributes']) && is_array($data['single']['attributes'])){
            foreach($data['single']['attributes'] as $k => $v) {
                if(isset($data['single']['attributes'][$k]['values']) && is_array($data['single']['attributes'][$k]['values'])){
                    foreach($data['single']['attributes'][$k]['values'] as $kk => $vv) {
                        if(isset($data['single']['attributes'][$k]['values'][$kk]['value_img'])) {
                            $data['single']['attributes'][$k]['values'][$kk]['value_img'] = getImageThumg('products', $data['single']['attributes'][$k]['values'][$kk]['value_img'], 100);
                        } 
                    }
                }
            }
        }
        $data['overal_ratings'] = $ReviewModel->select('AVG(rates) as average_ratings, COUNT(id) as total_reviews')->where(['product_id' => $data['single']['product_id']])->groupBy('product_id')->get()->getRow();
        $data['reviews'] = $ReviewModel->where(['product_id' => $data['single']['product_id']])->limit(5)->orderBy('id', 'DESC')->get()->getResult();
        $data['vendor_preference'] = (new CarriersPreferenceModel())->where(['store_id' => $data['single']['store_id']])->get()->getRow();
        return $data;
    }

    /**
     * Get compaign winners
     */
    public function compaignWinnersTrait()
    {
        $CompainModel = new CompainModel();
        $response['compaigns'] = $CompainModel->getWinnerOfSpree();
        return $response;
    }

    /**
     * Get global search products
     * @param array $get
     * @return array
     * @author M Nabeel Arshad
     */
    public function globalSearchTrait($get)
    {
        $data['searchq'] = isset($get['searchq']) ?( !empty(filtreData(urldecode($get['searchq']))) ? filtreData(urldecode($get['searchq'])) : '') : '';
        $data['search_cat'] = !empty(filtreData(urldecode($get['c']))) ? my_decrypt( filtreData(urldecode($get['c'])) ) : 0;
        $data['filter'] = isset($get) ? $get : [];
        $data['vendors_selected'] = isset($get['v']) && !empty($get['v']) ? explode('|', filtreData($get['v'])) : [];
        $data['filter']['v'] = $data['vendors_selected'];
        $data['page'] = isset($get['page']) ? $get['page'] : 1;
        $data['products'] = $this->wishlistStatusOnProducts((new ProductsModel())->getSearchProducts($data['search_cat'],$data['searchq'],$data['filter'],$data['page']));
        $data['total_products'] = (new ProductsModel())->getSearchProductsCounts($data['search_cat'],$data['searchq'],$data['filter']);
        $data['limit'] = ProductsModel::LIMIT;
        if ( $data['total_products'] > ProductsModel::LIMIT ) {
            $data['pager'] = service('pager');
        }
        $data['meta'] = ZapptaHelper::createMeta($data['page'], $data['total_products'], $data['limit']);
        return $data;
    }

    /**
     * Get compaigns
     * @return array
     */
    public function compaignsTrait()
    {
        $data['compaign'] = (new VendorModel())->getSpreesToDisplayOngoing(10);
        $data['compaign_upcoming'] = (new VendorModel())->getSpreesToDisplayUpcoming(10);
        return $data;
    }

}

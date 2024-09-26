<?php
namespace App\Traits;

use App\Helpers\ZapptaHelper;
use App\Models\AttributeModel;
use App\Models\BrandModel;
use App\Models\CategoriesModel;
use App\Models\VendorModel;
use App\Models\Setting;
use App\Models\ProductsModel;
use Config\Pager;

trait ZapptaTrait
{
    /**
     * Home page content
     */
    public function homeTrait() {
        $data['homeslider'] = getHeaderSlider();
        $data['categories'] = getHomeCategory();
        $data['store'] = (new VendorModel())->getHomeResult(10);
        // $data['compaign'] = (new ProductsModel())->getCompaignProducts(10);
        $data['compaign'] = (new VendorModel())->getSpreesToDisplayOngoing(10);
        $data['compaign_upcoming'] = (new VendorModel())->getSpreesToDisplayUpcoming(10);
        $vendor_display_setting = (new Setting())->getThemeVar('vendor_display');
        $vendors_stats = (new VendorModel())->getVendorStats(3, $vendor_display_setting);
        for ($i=0; $i < count($vendors_stats); $i++) { 
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
    public function categoryTrait($slug) : array {
        $data['category_id'] = (new CategoriesModel())->getCatIdByUrl(filtreData($slug));

        $allcat = (new CategoriesModel())->getAllCategoryForTree((int)$data['category_id']['id']);
        if ( is_array($allcat) && count($allcat) > 0 ) {
            $data['allcat'] = $allcat;
        } else {
            $data['allcat'] = (new CategoriesModel())->getAllCategoryForTree();
        }

        $size = isset($_GET['size']) ? $_GET['size'] : ''; 
        $color = isset($_GET['color']) ? $_GET['color'] : ''; 
        $dimension = isset($_GET['dimension']) ? $_GET['dimension'] : ''; 
        $paper_type = isset($_GET['paper_type']) ? $_GET['paper_type'] : ''; 
        $p = isset($_GET['p']) ? $_GET['p'] : ''; 
        $data['filter'] = isset($_GET) ? $_GET : [];
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['product_limit'] = $_GET['limit'] ?? ProductsModel::LIMIT;

        $data['products'] = (new ProductsModel())->getProductByCategory((int)$data['category_id']['id'],$data['page'],$data['filter']);
        $data['total_products'] = (new ProductsModel())->getTotalProductByCategory((int)$data['category_id']['id'],$data['filter']);
        if ( $data['total_products'] >  $data['product_limit'] ) {
            $data['pager'] = service('pager');
        }
        $data['brands'] = (new BrandModel())->getAllResult((int)$data['category_id']['id']);
        $data['getCatAttr'] = (new AttributeModel())->getCatAttr((int)$data['category_id']['id']);
        $data['meta'] = ZapptaHelper::createMeta($data['page'], $data['total_products'], $data['product_limit']);
        return $data;
    }
}

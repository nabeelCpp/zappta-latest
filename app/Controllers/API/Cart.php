<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Models\ProductsModel;
use App\Traits\CartTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Cart extends BaseController
{
    use CartTrait;

    protected $ProductsModel;

    function __construct() {
        $this->ProductsModel = new ProductsModel();
    }

    public function index()
    {
        $data = get_cart_contents();
        $response = ZapptaHelper::response('Cart contents fetched successfully.', $data);
        return response()->setJSON($response);
    }

    public function add()
    {
        $rules = [
            'pid'    => 'required|numeric',
            'qty' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $id = $this->request->getVar('pid');
        $qty = $this->request->getVar('qty');
        $attr = $this->request->getVar('attr') ?? [];
        $product = (new ProductsModel())->find($id);
        $single = (new ProductsModel())->getProductByUrl($product['url'],$product['pc'],$product['sd_row'],$product['pds']);
        // return response()->setJSON($single);
        if(!$single) {
            return response()->setJSON(ZapptaHelper::response('Product not found!', null, 404));
        }
        if($single['quantity'] < $qty) {
            return response()->setJSON(ZapptaHelper::response('Product out of stock!', null, 404));
        }
        $validateAttr = validate_request_attributes($attr, $single['attributes']);
        if($validateAttr['status'] == false) {
            return response()->setJSON(ZapptaHelper::response($validateAttr['message'], null, 400));
        }else{
            $single['attr'] = $validateAttr['attr'];
        }
        $cart = create_cart_for_api($single, $qty);
        $data = $this->addToCart($cart);
        
        $response = ZapptaHelper::response('Product added to cart successfully.', array_values($data));
        return $this->response->setJSON($response);
    }
}

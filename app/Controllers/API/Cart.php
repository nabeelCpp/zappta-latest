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
        $response = ZapptaHelper::response('Cart contents fetched successfully.', array_values($data));
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
        $options = CartTrait::gatherAttributes($single['attr']);
        
        if(!CartTrait::checkIfQtyInOptAvailable($options, ['product_id' => $id, 'qty' => $qty])) {
            return response()->setJSON(ZapptaHelper::response('Quantity not available', null, 400));
        }
        $cart = create_cart_for_api($single, $qty);
        $data = $this->addToCart($cart);
        
        $response = ZapptaHelper::response('Product added to cart successfully.', array_values($data));
        return $this->response->setJSON($response);
    }

    public function update() {
        $rules = [
            'pid'    => 'required|numeric',
            'qty' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $post = (array) $this->request->getVar();
        $contents = get_cart_contents();
        foreach ($contents as $key => $value) {
            if($value['id'] == $post['pid']) {
                $post['rowid'] = $value['rowid'];
            }
        }
        $post['rowid'] = CartTrait::getRowIdFromContents((int)$post['pid']);
        if(!$post['rowid']) {
            return response()->setJSON(ZapptaHelper::response('Product not found in cart!', null, 404));
        }
        $data = CartTrait::updateCart($post);
        if(!$data['success']) {
            $response = ZapptaHelper::response($data['message'], null, 400);
        }else{
            $response = ZapptaHelper::response($data['message'], array_values(get_cart_contents()));
        }
        return response()->setJSON($response)->setStatusCode($response['code']);
    }

    public function remove() {
        $rules = [
            'pid'    => 'required|numeric',
        ];
        if(!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $post = (array) $this->request->getVar();
        $post['rowid'] = CartTrait::getRowIdFromContents((int)$post['pid']);
        if(!$post['rowid']) {
            return response()->setJSON(ZapptaHelper::response('Product not found in cart!', null, 404));
        }
        $data = CartTrait::removeFromCart($post);
        return response()->setJSON(ZapptaHelper::response($data['message'], get_cart_contents()));
    }
}

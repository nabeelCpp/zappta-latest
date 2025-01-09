<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use App\Libraries\Stripe as LibrariesStripe;
use App\Traits\CartTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Stripe\Stripe;

class Checkout extends BaseController
{
    use CartTrait;

    protected $stripe;

    public function __construct() {
        $this->stripe = new LibrariesStripe;
    }
    
    /**
     * @deprecated @since 2025-01-09
     */
    public function createPaymentIntent()
    {
        $request = request();
        $rules = [
            'amount' => 'required|numeric', // Amount in cents
            'currency' => 'required', // USD, EUR, etc
        ];
        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        Stripe::setApiKey(env('STRIPE_TEST_SERVER'));
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $request->getVar('amount'),
            'currency' => $request->getVar('currency'),
        ]);
        $response = ZapptaHelper::response('Payment intent created successfully!', $paymentIntent);
        return response()->setJSON($response);
    }

    public function checkout() {
        $post = (array) request()->getVar();
        $rules = [
            'shipping_address_id' => 'required|numeric',
            'billing_address_id' => 'required|numeric',
            'gateway' => 'required|in_list[creditcard]',
        ];
        if (!$this->validate($rules)) {
            $response = ZapptaHelper::response("Validation errors!", $this->validator->getErrors(), 400);
            return response()->setJSON($response);
        }
        $post['platform'] = 'App';
        $response = CartTrait::checkoutTrait($post);
        if(!$response['success'] ) {
            return response()->setJSON(ZapptaHelper::response($response['message'], null, 400));
        }
        $order_id = $response['order_id'];
        $resp = $this->stripe->paymentIntent($order_id);
        return response()->setJSON(ZapptaHelper::response('Order drafted successfully! Proceed to payment to complete order.', $resp));
        
    }

    public function stripeWebhook() {
        $this->stripe->
    }


}

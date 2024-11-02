<?php

namespace App\Controllers\API\User;

use App\Controllers\BaseController;
use App\Helpers\ZapptaHelper;
use CodeIgniter\HTTP\ResponseInterface;
use Stripe\Stripe;

class Checkout extends BaseController
{
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
}

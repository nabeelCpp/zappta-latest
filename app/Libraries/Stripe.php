<?php 

namespace App\Libraries;

use App\Helpers\ZapptaHelper;
use App\Models\OrderModel;
use App\Models\RegisterModel;
use App\Traits\ZapptaTrait;

class Stripe {
    use ZapptaTrait;
    protected $stripe, $registerModel;
    public function __construct() {
        // Initialize Stripe
        \Stripe\Stripe::setApiKey(getenv('STRIPE_TEST_SERVER'));
        $this->registerModel = new RegisterModel();
    }

    /**
     * Create a payment intent
     * 
     */
    public function paymentIntent($order_id)
    {
        // Get user email and decrypt order ID
        $user_email = (new RegisterModel())->getByIdResult(getUserId());
        // $order_id = my_decrypt($this->request->getUri()->getSegment(3));
        $ord = (new OrderModel())->getCheckoutUserSingleOrder($order_id);
        $product_total = 0;
        $stripe_customer_id = $user_email['stripe_customer_id'];
        // check if stripe customer id is valid or not
        $stripe_customer_id = self::checkIfStripeCustomerIdIsValid($stripe_customer_id);
        if(!$stripe_customer_id) {
            $user = [
                'email' => $user_email['email'],
                'name' => $user_email['fname'].' '.$user_email['lname'], // Optional
            ];
            $stripe_customer_id = $this->createCustomer($user);
            $this->registerModel->updateCustomer(['stripe_customer_id' => $stripe_customer_id], $user_email['id']);
        }

        // Prepare line items and calculate total amount
        if (is_array($ord) && count($ord) > 0) {
            foreach ($ord['items'] as $od) {
                $price = explode('.', $od['price']);
                $stripe_price = $price[0] . (isset($price[1]) ? str_pad($price[1], 2, '0', STR_PAD_RIGHT) : '00');

                $product_total += $stripe_price * $od['qty'];
            }
        }

        // Calculate shipping amount
        $shipping = explode('.', $ord['order']['shipping']);
        $stripe_shipping = $shipping[0] . (isset($shipping[1]) ? str_pad($shipping[1], 2, '0', STR_PAD_RIGHT) : '00');

        // Total amount
        $total_amount = $product_total + $stripe_shipping;

        // Create PaymentIntent
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $total_amount,
            'currency' => 'usd',
            'customer' => $stripe_customer_id,
            'payment_method_types' => ['card'],
            'description' => 'Order Payment for Order ID: ' . $order_id,
            'metadata' => [
                'order' => json_encode(session()->get('order_metadata')),
                'user_id' => getUserId()
            ],
        ]);

        // Pass the client_secret to the frontend for payment confirmation
        return [
            'client_secret' => $paymentIntent->client_secret,
            'payment_intent_id' => $paymentIntent->id,
            'stripe_publishable_key' => getenv('STRIPE_TEST_PUBLISH_KEY')
        ];
    }

    /**
     * Create stripe customer
     * @param array $user
     * @return mixed
     * @author M Nabeel Arshad
     * @since 2025-01-09
     */
    private function createCustomer($user) : mixed {
        // Create or retrieve a Stripe customer
        $customer = \Stripe\Customer::create($user);
        return $customer->id;
    }

    /**
     * Stripe webhook call
     * @author M Nabeel Arshad
     * @since 2025-01-09
     * @version 1.0.0
     */
    public function webhook() {
        $endpoint_secret = getenv('STRIPE_WEBHOOK_SECRET');
        $payload = file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

        try {
            // Verify the event signature
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

            // Handle the event type
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object; // Contains a StripePaymentIntent
                    $this->handlePaymentSuccess($paymentIntent);
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object; // Contains a StripePaymentIntent
                    $this->handlePaymentFailure($paymentIntent);
                    break;

                case 'payment_intent.processing':
                    $paymentIntent = $event->data->object; // Contains a StripePaymentIntent
                    $this->handlePaymentProcessing($paymentIntent);
                    break;

                default:
                    // Unexpected event type
                    http_response_code(400);
                    exit;
            }

            http_response_code(200); // Acknowledge the event was handled successfully
        } catch (\Exception $e) {
            // Log the error for debugging
            error_log('Webhook Error: ' . $e->getMessage());
            http_response_code(400);
            exit;
        }

    }

    /**
     *  Handle payment success
     * @param object $paymentIntent
     * @return void
     * @since 2025-01-09
     * @version 1.0.0
     * @author M Nabeel Arshad 
     */
    private function handlePaymentSuccess($paymentIntent)
    {
        $order_metadata = isset($paymentIntent->metadata->order) && $paymentIntent->metadata->order ?json_decode($paymentIntent->metadata->order, true) : null;
        $order_id = $order_metadata['order_id'] ?? null;
        $payment_response = serialize($paymentIntent);

        if ($order_id) {
            (new OrderModel())->add([
                'id' => filtreData($order_id),
                'status' => 1,
                'payment_confirmation' => 'succeeded',
                'payment_response' => $payment_response,
            ]);

            (new OrderModel())->updateItemOrderStatus(filtreData($order_id), 1);

            // Optional: Handle metadata (e.g., Zappta coins)
            if (isset($order_metadata['zapptas'])) {
                ZapptaTrait::processZapptaCoins($order_metadata['zapptas'], $order_id);
            }

            // Notify the user
            RegisterModel::notifyUser($order_id, 'Order placed successfully!', 'order-placed', $$paymentIntent->metadata->user_id);
        }else {
            // Log the error for debugging
            error_log('Webhook Error: Order ID not found');
            return response()->setJSON(ZapptaHelper::response('Order ID not found!', null, 200));
        }
    }

    /**
     * Handle payment failure 
     * @param object $paymentIntent
     * @return void
     * @since 2025-01-09
     * @version 1.0.0
     * @author M Nabeel Arshad
     */
    private function handlePaymentFailure($paymentIntent)
    {
        $order_metadata = isset($paymentIntent->metadata->order) && $paymentIntent->metadata->order ?json_decode($paymentIntent->metadata->order, true) : null;
        $order_id = $order_metadata['order_id'] ?? null;
        $payment_response = serialize($paymentIntent);

        if ($order_id) {
            (new OrderModel())->add([
                'id' => filtreData($order_id),
                'status' => 0,
                'payment_confirmation' => 'failed',
                'payment_response' => $payment_response,
            ]);

            (new OrderModel())->updateItemOrderStatus(filtreData($order_id), 0);
            RegisterModel::notifyUser($order_id, 'Your payment failed. Please try again.', 'payment-failed', $paymentIntent->metadata->user_id);
        }else {
            // Log the error for debugging
            error_log('Webhook Error: Order ID not found');
            return response()->setJSON(ZapptaHelper::response('Order ID not found!', null, 200));
        }
    }

    /**
     * Handle payment processing
     * @param object $paymentIntent
     * @return void
     * @since 2025-01-09
     * @version 1.0.0
     * @author M Nabeel Arshad
     */
    private function handlePaymentProcessing($paymentIntent)
    {
        $order_metadata = isset($paymentIntent->metadata->order) && $paymentIntent->metadata->order ?json_decode($paymentIntent->metadata->order, true) : null;
        $order_id = $order_metadata['order_id'] ?? null;
        $payment_response = serialize($paymentIntent);

        if ($order_id) {
            (new OrderModel())->add([
                'id' => filtreData($order_id),
                'status' => 0, // Mark as processing
                'payment_confirmation' => 'processing',
                'payment_response' => $payment_response,
            ]);
        }else {
            // Log the error for debugging
            error_log('Webhook Error: Order ID not found');
            return response()->setJSON(ZapptaHelper::response('Order ID not found!', null, 200));
        }
    }

    /**
     * Check if stripe customer id is valid or not
     * @param string|null $stripe_customer_id
     * @return bool 
     * @since 2025-02-06
     * @version 1.0.0
     * @author M Nabeel Arshad
     */
    public static function checkIfStripeCustomerIdIsValid(?string $stripe_customer_id) : bool {
        try {
            if(!$stripe_customer_id) {
                return false;
            }
            \Stripe\Customer::retrieve($stripe_customer_id);
            return true;
        } catch (\Exception $e) {
            return false;
        }  
    }

}
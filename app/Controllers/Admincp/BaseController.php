<?php


namespace App\Controllers\Admincp;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\Validation\Exceptions\ValidationException;
use Config\Services;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */

    protected $helpers = ['url', 'custom', 'form'];
    public $encrypter;
    public $session;
    public $validate;
    public $cache;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->encrypter = \Config\Services::encrypter();
        $this->session = \Config\Services::session();
        $this->validate = \Config\Services::validation();
        $this->cache = \Config\Services::cache();
        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function getResponse(array $responseBody, int $code = ResponseInterface::HTTP_OK)
    {
        if (empty($responseBody) || $responseBody === NULL || $responseBody == "") {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_CREATED)
                ->setJSON(
                    [
                        'status' => false,
                        'message' => ['success' => 'Result Not found'],
                        'data' => NULL,
                        'code' => ResponseInterface::HTTP_CREATED
                    ]
                );
        } else {
            return $this
                ->response
                ->setStatusCode($code)
                ->setJSON($responseBody);
        }
    }

    public function getRequestInput(IncomingRequest $request)
    {
        $input = $request->getPost() ? $request->getPost() : $request->getGet();
        if (empty($input)) {
            //convert request body to associative array
            $input = json_decode($request->getBody(), true);
        }
        return $input;
    }

    public function validateRequest($input, array $rules, array $messages = [])
    {
        $this->validator = Services::Validation()->setRules($rules);
        // If you replace the $rules array with the name of the group
        if (is_string($rules)) {
            $validation = config('Validation');

            // If the rule wasn't found in the \Config\Validation, we
            // should throw an exception so the developer can find it.
            if (!isset($validation->$rules)) {
                throw ValidationException::forRuleNotFound($rules);
            }

            // If no error message is defined, use the error message in the Config\Validation file
            if (!$messages) {
                $errorName = $rules . '_errors';
                $messages = $validation->$errorName ?? [];
            }

            $rules = $validation->$rules;
        }
        return $this->validator->setRules($rules, $messages)->run($input);
    }
}

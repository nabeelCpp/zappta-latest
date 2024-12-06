<?php

namespace App\Filters;

use App\Helpers\ZapptaHelper;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SetClientAsApi implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        session()->set('is_api', true);
        $authHeader = $request->getHeaderLine('Authorization') ?? null;

        if ($authHeader) {
            // The Authorization header will contain "Bearer token"
            $token = null;
            if (strpos($authHeader, 'Bearer ') === 0) {
                $token = substr($authHeader, 7); // Remove 'Bearer ' from the token
            }
            if ($token) {
                try {
                    $decoded = ZapptaHelper::decodeJwtToken($token);
                    $request->customer = $decoded->customer; // Set customer info to request
                } catch (\Exception $e) {
                    
                }
            }
        }

        

    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}

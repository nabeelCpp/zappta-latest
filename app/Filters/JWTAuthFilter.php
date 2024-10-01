<?php

namespace App\Filters;

use App\Helpers\ZapptaHelper;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader) {
            return Services::response()->setJSON(['message' => 'Unauthorized'])->setStatusCode(401);
        }

        // The Authorization header will contain "Bearer token"
        $token = null;
        if (strpos($authHeader, 'Bearer ') === 0) {
            $token = substr($authHeader, 7); // Remove 'Bearer ' from the token
        }

        if (!$token) {
            return Services::response()->setJSON(['message' => 'Unauthorized'])->setStatusCode(401);
        }

        try {
            $decoded = ZapptaHelper::decodeJwtToken($token);
            $request->customer = $decoded->customer; // Set customer info to request
        } catch (\Exception $e) {
            return Services::response()->setJSON(['message' => $e->getMessage()])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

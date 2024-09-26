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
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (!$token) {
            return Services::response()->setJSON(['message' => 'Unauthorized'])->setStatusCode(401);
        }

        try {
            $decoded = ZapptaHelper::decodeJwtToken($token);
            echo json_encode($decoded);exit;
            $request->customer = $decoded; // Set customer info to request
        } catch (\Exception $e) {
            return Services::response()->setJSON(['message' => 'Unauthorized'])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

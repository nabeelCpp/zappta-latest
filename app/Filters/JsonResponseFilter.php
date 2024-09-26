<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class JsonResponseFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // No changes needed before the request
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Set the Content-Type to application/json for all API responses
        $response->setHeader('Content-Type', 'application/json');
    }
}

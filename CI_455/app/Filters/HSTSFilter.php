<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class HSTSFilter implements FilterInterface
{
    /**
     * Executed before the request is processed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('login_info')) {
            return redirect()->to(base_url('/users/login'));
        }
    }

    /**
     * Executed after the request is processed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('X-Frame-Options', 'DENY')
                 ->setHeader('X-Content-Type-Options', 'nosniff')
                 ->setHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        return $response;
    }
}

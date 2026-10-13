<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Config\Services;

class RateLimiterFilter implements FilterInterface
{
    // Number of allowed requests within the time window
    protected $maxRequests = 100;
    // Time window in seconds (e.g., 1 minute)
    protected $windowTime = 60;

    public function before(RequestInterface $request, $arguments = null)
    {
        // Get the client's IP address
        $ip = $request->getIPAddress();

        // Sanitize the IP address to avoid reserved characters in cache key
        $sanitizedIp = preg_replace('/[^a-zA-Z0-9]/', '_', $ip);

        // Use CodeIgniter's cache service to track the number of requests
        $cache = Services::cache();

        // Define the cache key using the sanitized IP address
        $key = "rate_limit_{$sanitizedIp}";

        // Retrieve the number of requests made by the IP address within the current time window
        $requests = $cache->get($key);

        // If no request data exists for this IP, initialize it
        if (!$requests) {
            $requests = 0;
        }

        // If the number of requests exceeds the maximum allowed, deny further requests
        if ($requests >= $this->maxRequests) {
            return Services::response()->setStatusCode(429, 'Too Many Requests')
                                       ->setBody('Rate limit exceeded. Please try again later.');
        }

        // Increment the request count
        $cache->save($key, $requests + 1, $this->windowTime);

        return true;  // Allow the request to continue
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No need for any processing after the request is processed
        return $response;
    }
}

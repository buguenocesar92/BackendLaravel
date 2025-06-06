<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'timestamp' => now()->toDateTimeString(),
        ];

        Log::info('Request logged', $data);

        return $next($request);
    }

    public function terminate(Request $request, Response $response)
    {
        $data = [
            'status' => $response->getStatusCode(),
            'content' => $response->getContent(),
            'response_time' => microtime(true) - LARAVEL_START,
        ];

        Log::info('Response logged', $data);
    }
}

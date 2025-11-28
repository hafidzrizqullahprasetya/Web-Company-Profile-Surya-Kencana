<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PerformanceOptimization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Optimize query cache for this request
        \DB::enableQueryLog();
        
        $response = $next($request);
        
        // Log query count for debugging
        if (app()->environment('local', 'development')) {
            $queries = \DB::getQueryLog();
            \Log::debug("Query count for " . $request->path() . ": " . count($queries));
        }
        
        return $response;
    }
}
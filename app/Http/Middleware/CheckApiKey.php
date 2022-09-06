<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CheckApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = config('user_api.api_key');
        if ($apiKey != $request->api_key) {
            return Response::json([
                'success'   => false,
                'message'   => "Invalid Key!"
            ]);
        }
        return $next($request);


    }
}

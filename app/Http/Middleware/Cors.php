<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        // return $next($request)
        //   ->header('Access-Control-Allow-Origin','*')
        //   ->header('Access-Control-Allow-Methods','GET, POST, PUT, DELETE, OPTIONS');
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Headers' => 'Content-Type, api_token, Authorization, X-Requested-With',
            'Access-Control-Max-Age' => '86400'
        ];

        if ($request->isMethod('OPTIONS'))
        {   
            return response()->json('{"method": "OPTIONS"}', 200, $headers);
        }

        $response =  $next($request);
        foreach($headers as $key => $value) 
        {
            $response->header($key, $value);
        }
        return $response;
    }
}

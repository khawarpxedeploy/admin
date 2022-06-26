<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiHeaderVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Accept');
        if (!isset($header)) {
            return response()->json(['status' => false, 'message' => "You need to add Accept: application/json in your header!"]);
        }

        if ($header != 'application/json') {
            return response()->json(['status' => false, 'message' => "Required value in Accept Header is application/json!"]);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Http\Controllers\ApiController;
use App\Util\Database;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            ApiController::isApiWorking();
            Database::changeSchema(Auth::user()->api_token);
            return $next($request);
        } catch(ApiException $e) {
            throw $e;
        }
    }
}

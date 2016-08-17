<?php

namespace App\Http\Middleware;

use App\APIKey;
use App\API\ExceptionHandler;

use Closure;

class IncomingAPIMiddleware
{

    private $exception;

    public function __construct(ExceptionHandler $exception)
    {
        $this->exception = $exception;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        

        if(!$request->has('public_key') || !$request->has('secret_key')) {
            $this->exception->auth_req;
        }

        $apiKey = APIKey::wherePublicKey($request->public_key)->whereSecretKey($request->secret_key)->first();
        if(!$apiKey) {
            $this->exception->auth_fail;
        }

        return $next($request);
    }
}

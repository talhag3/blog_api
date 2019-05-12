<?php

namespace App\Http\Middleware;

use Closure;

class Verified
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

        if(isset($request->header()['authorization'])){
            $authorization = $request->header()['authorization'];
            
            $authorization = explode(' ',$authorization[0]);
            
            $auth_type = $authorization[0];
            $api_token = $authorization[1];
            
            $request->me = \App\User::where('api_token','=',$api_token)->first();

            if($request->me){
                return $next($request);
            }
        }

        return [
            'msg'=>"Not Authorized",
            'status'=>401
        ];
    }
}

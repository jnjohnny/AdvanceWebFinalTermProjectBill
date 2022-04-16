<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\token;
class APIAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
     $token = $request->header("Authorization");   
     $check_token=token::where('token',$token)->where('endat',NULL)->first();
     if($check_token)
     {
       return $next($request);
     }
    else { return response("Un Authorized Accessed",401);}
    }
}

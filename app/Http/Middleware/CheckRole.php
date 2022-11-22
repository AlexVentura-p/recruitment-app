<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if(auth()->user()->exists){

            foreach ($roles as $role){
                if (auth()->user()->role->name == $role){
                    return $next($request);
                }
            }

        }

        if (! $request->expectsJson()) {
            abort(ResponseAlias::HTTP_FORBIDDEN);
        }

        return response(['message' => 'Forbidden'],403);
    }
}

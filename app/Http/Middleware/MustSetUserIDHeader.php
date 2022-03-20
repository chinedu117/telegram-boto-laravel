<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;

class MustSetUserIDHeader
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
        if ($request->header("x-user-id") == null) {

            return response()->json(["message" => "User ID required"],403);

        }else {
            
            try{

                $user = new User();
                $user = $user->findOrFai($request->header("x-user-id"));
                $request->merge(['user' => $user ]);

                //add this
                $request->setUserResolver(function () use ($user) {
                    return $user;
                });

            } catch (Exception $e) {
                 
                return response()->json(["message" => "Invalid User ID"],403);
            }
            
        }

        return $next($request);
        
    }
}

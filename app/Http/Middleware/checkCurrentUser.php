<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkCurrentUser
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
        $currUserArr = [];
        $url = $request->getPathInfo();
        $currUser = Auth::user();
        $id = $currUser->id;
        $currUserArr = explode('/', $url);
        if ($currUserArr[2] == $id) {
           return $next($request); 
        } else {
            return redirect()->route('home');
        }
    }
}

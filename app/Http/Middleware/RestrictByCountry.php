<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;

class RestrictByCountry
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
        $ip = $request->ip();
        $country = GeoIP::getLocation($ip)->getAttribute('country');

        if ($ip !== '127.0.0.1' && $country !== 'Israel') {
            abort(403, "Access outside of israel denied, you are located in $country. you can change it in Kernel.php or RestrictByCountry.php");
        }

        return $next($request);
    }
}

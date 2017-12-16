<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Device;
use Hash;

class DeviceSecret
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
        if(($request->input("secret") == null) ||
           (!isset($request->route()->parameters["id"])) ||
           ($request->route()->parameters["id"] == null))
        {
            return response(null, 401);
        }

        $device = Device::find($request->route()->parameters["id"]);
        if(($device == null) ||
           (!Hash::check($request->input("secret"), $device->secret)))
        {
            return response(null, 401);
        }

        return $next($request);
    }
}

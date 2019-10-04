<?php

namespace InWeb\Admin\TranslatablePhrases\Http\Middleware;

use InWeb\Admin\TranslatablePhrases\TranslatablePhrases;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(TranslatablePhrases::class)->authorize($request) ? $next($request) : abort(403);
    }
}

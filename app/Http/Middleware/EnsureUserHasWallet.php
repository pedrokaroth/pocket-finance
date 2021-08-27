<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasWallet
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->user()->hasWallet()) {
            $request->user()->wallets()->create([
                'wallet' => 'Minha Carteira',
                'user_id' => $request->user()->id,
                'free' => true
            ]);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Affiliate;
use Illuminate\Support\Facades\Cookie;

class CaptureReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('ref')) {
            $referralCode = $request->query('ref');

            // Validate referral code exists
            if (Affiliate::where('referral_code', $referralCode)->exists()) {
                // Store in session
                session(['referral_code' => $referralCode]);

                // Store in cookie (30 days)
                Cookie::queue('referral_code', $referralCode, 60 * 24 * 30);
            }
        }

        return $next($request);
    }
}

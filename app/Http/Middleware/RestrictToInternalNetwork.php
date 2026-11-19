<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictToInternalNetwork
{
    protected array $allowedSubnets = [
        '192.168.',
        '10.0.',
        '172.16.',
        '127.0.0.1',
        '::1',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $request->ip();
        $isAllowed = false;

        foreach ($this->allowedSubnets as $subnet) {
            if (str_starts_with($clientIp, $subnet)) {
                $isAllowed = true;
                break;
            }
        }

        if (!$isAllowed) {
            abort(403, 'Akses Ditolak: Sistem HRIS hanya dapat diakses dari jaringan internal atau VPN perusahaan.');
        }

        $response = $next($request);

        // Keamanan HTTP Headers
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}

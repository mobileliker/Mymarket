<?php

namespace app\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'miniapp/login',
        'miniapp/order/pay',
        'miniapp/order',
        'miniapp/order/update',
        'miniapp/order/store',
        'miniapp/order/create',
        'miniapp/address',
        'miniapp/address/update',
        'miniapp/address/store',
        'miniapp/address/create',
    ];
}

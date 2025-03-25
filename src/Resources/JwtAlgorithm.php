<?php

namespace SkyWebDev\Jwt\Resources;

class JwtAlgorithm
{
    const SHA256 = 1;
    const RSA256 = 2;

    const ALGORITHMS = [
        self::SHA256,
        self::RSA256
    ];

    const ALGORITHMS_DATA = [
        self::SHA256 => [
            'alg' => 'HS256',
        ], self::RSA256 => [
            'alg' => 'RS256'
        ]
    ];
}

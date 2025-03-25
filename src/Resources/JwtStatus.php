<?php

namespace SkyWebDev\Jwt\Resources;

class JwtStatus
{
    const TOKEN_STATUS_INVALID = 1;
    const TOKEN_STATUS_EXPIRED = 2;
    const TOKEN_STATUS_OK = 3;

    const TOKEN_STATUSES = [
        self::TOKEN_STATUS_INVALID => 'Token invalid',
        self::TOKEN_STATUS_EXPIRED => 'Token expired',
        self::TOKEN_STATUS_OK => 'Token ok'
    ];
}

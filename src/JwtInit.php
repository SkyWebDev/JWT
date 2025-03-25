<?php

namespace SkyWebDev\Jwt;

use SkyWebDev\Jwt\Lib\Jwt;
use SkyWebDev\Jwt\Lib\JwtRsa;
use SkyWebDev\Jwt\Lib\JwtSha;
use SkyWebDev\Jwt\Resources\JwtAlgorithm;

class JwtInit
{
    /**
     * @throws \Exception
     */
    public static function init(string $secretKey, int $tokenExpire, int $algorithm = JwtAlgorithm::SHA256): Jwt
    {
        if (!in_array($algorithm, JwtAlgorithm::ALGORITHMS)) {
            throw new \Exception($algorithm . ' is not allowed algorithm.');
        }

        return match ($algorithm) {
            JwtAlgorithm::RSA256 => new JwtRsa($secretKey, $tokenExpire),
            default => new JwtSha($secretKey, $tokenExpire),
        };
    }
}

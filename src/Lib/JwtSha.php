<?php

namespace SkyWebDev\Jwt\Lib;

use SkyWebDev\Jwt\Resources\JwtAlgorithm;

class JwtSha extends Jwt
{
    public function __construct(string $secretKey, int $tokenExpire)
    {
        $this->algorithm = JwtAlgorithm::SHA256;
        parent::__construct($secretKey, $tokenExpire);
    }

    protected function generateSignature(): void
    {
        $signature = hash_hmac('sha256', $this->header . "." . $this->payload, $this->secretKey, true);
        $this->signature = $this->encodeParams($signature);
    }
}

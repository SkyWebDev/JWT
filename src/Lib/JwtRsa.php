<?php

namespace SkyWebDev\Jwt\Lib;

use SkyWebDev\Jwt\Resources\JwtAlgorithm;

class JwtRsa extends Jwt
{
    public function __construct(string $secretKey, int $tokenExpire)
    {
        $this->algorithm = JwtAlgorithm::RSA256;
        parent::__construct($secretKey, $tokenExpire);
    }

    /**
     * @throws \Exception
     */
    protected function generateSignature(): void
    {
        if (!file_exists($this->secretKey)) {
            throw new \Exception($this->secretKey . ' does not exists');
        }
        $privateKey = file_get_contents($this->secretKey);
        if (!openssl_pkey_get_private($privateKey)) {
            throw new \Exception('Pem private key is not valid');
        }

        openssl_sign(
            $this->header . "." . $this->payload,
            $signature,
            $privateKey,
            "sha256WithRSAEncryption"
        );
        if (empty($signature)) {
            throw new \Exception('Can not create signature, please check certificate file');
        }

        $this->signature = $this->encodeParams($signature);
    }
}

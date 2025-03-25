<?php

namespace SkyWebDev\Jwt\Lib;

use SkyWebDev\Jwt\Resources\JwtAlgorithm;
use SkyWebDev\Jwt\Resources\JwtStatus;

abstract class Jwt
{
    protected string $secretKey;

    protected int $tokenExpire;

    protected string $header;

    protected string $payload;

    protected string $signature;

    protected string $tokenStatus;

    protected array $payloadData;

    protected int $algorithm;

    public function __construct(string $secretKey, int $tokenExpire)
    {
        $this->secretKey = $secretKey;
        $this->tokenExpire = $tokenExpire;
    }

    public function generateToken($data): string
    {
        $data['exp'] = time() + $this->tokenExpire;
        $this->generateHeader();
        $this->generatePayload($data);
        $this->generateSignature();

        return $this->header . '.' . $this->payload . '.' . $this->signature;
    }

    public function decodeToken($token): void
    {
        $this->tokenStatus = JwtStatus::TOKEN_STATUS_INVALID;
        $token = trim(str_replace('Bearer','', $token));
        $tokenData = explode('.', $token);

        if (count($tokenData) == 3) {
            $this->header = $tokenData[0];
            $this->payload = $tokenData[1];
            $this->generateSignature();

            if (hash_equals($this->signature, $tokenData[2])) {
                $this->tokenStatus = JwtStatus::TOKEN_STATUS_OK;
                $payLoadData = $this->getTokenPayloadData();
                if (isset($payLoadData['exp']) && $payLoadData['exp'] < time()) {
                    $this->tokenStatus = JwtStatus::TOKEN_STATUS_EXPIRED;
                }
            }
        }
    }

    public function getTokenStatus(): string
    {
        return $this->tokenStatus;
    }

    public function getTokenStatusTitle(): string
    {
        $status = JwtStatus::TOKEN_STATUSES[JwtStatus::TOKEN_STATUS_INVALID];

        if (isset(JwtStatus::TOKEN_STATUSES[$this->getTokenStatus()])) {
            $status = JwtStatus::TOKEN_STATUSES[$this->getTokenStatus()];
        }

        return $status;
    }

    public function getTokenPayloadData(): array
    {
        if (empty($this->payloadData)) {
            $this->payloadData = json_decode($this->decodeParams($this->payload), true);
        }

        return $this->payloadData;
    }

    abstract protected function generateSignature(): void;

    protected function generateHeader(): void
    {
        $this->header = $this->encodeParams(json_encode(['typ' => 'JWT', 'alg' => JwtAlgorithm::ALGORITHMS_DATA[$this->algorithm]['alg']]));
    }

    protected function generatePayload($data): void
    {
        $this->payload = $this->encodeParams(json_encode($data));
    }

    protected function encodeParams($data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    protected function decodeParams($data): string
    {
        return base64_decode($data);
    }
}

# JWT

## Introduction

### Installation

```bash
composer require sky-web-dev/jwt
```

### Single Type Use

```php
// Create a token by RSA256 algorithm
$pemKey = 'full-path/private-key.pem';
$time = 60*60; // number of seconds
$jwt = JwtInit::init($pemKey, $time, JwtAlgorithm::RSA256);
$token = $jwt->generateToken(['id' => 22, 'name' => 'John Ben']);

// Create a token by SHA256 algorithm
$time = 60*60; // number of seconds
$secretKey = 'htugjgldiufd';
$jwt = JwtInit::init($secretKey, $time);
$token = $jwt->generateToken(['id' => 22, 'name' => 'John Ben']);

// Decode tokens
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwibmFtZSI6IlBldGFyIiwiZXhwIjoxNzQyODUwNDc2fQ.o5y2tT_TzFuNGMAy3anOxHROmhnXfbtsangECjUbumM';
$time = 60*60; // number of seconds
$secretKey = 'htugjgldiufd';
$jwt = JwtInit::init($secretKey, $time);
$jwt->decodeToken($token);
$status = $jwt->getTokenStatus();
$payload = $jwt->getTokenPayloadData();
```

### Validate token

```php
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwibmFtZSI6IlBldGFyIiwiZXhwIjoxNzQyODUwNDc2fQ.o5y2tT_TzFuNGMAy3anOxHROmhnXfbtsangECjUbumM';
$time = 60*60; // number of seconds
$secretKey = 'htugjgldiufd';
$jwt = JwtInit::init($secretKey, $time);
$jwt->decodeToken($token);
$status = $jwt->getTokenStatus();
if ($status == JwtStatus::TOKEN_STATUS_OK) {
    // Token is valid
}
if ($status == JwtStatus::TOKEN_STATUS_EXPIRED) {
    // Token expired
}
if ($status == JwtStatus::TOKEN_STATUS_INVALID) {
    // Token is invalid
}
```

### Available Algorithms

| Algorithm            | Description                         |
|----------------------|-------------------------------------|
| JwtAlgorithm::SHA256 | Generate JWT using sha256 algorithm |
| JwtAlgorithm::RSA256 | Generate JWT using RSA encryption   |

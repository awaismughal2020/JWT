<?php

error_reporting('1');

require 'vendor/autoload.php';

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;

// Your secret key for encoding and decoding the token
$secretKey = 'your_secret_key';
$keyId = 'your_key_id';

// Sample data to be encoded in the token
$payload = array(
    "user_id" => 123,
    "username" => "john_doe",
    "email" => "john.doe@example.com"
);

// Encode the token
$token = (new Builder())
    ->issuedBy('http://example.com') // Configures the issuer (iss claim)
    ->permittedFor('http://example.org') // Configures the audience (aud claim)
    ->identifiedBy($keyId, true) // Configures the id (jti claim), duplicates allowed
    ->issuedAt(new DateTimeImmutable()) // Configures the time that the token was issued (iat claim)
    ->expiresAt((new DateTimeImmutable())->modify('+1 hour')) // Configures the expiration time of the token (exp claim)
    ->withHeader('kid', $keyId) // Manually set the 'kid' in the header
    ->withClaim('user_data', $payload) // Add custom claims
    ->getToken(new Sha256(), new Lcobucci\JWT\Signer\Key($secretKey)); // Retrieves the generated token

echo "Generated Token: " . $token . "\n\n";

// Decode and verify the token
try {
    $token = (new Parser())->parse((string) $token); // Parses from a string
    $data = new ValidationData();
    $data->setIssuer('http://example.com');
    $data->setAudience('http://example.org');
    $data->setId($keyId);

    $token->validate($data);
    $userDataClaim = $token->getClaim('user_data');

    echo "<pre>";
    var_dump($userDataClaim);
    exit();

} catch (Exception $e) {
    echo "Token verification failed: " . $e->getMessage() . PHP_EOL;
}

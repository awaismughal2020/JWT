<?php

require 'vendor/autoload.php';

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;


$secretKey = '4614ad021dbcd56d288663982869b0e80d4d51c2198d244b00135c55193ad26e';
$keyId = 'deb530687c3c36e0bca3a0265d82385c4e256e159f69774c32e714d9245bd5ff';


$userDetailsTokken = $_POST['token'];
$token = (new Parser())->parse((string) $userDetailsTokken); // Parses from a string
$data = new ValidationData();
$data->setIssuer('http://example.com');
$data->setAudience('http://example.org');
$data->setId($keyId);

$token->validate($data);
$userDetails = $token->getClaim('user_details');
if(is_object($userDetails) && !empty($userDetails)){
    $userDetails = (array)$userDetails;
}

echo "<pre>";
var_dump($userDetails);
exit();

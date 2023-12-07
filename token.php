<?php

require __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;


$key = 'we_hit_those';
$alg = 'HS256';

function create_token( $payload ){
    global $key, $alg;

    $jwt = JWT::encode($payload, $key, $alg);

    return $jwt;
}

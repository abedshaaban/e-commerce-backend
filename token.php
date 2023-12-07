<?php

require __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


$key = 'we_hit_those';
$alg = 'HS256';

function create_token( $payload ){
    global $key, $alg;

    $jwt = JWT::encode($payload, $key, $alg);

    return $jwt;
}

function get_token(){
    $headers = getallheaders();

    if (!isset($headers['Authorization']) || empty($headers['Authorization'])) {
        http_response_code(401);
        echo 'Authorization header not found in request';
        exit;
    }

    if (! preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
        echo 'Token not found in request';
        exit;
    }

    $jwt = explode(" ", $headers['Authorization'])[1];

    return $jwt;
}

function decode_token(){
    global $key, $alg, $mysqli;
    $decoded_res = [];
    $token = get_token();

    try {
        $jwt_val = JWT::decode($token, new Key( $key, $alg));
        $decoded_res["status"] = true;
        $decoded_res["error"] = null;
        $decoded_res["payload"] = $jwt_val;

    } catch (Exception $e) {
        $decoded_res["status"] = false;
        $decoded_res["payload"] = null;
        $decoded_res["error"]=  $e->getMessage();
    }

    return $decoded_res;
}

function user_role(){
    global $key, $alg, $mysqli;
    $decoded_res = decode_token();
    $response = [];
    
    if ( $decoded_res["status"] === false ){
        $response["status"] = false;
        $response["data"] = null;
        $response["error"] = $decoded_res["error"];
    } else {
        $q= $mysqli->prepare("
            select  u.uuid, u.email, u.password, r.role
            from users u 
            join roles r on  u.role = r.role_id
            where email = ?
        ");
        $q->bind_param("s", $decoded_res["payload"]->email);
        $q->execute();
        $q->store_result();
        $q->bind_result(
            $uuid,
            $email,
            $hash_pwd,
            $role,
        );
        $q->fetch();

        $q_rows = $q->num_rows;
        $response = [];

        if ($q_rows === 0) {
            $response["status"] = false;
            $response["data"] = null;
            $response["error"] = "invalid token.";
            
        } else {
            if($uuid === $decoded_res["payload"]->uuid){
                $response["status"] = true;
                $response["error"] = null;
                $response["data"]["role"] = $role;
    
            } else {
                $response["status"] = false;
                $response["data"] = null;
                $response["error"] = "incorrect credentials no user found.";
            }
        }
    }

    return $response;
}
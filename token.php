<?php

include("./connection.php");
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

function user_role( $token ){
    global $key, $alg, $mysqli;
    $response = [];

    try {
        $jwt_val = JWT::decode($token, new Key( $key, $alg));
        $decoded_res = [];
        $decoded_res["status"] = true;
        $decoded_res["error"] = null;
        $decoded_res["payload"] = $jwt_val;

    } catch (Exception $e) {
        $decoded_res["status"] = false;
        $decoded_res["payload"] = null;
        $decoded_res["error"]=  $e->getMessage();
    }

    if ( $decoded_res["status"] == false ){
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
        $q->bind_param("s", $email);
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

        if ($q_rows == 0) {
            $response["status"] = false;
            $response["data"] = null;
            $response["error"] = "invalid token.";
            
        } else {
            if($decoded_res["data"]->pwd === $hash_pwd &&
             $uuid === $decoded_res["data"]->uuid){
                $response["status"] = true;
                $response["data"]["role"] = $role;
    
            } else {
                $response["status"] = false;
                $response["error"] = "incorrect credentials no user found.";
            }
        }
    }

    return $response;
}
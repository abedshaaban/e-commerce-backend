<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";



$body = get_body();
$decoded_token = decode_token();
$user = user_role();

$f_name = $body["first_name"];
$l_name = $body["last_name"];
$uuid = $decoded_token["payload"]->uuid;
$response = [];


if ($user["status"] === false) {
    $response["status"] = false;
    $response["data"] = null;
    $response["error"]= "user not found";

} else {
    $response["status"] = true;
    $response["error"]= null;
    $response["data"] = null;

    $q = $mysqli->prepare("
        UPDATE
            users
        SET
            first_name = ?,
            last_name = ?
        WHERE 
            uuid = ?
    ");

    $q->bind_param(
        "sss",
        $f_name,
        $l_name,
        $uuid
    );
    $q->execute();

}


echo json_encode($response);


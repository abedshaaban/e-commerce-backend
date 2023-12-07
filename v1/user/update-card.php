<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";


$body = get_body();
$decoded_token = decode_token();
$user = user_role();

$holder_name = $body["holder_name"];
$card_name = $body["card_name"];
$month = $body["month"];
$year = $body["year"];
$code = $body["code"];
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
            cards
        SET
            holder_name = ?,
            card_name = ?,
            month = ?,
            year = ?,
            code = ?
        WHERE 
            user_id = ?
    ");

    $q->bind_param(
        "sssiis",
        $holder_name,
        $card_name,
        $month,
        $year,
        $code,
        $uuid
    );
    $q->execute();

}

echo json_encode($response);
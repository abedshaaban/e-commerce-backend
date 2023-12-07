<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";


$body = get_body();
$decoded_token = decode_token();
$user = user_role();

$country = $body["country"];
$city = $body["city"];
$phone_number = $body["phone_number"];
$zip_code = $body["zip_code"];
$address_one = $body["address_one"];
$address_two = $body["address_two"];
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
            address
        SET
            country = ?,
            city = ?,
            phone_number = ?,
            zip_code = ?,
            address_one = ?,
            address_two = ?
        WHERE 
            user_id = ?
    ");

    $q->bind_param(
        "sssssss",
        $country,
        $city,
        $phone_number,
        $zip_code,
        $address_one,
        $address_two,
        $uuid
    );
    $q->execute();

}

echo json_encode($response);
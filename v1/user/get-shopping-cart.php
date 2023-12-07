<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";


$body = get_body();
$decoded_token = decode_token();

$uuid = $decoded_token["payload"]->uuid;
$response = [];

$q = $mysqli->prepare("
    select
        *
    from 
        shopping_carts
    where
        user_id = ?
");

$q->bind_param(
    "s",
    $uuid,
);
$result = $q->get_result();

$all_rows = [];

while ($row = $result->fetch_assoc()) {
    $response["data"][] = $row;
}

$response["status"] = true;
$response["error"]= null;
$response["data"] = $all_rows;

echo json_encode($response);
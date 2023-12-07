<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";


$body = get_body();
$decoded_token = decode_token();

$poduct_id = $body["product_id"];
$uuid = $decoded_token["payload"]->uuid;
$response = [];

$q = $mysqli->prepare("
    DELETE FROM shopping_carts
    WHERE
        product_id = ? and user_id = ?
");

$q->bind_param(
    "ss",
    $poduct_id,
    $uuid,
);
$q->execute();

$response["status"] = true;
$response["error"]= null;
$response["data"] = null;

echo json_encode($response);
<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";


$body = get_body();
$decoded_token = decode_token();

$poduct_id = $body["product_id"];
$quantity = $body["quantity"];
$uuid = $decoded_token["payload"]->uuid;
$response = [];

$q = $mysqli->prepare("
    insert into
        shopping_carts (user_id, product_id, quantity)
    values
        (?, ?, ?)
");

$q->bind_param(
    "ssi",
    $uuid,
    $poduct_id,
    $quantity,
);
$q->execute();

$response["status"] = true;
$response["error"]= null;
$response["data"] = null;

echo json_encode($response);
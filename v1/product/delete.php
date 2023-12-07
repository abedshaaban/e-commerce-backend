<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";


$body = get_body();
$decoded_token = decode_token();
$user = user_role();

$poduct_id = $body["product_id"];
$uuid = $decoded_token["payload"]->uuid;
$response = [];

if ($user["status"] === false) {
    $response["status"] = false;
    $response["data"] = null;
    $response["error"]= "user not found";

} else {

    if ($user["data"]["role"] !== 'seller' && $user["data"]["role"] !== 'admin') {
        $response["status"] = false;
        $response["data"] = null;
        $response["error"]= "user is not authorized";

        echo json_encode($response);
        exit;
    }

    $q = $mysqli->prepare("
        DELETE FROM products
        WHERE
            id = ? and owner_id = ?
    ");

    $q->bind_param(
        "ss",
        $poduct_id,
        $uuid,
    );
    $q->execute();

    $response["status"] = true;
    $response["error"]= null;
    $response["data"] = $all_rows;
}

echo json_encode($response);
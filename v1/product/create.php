<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";


$body = get_body();
$decoded_token = decode_token();
$user = user_role();

$poduct_id = UUID();
$name = $body["name"];
$description = $body["description"];
$price = $body["price"];
$quantity = $body["quantity"];
$img_url = $body["img_url"];
$owner_id = $decoded_token["payload"]->uuid;
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

    $response["status"] = true;
    $response["error"]= null;
    $response["data"] = null;

    $q = $mysqli->prepare("
        insert into
            products (id, name, description, price, quantity, img_url, owner_id)
        values
            (?, ?, ?, ?, ?, ?, ?)
    ");

    $q->bind_param(
        "sssiiss",
        $poduct_id,
        $name,
        $description,
        $price,
        $quantity,
        $img_url,
        $owner_id,
    );
    $q->execute();

}

echo json_encode($response);
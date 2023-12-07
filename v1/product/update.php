<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";


$body = get_body();
$decoded_token = decode_token();
$user = user_role();

$poduct_id = $body["product_id"];
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

    if ($user["data"]["role"] === 'user') {
        $response["status"] = false;
        $response["data"] = null;
        $response["error"]= "user is not authorized";

        echo json_encode($response);
        exit;
    }

    if ($user["data"]["role"] === 'seller'){
        $q = $mysqli->prepare("
            update 
                products
            set
                name = ?,
                description = ?,
                price = ?,
                quantity = ?,
                img_url = ?
            where
                id = ? and owner_id = ?
        ");

        $q->bind_param(
            "ssiisss",
            $name,
            $description,
            $price,
            $quantity,
            $img_url,
            $poduct_id,
            $owner_id
        );

    } else if ($user["data"]["role"] === 'admin') {
        $q = $mysqli->prepare("
        update 
            products
        set
            name = ?,
            description = ?,
            price = ?,
            quantity = ?,
            img_url = ?
        where
            id = ?
        ");

        $q->bind_param(
            "ssiiss",
            $name,
            $description,
            $price,
            $quantity,
            $img_url,
            $poduct_id,
        );
    }
    
    $q->execute();
    $response["status"] = true;
    $response["error"]= null;
    $response["data"] = null;
}

echo json_encode($response);
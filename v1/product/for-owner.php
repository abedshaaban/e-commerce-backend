<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";


$decoded_token = decode_token();
$user = user_role();

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

    $q = $mysqli->prepare("
        select
            p.id, p.name, p.description, p.price, p.quantity, p.img_url
        from 
            products p
        join users u on p.owner_id = u.uuid
        where
            u.uuid = ?
    ");

    $q->bind_param(
        "s",
        $owner_id
    );
    $q->execute();
    $result = $q->get_result();

    $all_rows = [];

    while ($row = $result->fetch_assoc()) {
        $response["data"][] = $row;
    }

    $response["status"] = true;
    $response["error"]= null;
    $response["data"] = $all_rows;
}

echo json_encode($response);
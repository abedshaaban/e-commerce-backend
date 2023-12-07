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
        u.email, u.first_name, u.last_name, 
        r.role,
        a.country, a.city, a.phone_number, a.zip_code, a.address_one, a.address_two,
        c.holder_name, c.card_name
    from users u 

    join roles r on  r.role_id = u.role 
    join address a on  a.user_id = u.uuid
    join cards c on  c.user_id = u.uuid

    WHERE 
        uuid = ?
");

$q->bind_param(
    "s",
    $uuid
);
$q->execute();
$result = $q->get_result();

$response["status"] = true;
$response["error"]= null;
$response["data"] = $result->fetch_assoc();

echo json_encode($response);
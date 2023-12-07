<?php

include(__DIR__ . "/../../connection.php");
require __DIR__ . "/../../utils.php";
require __DIR__ . "/../../token.php";


$response = [];

$q = $mysqli->prepare("
    select
        id, name, description, price, quantity, img_url
    from 
        products
");
$q->execute();
$result = $q->get_result();

$all_rows = [];

while ($row = $result->fetch_assoc()) {
    $response["data"][] = $row;
}

$response["status"] = true;
$response["error"]= null;
$response["data"] = $all_rows;


echo json_encode($response);
<?php

include("./connection.php");
require __DIR__ . '/utils.php';


$body = get_body();

$f_name = $body["f_name"];
$l_name = $body["l_name"];
$email = $body["email"];
$pwd = $body["password"];
$hash_pwd = password_hash($pwd, PASSWORD_DEFAULT);
$uuid = UUID();

$q = $mysqli->prepare("
    insert into users 
    (uuid, first_name, last_name, email, password) 
    values (?, ?, ?, ?, ?)
");
$q->bind_param("sssss", $uuid, $f_name, $l_name, $email, $hash_pwd);
$q->execute();

$response = [];

$response["status"] = true;
$response["data"] = null;
$response["error"] = null;

echo json_encode($response);
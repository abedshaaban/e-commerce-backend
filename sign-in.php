<?php

include("./connection.php");
require __DIR__ . '/utils.php';


$body = get_body();

$email = $body["email"];
$pwd = $body["password"];
 

$q= $mysqli->prepare("
    select  u.uuid, u.email, u.password, u.first_name, u.last_name, r.role
    from users u 
    join roles r on  u.role = r.role_id
    where email = ?
");
$q->bind_param("s", $email);
$q->execute();
$q->store_result();
$q->bind_result(
    $uuid,
    $email,
    $hash_pwd,
    $f_name,
    $l_name,
    $role,
);
$q->fetch();

$q_rows = $q->num_rows;
$response = [];

// $response['status'] = true;
// $response['data'] = null;
// $response['error'] = null;

if ($q_rows == 0) {
    $response["status"] = false;
    $response["status"] = null;
    $response["error"] = "incorrect credentials no user found.";

    
} else {
    if(password_verify($pwd, $hash_pwd,)){
        $response["status"] = true;
        $response["error"] = null;
        $response["data"]["email"] = $email;
        $response["data"]["first_name"] = $f_name;
        $response["data"]["last_name"] = $l_name;
        $response["data"]["privilege"] = $role;

    } else {
        $response["status"] = false;
        $response["status"] = null;
        $response["error"] = "incorrect credentials no user found.";
    }
}

echo json_encode($response);
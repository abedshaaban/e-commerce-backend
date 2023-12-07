<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

$host = "localhost";
$db_user = "root";
$db_pass = null;
$db_name = "e-commerce-store";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("" . $mysqli->connect_error);
}
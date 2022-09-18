<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');

//connect to database
include("connection.php");

//needed variables
$user1 = $_POST["user1"];
$user2 = $_POST["user2"];

// adding block relation to database
$queryText1 = "INSERT  INTO blocks (blocker,blocked) VALUE (?,?)";
$query1 = $mysqli->prepare($queryText1);
$query1->bind_param("ss", $user1, $user2);
$query1->execute();
$response1["success"] = true;
echo json_encode($response1);

<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');

//connect to database
include("connection.php");

//needed variables
$user_id = $_POST["id"];
$tweet_text = $_POST["tweet_text"];
if (isset($_POST["tweet_images"])) {
    $tweet_images[] = $_POST["tweet_images"];
};
$tweet_id = 0;
$counter = 1;

// adding tweet to database
$queryText1 = "INSERT  INTO tweets (tweet_text , users_id) VALUE (?,?)";
$query1 = $mysqli->prepare($queryText1);
$query1->bind_param("ss", $tweet_text, $user_id);
$query1->execute();
$response1["success"] = true;
echo json_encode($response1);

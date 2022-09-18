<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
//connect to database
include("connection.php");

//needed variables
$tweet_id = $_POST["tweet_id"];

//count likes
$queryText = "SELECT count(user_id) FROM likes where tweet_id=?";
$query = $mysqli->prepare($queryText);
$query->bind_param("s", $tweet_id);
$query->execute();
$array = $query->get_result();

$response = [];
while ($a = $array->fetch_assoc()) {
    $response[] = $a;
}

$json = json_encode($response);
echo $json;

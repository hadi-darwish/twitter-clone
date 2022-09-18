<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
//connect to database
include("connection.php");

//needed variables
$user_id = $_POST["user_id"];


//show all tweets of followings of client
$queryText = "(SELECT s.* FROM tweets s left join follows j on j.follower = s.users_id) ";
$query = $mysqli->prepare($queryText);
$query->execute();
$array = $query->get_result();

$response = [];
while ($a = $array->fetch_assoc()) {
    $response[] = $a;
}

$json = json_encode($response);
echo $json;

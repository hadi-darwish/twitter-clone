<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
//connect to database
include("connection.php");

//needed variables
$user_id = $_POST["user_id"];


//show all tweets of followings of client
$queryText = "(SELECT s.* FROM tweets s left join follows j on s.users_id = j.followed and  j.follower = ?
where s.users_id not in (select blocked from blocks where blocker = ?)) ";
$query = $mysqli->prepare($queryText);
$query->bind_param("ss", $user_id, $user_id);
$query->execute();
$array = $query->get_result();

$response = [];
while ($a = $array->fetch_assoc()) {
    $response[] = $a;
}

$json = json_encode($response);
echo $json;

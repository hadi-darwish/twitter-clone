<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');

//connect to database
include("connection.php");

//needed variables
$tweet_id = $_POST["tweet_id"];
//deleting likes of tweet if existed
$queryText1 = "DELETE FROM likes where tweet_id=?";
$query1 = $mysqli->prepare($queryText1);
$query1->bind_param("s", $tweet_id);
$query1->execute();
$response1["success"] = true;
echo json_encode($response1);

//deleting images from server of tweet if existed
$queryText = "SELECT image_url FROM images where tweets_id=?";
$query = $mysqli->prepare($queryText);
$query->bind_param("s", $tweet_id);
$query->execute();
$array = $query->get_result();
$response = [];
while ($c = $array->fetch_assoc()) {
    $response[] = $c;
    if ($c != "") {
        unlink($c["image_url"]);
    }
}

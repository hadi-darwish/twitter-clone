<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');

//connect to database
include("connection.php");

//variables needed
// // $location = $_POST["location"];
// // $bio = $_POST["bio"];
$name = $_POST["name"];
$email = $_POST["email"];
$password = hash("sha256", $_POST["password"]);
$dob = $_POST["date"];
$username = "$name";
$prof_image = $_POST["profile_image"];
$banner_image = $_POST["banner_image"];

//Start Logic 1
// here iama giving a uniqe defualt username to the client
//by searching all usernames in the database
$queryText = "SELECT user_name from users";
$query = $mysqli->prepare($queryText);
$query->execute();
$array = $query->get_result();

$response = [];
$usernames = [];

while ($a = $array->fetch_assoc()) {
    $response[] = $a;
}

foreach ($response as $b) {
    $usernames[] = $b;
    foreach ($b as $s) {
        if ($username == $s) {
            $username = "$name" . rand(1, 1000);
        }
    }
}
//End Logic 1

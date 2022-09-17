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

//Start Logic 2
//here we are checking if the email used before or not
//and if it is used it will exit the code with email used response
$queryText2 = "SELECT email from users";
$query2 = $mysqli->prepare($queryText2);
$query2->execute();
$array2 = $query2->get_result();

$response2 = [];
$emails = [];

while ($c = $array2->fetch_assoc()) {
    $response2[] = $c;
}

foreach ($response2 as $d) {
    $emails[] = $d;
    foreach ($d as $t) {
        if ($email == $t) {
            echo json_encode("email used");
            exit;
        }
    }
}
//End Logic 2

//adding data to database
$queryText1 = "INSERT  INTO users (user_name,name,email, password,date_of_birth) VALUE (?,?,?,?,?)";
$query1 = $mysqli->prepare($queryText1);
$query1->bind_param("sssss", $username, $name, $email, $password, $dob);
$query1->execute();
$response1["success"] = true;
echo json_encode($response1);

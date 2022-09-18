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

//start
//getting the id to name image files
$queryText3 = "SELECT id FROM users WHERE email = ?";
$query3 = $mysqli->prepare($queryText3);
$query3->bind_param("s", $email);
$query3->execute();
$array3 = $query3->get_result();


$response3 = [];
while ($c = $array3->fetch_assoc()) {
    $response3[] = $c;
}
//end

//start logic3
//here we convert the base64 string to normal image form 
//and saving it as profile image
if ($prof_image != "") {
    $fullImage = base64_decode($prof_image);
    $size = getImageSizeFromString($fullImage);
    if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
        die('Base64 value is not a valid image');
    }
    $ext = substr($size['mime'], 6);
    $img_file = "images/profile/prof_{$response3[0]["id"]}.{$ext}";
    file_put_contents($img_file, $fullImage);
    //updating data of user by adding both profile image url to database
    $queryText5 = "UPDATE users set  profile_image =? where email = ?";
    $query5 = $mysqli->prepare($queryText5);
    $query5->bind_param("ss",  $img_file, $email);
    $query5->execute();
    $response5["success"] = true;
    echo json_encode($response5);
}
//end logic3

//start logic4
//here we convert the base64 string to normal image form 
//and saving it as banner image
if ($banner_image != "") {
    $fullImage2 = base64_decode($banner_image);
    $size2 = getImageSizeFromString($fullImage2);
    if (empty($size2['mime']) || strpos($size2['mime'], 'image/') !== 0) {
        die('Base64 value is not a valid image');
    }
    $ext = substr($size['mime'], 6);
    $img_file2 = "images/banner/banner_{$response3[0]["id"]}.{$ext}";
    file_put_contents($img_file2, $fullImage2);
    //updating data of user by adding both banner image url to database
    $queryText4 = "UPDATE users set  banner_image =? where email = ?";
    $query4 = $mysqli->prepare($queryText4);
    $query4->bind_param("ss",  $img_file2, $email);
    $query4->execute();
    $response4["success"] = true;
    echo json_encode($response4);
}
//end logic4

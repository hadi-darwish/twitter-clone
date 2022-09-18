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

//selecting this tweet id
$queryText = " SELECT MAX( id ) FROM tweets;";
$query = $mysqli->prepare($queryText);
$query->execute();
$array = $query->get_result();
$response = [];
while ($c = $array->fetch_assoc()) {
    $response[] = $c;
}
$tweet_id = ($response[0]["MAX( id )"]);

//adding images of tweet to database
foreach ($tweet_images[0] as $a) {
    if ($a != "") {
        //converting images from base64 to normal 
        $fullImage = base64_decode($a);
        $size = getImageSizeFromString($fullImage);
        if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
            die('Base64 value is not a valid image');
        }
        $ext = substr($size['mime'], 6);
        $img_file = "images/tweets/tweet_{$tweet_id}_{$counter}.{$ext}";
        file_put_contents($img_file, $fullImage);
        //incrementing counter to index the images according to tweet id
        $counter++;
        //adding images to database and saving to server
        $queryText2 = "INSERT  INTO images (image_url , tweets_id) VALUE (?,?)";
        $query2 = $mysqli->prepare($queryText2);
        $query2->bind_param("ss", $img_file, $tweet_id);
        $query2->execute();
        $response2["success"] = true;
        echo json_encode($response2);
    }
}

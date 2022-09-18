<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
//connect to database
include("connection.php");
//converting taken password to sha256 hash to compare later with database
$password = hash("sha256", $_POST["password"]);
$email = $_POST["email"];
$id = 0;

//query to found if email exist in the database or not
$queryText = "SELECT email, password,id FROM users WHERE email = ?";
$query = $mysqli->prepare($queryText);
$query->bind_param("s", $email);
$query->execute();


if (!$query) {
    echo 'Could not run query: ' . mysqli_error($mysqli);
    exit;
}
$array = $query->get_result();
$rowcount = mysqli_num_rows($array);

if ($rowcount == 1) {
    $row = $array->fetch_row();
    //comparing password with the one in the database
    if ($row[1] == $password) {
        $id = $row[2];
        $confirm =  True;
    } else {
        $confirm = FALSE;
    }
} else {
    //email not found
    $confirm = "not found";
}

$results = [
    "id" => $id,
    "email" => $email,
    "confirmation" => $confirm,
];
echo json_encode($results);

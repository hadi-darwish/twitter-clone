<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
//connect to database
include("connection.php");
//converting taken password to sha256 hash to compare later with database
$password = hash("sha256", $_POST["password"]);
$email = $_POST["email"];

//query to found if email exist in the database or not
$queryText = "SELECT email, password FROM users WHERE email = ?";
$query = $mysqli->prepare($queryText);
$query->bind_param("s", $email);
$query->execute();

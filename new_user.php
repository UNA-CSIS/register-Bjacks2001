<?php
// session start here...
session_start();
include_once 'validate.php';

// get all 3 strings from the form (and scrub w/ validation function)

$user = test_input($_POST["user"]);
$pass = test_input($_POST["pwd"]);
$pass_check = test_input($_POST["repeat"]);

// make sure that the two password values match!

if ($pass != $pass_check) {
    $_SESSION["error"] = "please ensure passwords match";
    header("location:register.php");
}

// create the password_hash using the PASSWORD_DEFAULT argument

$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

// login to the database

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

$conn = new mysqli($servername, $username, $password, $dbname);


// make sure that the new user is not already in the database

$sql = "SELECT username FROM users WHERE username = '$user'";
$result = $conn->query($sql);

if ($result->num_rows >= 1) {
    $_SESSION["error"] = "user already exists!";
    header("location:register.php");
    exit;
//    echo $_SESSION["error"];
}

// insert username and password hash into db (put the username in the session
// or make them login)

$sql = "INSERT INTO users (username, password)
VALUES ('$user', '$pass_hash')";

if ($conn->query($sql) === TRUE) {
    $_SESSION["error"] = "";
    header("location:index.php");
} else {
  $_SESSION["error"] = "error creating account, please try again!";
}

$conn->close();
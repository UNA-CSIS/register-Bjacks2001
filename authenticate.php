<?php
// start session
session_start();

$user = $_POST["user"];
$user_password = $_POST["pwd"];
// login to the softball database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// select password from users where username = <what the user typed in>
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT password FROM users WHERE username='$user'";
$result = $conn->query($sql);

// if no rows, then username is not valid (but don't tell Mallory) just send
// her back to the login
// otherwise, password_verify(password from form, password from db)
// if good, put username in session, otherwise send back to login

if ($result->num_rows > 0) {
    if ($row = $result->fetch_assoc()) {
        // test the end user's password against the hash in the db
        $verified = password_verify($user_password, trim($row['password']));
        if ($verified) {
            $_SESSION['username'] = $user;
            $_SESSION['error'] = '';
//            echo "success";
        } else {
            $_SESSION['error'] = 'invalid username or password';
//            echo "failure";
        }
    }
} else {
    $_SESSION['error'] = 'invalid username or password';
}
$conn->close();
header("location:index.php");



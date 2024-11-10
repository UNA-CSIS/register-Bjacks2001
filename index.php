<?php
session_start();

if (isset($_SESSION["username"])) {
    $user = $_SESSION["username"];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<em>" . $_SESSION['error'] . "</em>";
        }
        if (isset($user)) {
            $html = "Welcome, " . $user . "<br>";
            echo $html;
        }
        ?>
        <form action="authenticate.php" method="POST">
            Username: <input type="text" name="user"><br>
            Password: <input type="password" name="pwd"><br>
            <input type="submit">
        </form>
        <a href="register.php">Register a new login</a>
        <p>
            <a href="games.php">UNA NCAA Championship Season</a>
    </body>
</html>

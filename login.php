<?php
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

require_once '../api/config/db_connect.php';

$msg = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password =  mysqli_real_escape_string($conn, trim($_POST['password']));

    if ($username == null)  $msg = "Insert username";
    if ($password == null) $msg = "Insert Password";

    $sql = "SELECT log_username FROM tbl_login WHERE log_username = '$username' AND log_password = md5('$password')";
    $query = mysqli_query($conn, $sql);

    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();
        $_SESSION['login'] = $row['log_username'];
        header("Location: index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
    <title>Alarm-Puzzle | Login</title>
</head>

<body>
    <div class="container">
        <div class="login-content">
            <img class="center" src="https://i.ibb.co/CBH2kyg/LOGO.png" width="250px" alt="">
            <form action="" method="POST">
                <label for=""><i class="fas fa-user"></i></label>
                <input type="text" name="username" placeholder="Username" required>
                <label for=""><i class="fas fa-key"></i></label>
                <input type="password" name="password" placeholder="Password" required>
                <button class="center" type="submit" name="login"><i class="fas fa-sign-in-alt"></i> LOGIN</button>
            </form>
        </div>
    </div>
</body>

</html>
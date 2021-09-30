<?php
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

require_once '../api/config/db_connect.php';

$msg = '';

if (isset($_POST['submit'])) {
    $question = mysqli_real_escape_string($conn, trim($_POST['question']));
    $answer =  mysqli_real_escape_string($conn, trim($_POST['answer']));
    $img =  mysqli_real_escape_string($conn, trim($_POST['img']));

    if ($question == null)  $msg = "Insert question";
    if ($answer == null) $msg = "Insert answer";
    $answer_lw = strtolower($answer);
    
    if ($img != null) {
        $sql = "INSERT INTO tbl_question(question, answer, img_path) VALUES('$question', '$answer_lw', '$img')";
    } else {
        $sql = "INSERT INTO tbl_question(question, answer, img_path) VALUES('$question', '$answer_lw', NULL)";
    }

    $query = mysqli_query($conn, $sql);

    if ($query) {
        $lastId = $conn->insert_id;
        echo "<script>
        alert('Success! Question : ".$question."');
        window.location.href='all-question.php';
        </script>";
    } else {
        echo $conn->error;
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
        <div class="content">
            <form action="" method="POST">
                <label for=""><i class="fas fa-question"></i> Question</label>
                <textarea name="question" id="" cols="30" rows="10" placeholder="Write a question here!" required></textarea>
                <label for=""><i class="fas fa-check"></i> Answer</label>
                <textarea name="answer" cols="30" rows="10" placeholder="Write an answer here!" required></textarea>
                <label for=""><i class="fas fa-images"></i> Image URL</label>
                <textarea name="img" cols="30" rows="10" style="height: 70px" placeholder="URL of Question's image. (not required)"></textarea>
                <button class="center submit" type="submit" name="submit" style="width: 150px;" onclick="return confirm('Add this question to database?');"><i class="fas fa-plus"></i> SUBMIT</button>
            </form>
            
            <a href="logout.php" class="btn btn-logout" onclick="return confirm('Do you want to Logout?');"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
            <a href="all-question.php" class="btn btn-big"><i class="fas fa-question-circle"></i> All Questions</a>
        </div>
    </div>
</body>

</html>
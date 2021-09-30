<?php
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

require_once '../api/config/db_connect.php';

$msg = '';

if (isset($_GET['q'])) {
    $id = $_GET['q'];
    $sql = "SELECT * FROM `tbl_question` WHERE ques_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        foreach ($result as $row) {
            $ques = $row;
        }
    }
}

if (isset($_POST['submit'])) {
    $question = mysqli_real_escape_string($conn, trim($_POST['question']));
    $answer =  mysqli_real_escape_string($conn, trim($_POST['answer']));
    $img =  mysqli_real_escape_string($conn, trim($_POST['img']));

    if ($question == null)  $msg = "Insert question";
    if ($answer == null) $msg = "Insert answer";
    $answer_lw = strtolower($answer);

    if ($img != null) {
        $sql = "UPDATE tbl_question SET question = '$question', answer = '$answer_lw', img_path = '$img' WHERE ques_id = $id";
    } else {
        $sql = "UPDATE tbl_question SET question = '$question', answer = '$answer_lw', img_path = NULL WHERE ques_id = $id";
    }

    $query = mysqli_query($conn, $sql);

    if ($query) {
        $lastId = $conn->insert_id;
        echo "<script>
        alert('Edit success! Question : " . $question . "');
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
                <textarea name="question" id="" cols="30" rows="10" placeholder="Write a question here!" required><?= $ques['question'] ?></textarea>
                <label for=""><i class="fas fa-check"></i> Answer</label>
                <textarea name="answer" cols="30" rows="10" placeholder="Write an answer here!" required><?= $ques['answer'] ?></textarea>
                <label for=""><i class="fas fa-images"></i> Image URL</label>
                <textarea name="img" cols="30" rows="10" style="height: 70px" placeholder="URL of Question's image. (not required)"><?= $ques['img_path'] ?></textarea>
                <button class="center edit" type="submit" name="submit" style="width: 150px;" onclick="return confirm('Add this question to database?');"><i class="fas fa-plus"></i> EDIT</button>
            </form>

            <a href="logout.php" class="btn btn-logout" onclick="return confirm('Do you want to Logout?');"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
            <a href="all-question.php" class="btn btn-big"><i class="fas fa-chevron-left"></i> BACK</a>
        </div>
    </div>
</body>

</html>
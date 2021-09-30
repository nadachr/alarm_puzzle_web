<?php 
require_once '../api/config/db_connect.php';

if (isset($_GET['hide'])) {
    $id = $_GET['hide'];
    $sqlHide = "UPDATE tbl_question SET ques_status = 0 WHERE ques_id = $id";
    $hide = mysqli_query($conn, $sqlHide);

    if ($hide) {
        // echo $lastId;
        header("Location: all-question.php");
    } else {
        echo $conn->error;
    }
}

if (isset($_GET['show'])) {
    $id = $_GET['show'];
    $sqlShow = "UPDATE tbl_question SET ques_status = 1 WHERE ques_id = $id";
    $show = mysqli_query($conn, $sqlShow);

    if ($show) {
        // echo $lastId;
        header("Location: all-question.php");
    } else {
        echo $conn->error;
    }
}

?>
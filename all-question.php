<?php
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

require_once '../api/config/db_connect.php';

$perpage = 5;

if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 1;
}

$start = ($page - 1) * $perpage;

$sql = "SELECT * FROM `tbl_question` ORDER BY ques_status DESC, ques_id DESC LIMIT $start, $perpage";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    foreach ($result as $row) {
        $ques[] = $row;
    }
}

$i = 1 + $start;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
    <title>Alarm-Puzzle | All Question</title>
</head>

<body>
    <div class="container">
        <div class="content">
            <form action="" method="POST">
                <table>
                    <thead>
                        <th>#</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Image</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($ques as $q) { ?>
                            <tr class="<?= $q['ques_status'] == 1 ? '' : 'grey' ?>">
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $q['question'] ?></td>
                                <td><?php echo $q['answer'] ?></td>
                                <td align="center">
                                    <?php if ($q['img_path'] != null) {
                                        echo "<img src='" . $q['img_path'] . "' width='100px' alt=''>";
                                    } else {
                                        echo "-";
                                    } ?>
                                </td>
                                <td>
                                    <a class="btn btn-icon edit" href="edit-question.php?q=<?= $q['ques_id'] ?>"><i class="fas fa-pen"></i></a>
                                    <?php if ($q['ques_status'] == 1) { ?>
                                        <a href="hidenshow.php?hide=<?= $q['ques_id'] ?>" class="btn btn-icon hide" onclick="return confirm('Do you want hide this question?');"><i class="fas fa-eye-slash"></i></a>
                                    <?php } else { ?>
                                        <a href="hidenshow.php?show=<?= $q['ques_id'] ?>" class="btn btn-icon show" onclick="return confirm('Do you want show this question?');"><i class="fas fa-eye"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <?php
                $sql2 = "SELECT * FROM tbl_question";
                $query2 = mysqli_query($conn, $sql2);
                $total_record = mysqli_num_rows($query2);
                $total_page = ceil($total_record / $perpage);
                ?>

                <div class="center">
                    <div class="pagination">
                        <a href="all-question.php">&laquo;</a>
                        <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                            <a class="<?= $i == $page ? 'active' : '' ?>" href="all-question.php?p=<?= $i; ?>"><?= $i ?></a>
                        <?php } ?>
                        <a href="all-question.php?p=<?= $total_page ?>">&raquo;</a>
                    </div>
                </div>
            </form>

            <a href="logout.php" class="btn btn-logout" onclick="return confirm('Do you want to Logout?');"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
            <a href="index.php" class="btn btn-big submit"><i class="fas fa-plus-square"></i> Add Questions</a>
        </div>
    </div>
</body>

</html>
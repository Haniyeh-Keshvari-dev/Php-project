<?php
include "../Database/database.php";

if ($_SESSION['role']!=2){
    header('location:../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css" >
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link " href="page/menu.php">منو</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="page/blog.php">وبلاگ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="page/writers.php">کامنت</a>
            </li>
        </ul>
    </div><br><br><br><br>

    <div>
        <div class="row" style="background-color: #00bffe">
            <h1>Hello Admin</h1>
        </div>
    </div>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

</body>
</html>
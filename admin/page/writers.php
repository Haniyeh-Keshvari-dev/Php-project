<?php
include "../../Database/database.php";

if ($_SESSION['role']!=2){
    header('location:../index.php');
}

if (isset($_POST['sub'])) {

    $name = $_POST['name'];

    $stmt = $conn->prepare("insert into writer(name)values(?)");
    $stmt->bindParam(1, $name);
    $stmt->execute();
}
$num = 1;
$selectall = $conn->prepare("select * from writer");
$selectall->execute();
$menus = $selectall->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css" >
    <link rel="stylesheet" href="../../css/style.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link " href="menu.php">منو</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="blog.php">وبلاگ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="writers.php">نویسندگان</a>
            </li>

        </ul>
    </div>
<br>
    <div class="row">
        <form method="POST">
            <input type="text" placeholder="نام نویسنده" name="name" class="form-control"><br>
            <input type="submit" value="افزودن" name="sub" class="btn btn-primary"><br><br>
        </form>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">ردیف</th>
            <th scope="col">نام نویسنده</th>
            <th scope="col">عملیات</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($menus as $menu) { ?>
            <tr>
                <th scope="row"><?= $num++ ?></th>
                <td><?php echo $menu['name']; ?></td>
                <td>
                    <a href="editwriter.php?id=<?php echo $menu['id'];?>" class="btn btn-warning">ویرایش </a>
                    <a href="deletewriter.php?id=<?php echo $menu['id'];?>" class="btn btn-danger">حذف </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>

    </table>
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

</body>
</html>
<?php
include "../../Database/database.php";

if ($_SESSION['role']!=2){
    header('location:../index.php');
}
if (isset($_POST['sub'])) {
    $title = $_POST['title'];
    $sort = $_POST['sort'];
    $customRadio = $_POST['customRadio'];

    $stmt = $conn->prepare("insert into menu(title,sort,status)values(?,?,?)");
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $sort);
    $stmt->bindParam(3, $customRadio);
    $stmt->execute();
}
$num = 1;
$selectall = $conn->prepare("select * from menu");
$selectall->execute();
$menus = $selectall->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link active" href="#">منو</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="blog.php">وبلاگ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="writers.php">نویسندگان</a>
            </li>
        </ul>
    </div>
    <div class="row" style="padding: 30px">
        <form method="POST">

            <input type="text" placeholder="عنوان" name="title" class="form-control"><br>

            <input type="number" placeholder="اولویت بندی" name="sort" class="form-control"><br>

            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio1" value="1" name="customRadio" class="custom-control-input" checked>
                <label class="custom-control-label" for="customRadio1">فعال</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio2" value="0" name="customRadio" class="custom-control-input">
                <label class="custom-control-label" for="customRadio2">غیرفعال</label>
            </div>
            <br>
            <input type="submit" value="ثبت" name="sub" class="btn btn-primary"><br><br>
        </form>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ردیف</th>
                <th scope="col">عنوان</th>
                <th scope="col">اولویت بندی</th>
                <th scope="col">وضعیت</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($menus as $menu) { ?>
                <tr>
                    <th scope="row"><?= $num++ ?></th>
                    <td><?php echo $menu['title']; ?></td>
                    <td><?php echo $menu['sort']; ?></td>
                    <td><?php if ($menu['status'] == 1) { ?><span class="btn btn-success">فعال</span><?php } else { ?>
                            <span class="btn btn-danger">غیرفعال</span><?php } ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $menu['id'];?>" class="btn btn-warning">ویرایش </a>
                        <a href="delete.php?id=<?php echo $menu['id'];?>" class="btn btn-danger">حذف </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>


    </div>
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

</body>
</html>
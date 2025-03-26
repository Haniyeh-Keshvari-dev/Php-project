<?php
include "../../Database/database.php";

$id = $_GET['id'];
if (isset($_POST['sub'])) {
    $title = $_POST['title'];
    $sort = $_POST['sort'];
    $customRadio = $_POST['customRadio'];

    $stmt = $conn->prepare("update menu set title=?,sort=?,status=? where id=?");
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $sort);
    $stmt->bindParam(3, $customRadio);
    $stmt->bindParam(4, $id);
    $stmt->execute();
    header('location:menu.php');
}
$update = $conn->prepare("select * from menu where id=?");
$update->bindParam(1, $id);
$update->execute();
$menus = $update->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['back'])){
    header('location:menu.php');
}
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

            <input type="text" placeholder="عنوان" name="title" value="<?php echo $menus['title']; ?>"
                   class="form-control"><br>

            <input type="number" placeholder="اولویت بندی" name="sort" value="<?php echo $menus['sort']; ?>"
                   class="form-control"><br>

            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio1" value="1" name="customRadio"
                       class="custom-control-input"<?php if ($menus['status'] == 1) { ?> checked <?php } ?>>
                <label class="custom-control-label" for="customRadio1">فعال</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio2" value="0" name="customRadio"
                       class="custom-control-input" <?php if ($menus['status'] == 0) { ?> checked <?php } ?>>
                <label class="custom-control-label" for="customRadio2">غیرفعال</label>
            </div>
            <br>
            <input type="submit" value="ثبت" name="sub" class="btn btn-primary">
            <input type="submit" value="بازگشت" name="back" class="btn btn-dark">
        </form>

    </div>
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

</body>
</html>

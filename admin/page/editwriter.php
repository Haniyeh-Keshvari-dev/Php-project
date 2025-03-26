<?php
include "../../Database/database.php";
$id = $_GET['id'];
if (isset($_POST['sub'])) {
    $name = $_POST['name'];
    $stmt = $conn->prepare("update writer set name=? where id=?");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $id);
    $stmt->execute();
    header('location:writers.php');
}
$update = $conn->prepare("select * from writer where id=?");
$update->bindParam(1, $id);
$update->execute();
$menus = $update->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['back'])){
    header('location:writers.php');
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
    <H3>Edit writer</H3><hr>
    </div>
    <div class="row" style="padding: 30px">
        <form method="POST">
            <input type="text" placeholder="نام نویسنده" name="name" value="<?php echo $menus['name']; ?>"
                   class="form-control"><br>
            <br>
            <input type="submit" value="ثبت" name="sub" class="btn btn-primary">
            <input type="submit" value="بازگشت" name="back" class="btn btn-dark">
        </form>

    </div>
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

</body>
</html>

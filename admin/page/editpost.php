<?php
include "../../Database/database.php";

$id = $_GET['id'];
$post = $conn->prepare("SELECT * FROM posts WHERE id=?");
$post->bindParam(1, $id);
$post->execute();
$posts = $post->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['sub'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $tags = trim($_POST['tags']);
    $writer = $_POST['writer'];
    $date = time();

    // آپلود تصویر جدید
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $image_name = basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $image_name;

        // ایجاد پوشه آپلود در صورت عدم وجود
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // آپلود فایل جدید
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // به‌روزرسانی تصویر در دیتابیس
            $stmt = $conn->prepare("UPDATE image SET image = ? WHERE id = ?");
            $stmt->bindParam(1, $image_name);
            $stmt->bindParam(2, $posts['image_id']);
            if (!$stmt->execute()) {
                echo "خطا در به‌روزرسانی تصویر.";
            }
        } else {
            echo "مشکلی در آپلود تصویر جدید وجود دارد.";
        }
    }

    // به‌روزرسانی اطلاعات پست
    $stmt = $conn->prepare("UPDATE posts SET title=?, content=?, tags=?, writer=?, date=? WHERE id=?");
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $content);
    $stmt->bindParam(3, $tags);
    $stmt->bindParam(4, $writer);
    $stmt->bindParam(5, $date);
    $stmt->bindParam(6, $id);

    if ($stmt->execute()) {
        header('location:blog.php');
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "خطا در به‌روزرسانی پایگاه داده: " . $errorInfo[2];
    }
 }


$writer = $conn->prepare("select * from writer");
$writer->execute();
$writers = $writer->fetchall(PDO::FETCH_ASSOC);

$image = $conn->prepare("select * from image ");
$image->execute();
$images = $image->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['back'])) {
    header('location:blog.php');
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
    <script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <style>
        input, textarea {
            margin-bottom: 15px;
        }

        form {
            margin-right: 15px;
        }
    </style>
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
                <a class="nav-link active" href="#">وبلاگ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="writers.php">نویسندگان</a>
            </li>
        </ul>
    </div>
    <br>
    <div class="row">
        <form method="post" enctype="multipart/form-data">

            <input name="title" type="text" placeholder="عنوان" class="form-control"
                   value="<?php echo $posts['title']; ?>">

            <input type="file" name="image" class="form-control" placeholder="تصویر" value=" ">
            <?php
            if (isset($posts['image_id'])) {
                $stmt = $conn->prepare("SELECT image FROM image WHERE id = ?");
                $stmt->execute([$posts['image_id']]);
                $image = $stmt->fetchColumn();
                if ($image) {
                    echo "<img src='uploads/" . htmlspecialchars($image) . "' alt='post image' width='80px'>";
                } else {
                    echo "تصویری برای این پست وجود ندارد.";
                }
            }
            ?>

            <textarea placeholder="متن خود را وارد کنید" name="content"
                      id="editor1"><?php echo $posts['content']; ?></textarea>
            <script>
                CKEDITOR.replace('editor1');
            </script>
            <br>
            <input name="tags" type="text" class="form-control" placeholder="برچسب ها"
                   value="<?php echo $posts['tags']; ?>">

            <!--            <label>نام نویسنده: </label>-->
            <select name="writer" class="form-control">
                <?php foreach ($writers as $writer): ?>
                    <option value="<?php echo $writer['id'] ?>"<?php if ($writer['id'] == $posts['writer']) { ?> selected <?php } ?>><?php echo $writer['name']; ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <input name="sub" type="submit" value="ثبت ویرایش" class="btn btn-success">
            <input name="back" type="submit" value="بازگشت" class="btn btn-dark">
        </form>

    </div>
    <br>
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

</body>
</html>

<?php
include "../../Database/database.php";
include "../../js/jdf.php";

if ($_SESSION['role'] != 2) {
    header('location:../index.php');
}
$num = 1;

if (isset($_POST['sub'])) {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $image_name = basename($_FILES['image']['name']); // فقط نام فایل
        $uploadFile = $uploadDir . $image_name;

        // اگر پوشه آپلود وجود ندارد، ایجاد شود
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadFile)) {
            echo "فایل با موفقیت آپلود شد: " . $uploadFile; // چاپ مسیر برای بررسی
        } else {
            echo "مشکلی در آپلود فایل به وجود آمده است.";
        }
    } else {
        echo "هیچ فایلی انتخاب نشده یا مشکلی در ارسال فایل وجود دارد.";
    }

    if (isset($image_name)) { // ذخیره نام فایل در دیتابیس
        $title = $_POST['title'];
        $stmt = $conn->prepare("INSERT INTO image (title, image) VALUES (?, ?)");
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $image_name); // فقط نام فایل ذخیره شود
        if ($stmt->execute()) {
            $image_id = $conn->lastInsertId(); // شناسه عکس آپلودشده
        } else {
            echo "خطا در ذخیره مسیر فایل در دیتابیس.";
        }
    }

    // ذخیره اطلاعات پست
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $writer = $_POST['writer'];
    $date = time();

    $stmt = $conn->prepare("INSERT INTO posts(title, content, tags, writer, date, image_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $content);
    $stmt->bindParam(3, $tags);
    $stmt->bindParam(4, $writer);
    $stmt->bindParam(5, $date);
    $stmt->bindParam(6, $image_id);
    $stmt->execute();
}

// دریافت نویسندگان
$selectall = $conn->prepare("SELECT * FROM writer");
$selectall->execute();
$writers = $selectall->fetchAll(PDO::FETCH_ASSOC);

// دریافت پست‌ها
$selectall = $conn->prepare("SELECT * FROM posts");
$selectall->execute();
$posts = $selectall->fetchAll(PDO::FETCH_ASSOC);
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

            <input name="title" type="text" placeholder="عنوان" class="form-control">

            <input type="file" name="image" class="form-control" placeholder="تصویر">

            <textarea placeholder="متن خود را وارد کنید" name="content" id="editor1"></textarea>
            <script>
                CKEDITOR.replace('editor1');
            </script>
            <br>
            <input name="tags" type="text" class="form-control" placeholder="برچسب ها">

            <!--            <label>نام نویسنده: </label>-->
            <select name="writer" class="form-control">
                <?php foreach ($writers as $writer): ?>
                    <option value="<?php echo $writer['id'] ?>"><?php echo $writer['name'] ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <input name="sub" type="submit" value="ثبت نوشته" class="btn btn-success">
        </form>

    </div>
    <br>
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ردیف</th>
                <th scope="col">عنوان</th>
                <th scope="col">تصویر</th>
                <th scope="col">نویسنده</th>
                <th scope="col">تاریخ</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($posts as $post) { ?>
                <tr>
                    <th scope="row"><?= $num++ ?></th>
                    <td><?php echo $post['title']; ?></td>

                    <td>
                        <?php
                        $stmt = $conn->prepare("SELECT image FROM image WHERE id = ?");
                        $stmt->execute([$post['image_id']]);
                        $image = $stmt->fetchColumn();
                        if ($image) {
                            echo "<img src='uploads/" . htmlspecialchars($image) . "' alt='post image' width='80px'>";
                        } else {
                            echo "تصویری یافت نشد!";
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        foreach ($writers as $writer) {
                            if ($post['writer'] == $writer['id']) {
                                echo $writer['name'];
                            }
                        }
                        ?>
                    </td>
                    <td><?php echo jdate('Y/m/d', $post['date']); ?></td>
                    <td>
                        <a href="editpost.php?id=<?php echo $post['id'] ?>" class="btn btn-warning">ویرایش</a>
                        <a href="deletepost.php?id=<?php echo $post['id']; ?>" class="btn btn-danger">حذف</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

</body>
</html>
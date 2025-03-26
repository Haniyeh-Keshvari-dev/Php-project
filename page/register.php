<?php
include "../Database/database.php";
global $conn;
$success=null;
$error=null;
if (isset($_POST['sub'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("insert into users(username,email,age,password)values(?,?,?,?)");
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $age);
    $stmt->bindParam(4, $password);
    $stmt->execute();
    header('location:login.php');
    $success=true;
    }else{
    $error=true;
}



?>


<html lang="fa">

<head>
    <meta charset="UTF-8">
    <title>weblog</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
</head>

<body>
<div class="container">
    <br>

    <!-- start headers -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">وبلاگ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="../index.php">خانه <span class="sr-only">(current)</span></a>
                </li>
            </ul>
    </nav>
</div>
<!-- end headers -->

<br><br><br><br><br>
<div class="container">

    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-12 col-lg-4">
            <form method="POST" class="register-form">
                <input type="text" name="username" placeholder="نام کاربری">
                <input type="email" name="email" placeholder="ایمیل">
                <input type="number" name="age" placeholder="سن">
                <input type="password" name="password" placeholder="رمز عبور"><br>
                <input type="submit" name="sub" value="ثبت نام" class="btn btn-primary submit-register">
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<!-- footer my website -->

<footer>
    <div class="footer1">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7"><br><br><br>
                    <form>
                        <input type="text" class="input-group" placeholder="پست الکتریکی شما">
                        <input type="submit" class="btn btn-success" value="عضویت در خبرنامه">
                    </form>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="namad">
                        <img src="https://toplearn.com/site/images/star2.png" alt="">
                        <img src="https://toplearn.com/site/images/logo-samandehi.png" height="166px" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer2">
        <p class="container">تمام حقوق این وبسایت برای وبلاگ محفوظ است و هرگونه استفاده بدونه اجازه از ما پیگرد
            قانونی دارد</p>
    </div>
</footer>


</body>
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php
    if ($success==true){ ?>
        const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: "success",
        title: "Signed in successfully"
    });
   <?php } ?>
</script>

<script>
    <?php
    if ($error==true){ ?>
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: "error",
        title: "Signed in error"
    });
    <?php } ?>
</script>

</html>
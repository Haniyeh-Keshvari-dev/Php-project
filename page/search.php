<?php
include "../Database/database.php";

$search=$_GET['post'];

$selectall = $conn->prepare("select count(id) from posts");
$selectall->execute();
$numposts = $selectall->fetch(PDO::FETCH_ASSOC);
foreach ($numposts as $numpost) {
}


$selectall = $conn->prepare("select count(id) from writer");
$selectall->execute();
$numwriters = $selectall->fetch(PDO::FETCH_ASSOC);
foreach ($numwriters as $numwriter) {
}


$selectall = $conn->prepare("select count(id) from users");
$selectall->execute();
$numusers = $selectall->fetch(PDO::FETCH_ASSOC);
foreach ($numusers as $numuser) {
}
$selectall = $conn->prepare("select * from menu order by sort ");
$selectall->execute();
$menus = $selectall->fetchAll(PDO::FETCH_ASSOC);

$selectall = $conn->prepare("select * from posts where title like '%$search%' order by date desc ");
$selectall->execute();
$posts = $selectall->fetchAll(PDO::FETCH_ASSOC);

$selectall = $conn->prepare("select * from image ");
$selectall->execute();
$images = $selectall->fetchAll(PDO::FETCH_ASSOC);

$selectall = $conn->prepare("select * from writer ");
$selectall->execute();
$writers = $selectall->fetchAll(PDO::FETCH_ASSOC);


function limit_words($string, $word_limit)
{
    $words = explode(" ", $string);
    return implode(" ", array_splice($words, 0, $word_limit));
}
if (isset($_POST['search'])) {
    if (!empty($_POST['searchcaption'])) {
        $search = htmlspecialchars(trim($_POST['searchcaption']), ENT_QUOTES, 'UTF-8');
        header("Location:search.php?post=" . urlencode($search));
        exit;
    } else {
        echo "لطفاً مقدار معتبری وارد کنید.";
    }
}

?>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <title>weblog</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
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
                <?php foreach ($menus as $menu) {
                    if ($menu['status'] == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> <?php echo $menu['title']; ?></a>
                        </li>
                    <?php }
                } ?>
                <?php if (isset($_SESSION['login'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            حساب کاربری
                        </a>
                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#"><?php echo $_SESSION['email']; ?></a>
                            <a class="dropdown-item" href="#"><?php echo $_SESSION['password']; ?></a>
                            <?php if ($_SESSION['role'] == 2) { ?><a class="dropdown-item" href="../admin/index.php">پنل ادمین</a><?php } ?>

                        </div>
                    </li>
                    <a class="nav-link " href="exit.php" id="navbarDropdown" role="button"
                       aria-haspopup="true" aria-expanded="false">
                        خروج
                    </a>
                <?php } else { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="login.php">ورود <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="register.php">ثبت نام <span class="sr-only">(current)</span></a>
                    </li>
                <?php } ?>
            </ul>
            <form method="post" class="form-inline my-2 my-lg-0 mr-auto">
                <input class="form-control mr-sm-2 placholder" type="search" placeholder="دنبال چی میگردی؟"
                       aria-label="Search" name="searchcaption">
                <button name="search" class="btn btn-outline-success my-2 my-sm-0" type="submit">جستجو</button>
            </form>
        </div>
    </nav>
    <!-- end headers -->

    <!-- start content -->
    <div>
        <div class="row d-none d-lg-flex">
        </div>
    </div>
    <!-- end content -->
    <br><br class="d-none d-lg-block"><br class="d-none d-lg-block">
    <!-- start posts -->

    <div>
        <h5 style="padding: 10px;">
        نتایج مرتبط برای "<?=$search?>"
        </h5>
        <div class="row">
            <?php foreach ($posts as $post){
                $viewid=$post['id'];
                $selectall = $conn->prepare("select count(*) from views where view=?");
                $selectall->bindValue(1,$viewid);
                $selectall->execute();
                $numviews = $selectall->fetch(PDO::FETCH_ASSOC);
                foreach ($numviews as $numview) {
                }
                ?>
                <div class="col-12 col-lg-4">
                    <div class="post-item">
                        <a href="" class="item-hover-btn"><img src="../admin/page/uploads/<?php foreach ($images as $image){
                                if ($post['image_id']==$image['id']){echo $image['image'];}}?>" alt="" width="100%">
                            <div class="hovershow">
                                <div class="hover-image-post d-none d-lg-flex">
                                </div>
                                <a href="single.php?post=<?php echo $post['title'];?>" class="more-opst btn d-none d-lg-flex">مشاهده ی مقاله</a>
                            </div>
                        </a>

                        <div class="post-caption">
                            <p><a href=""><?php echo $post['title'];?></a></p>
                            <span>
                            <?php echo limit_words($post['content'], 20).' ...'; ?>
                            </span>
                            <br><br>
                            <span class="seen-post">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path fill-rule="evenodd"
                                          d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg><?=$numview;?>
                            </span>
                            <span class="float-left post-m">
                                <a href="">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-fill"
                                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    </svg><?php foreach ($writers as $writer){ if ($post['writer']==$writer['id']){echo $writer['name'];}}?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>
<br><br><br><br>

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
        <p class="container">تمام حقوق این وبسایت برای وبلاگ محفوظ است و هرگونه استفاده بدونه اجازه از ما پیگرد قانونی
            دارد</p>
    </div>
</footer>


</body>
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php
    if ($_SESSION['login']){ ?>
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


</html>
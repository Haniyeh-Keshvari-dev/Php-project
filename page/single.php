<?php
include "../Database/database.php";
include "../js/jdf.php";

$title=$_GET['post'];

$selectall = $conn->prepare("select * from posts where title=?");
$selectall->bindValue(1,$title);
$selectall->execute();
$posts = $selectall->fetch(PDO::FETCH_ASSOC);

$selectall = $conn->prepare("select * from image where id=?");
$selectall->bindValue(1,$posts['image_id']);
$selectall->execute();
$images = $selectall->fetch(PDO::FETCH_ASSOC);

$selectall = $conn->prepare("select * from writer ");
$selectall->execute();
$writers = $selectall->fetchAll(PDO::FETCH_ASSOC);

$viewid=$posts['id'];
$selectall = $conn->prepare("insert into views(view) values (?)");
$selectall->bindValue(1,$viewid);
$selectall->execute();
$views = $selectall->fetch(PDO::FETCH_ASSOC);

$selectall = $conn->prepare("select count(*) from views where view=?");
$selectall->bindValue(1,$viewid);
$selectall->execute();
$numviews = $selectall->fetch(PDO::FETCH_ASSOC);
foreach ($numviews as $numview) {
}






?>

<html lang="fa">

<head>
    <meta charset="UTF-8">
    <title><?php echo $posts['title']; ?></title>
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
                <form class="form-inline my-2 my-lg-0 mr-auto">
                    <input class="form-control mr-sm-2 placholder" type="search" placeholder="دنبال چی میگردی؟"
                        aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">جستجو</button>
                </form>
            </div>
        </nav>
    </div>
    <!-- end headers -->

    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="post-page">
                <div class="image-post">
                    <img src="../admin/page/uploads/<?php echo $images['image']?>" alt="" style="max-width: 600px;">
                </div>
                <div class="information-post">
                    <div> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                            <path fill-rule="evenodd"
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                        </svg><?=$numview;?></div>
                    <div><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                        </svg><?php foreach ($writers as $writer){ if ($posts['writer']==$writer['id']){echo $writer['name'];}}?></div>

                    <div><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar2-date-fill"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 3.5c0-.276.244-.5.545-.5h10.91c.3 0 .545.224.545.5v1c0 .276-.244.5-.546.5H2.545C2.245 5 2 4.776 2 4.5v-1zm7.336 9.29c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm.066-2.544c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2zm-2.957-2.89v5.332H5.77v-4.61h-.012c-.29.156-.883.52-1.258.777V8.16a12.6 12.6 0 0 1 1.313-.805h.632z" />
                        </svg><?php echo jdate('d F',$posts['date'])?> </div>
                </div>
                <br>
                <div class="content-post">
                    <h5><?php echo $posts['title']?></h5>
                    <br>
                    <p><?php echo $posts['content'];?></p>
                </div>

                <br>
                <div class="tag-post">
                    <?php $tags=explode(',', $posts['tags']);
                    foreach ($tags as $tag){
                    ?>
                    <span>
                        <?php echo $tag;?>
                    </span>
                    <?php } ?>
                </div>
            </div>
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

</html>
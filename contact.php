<?php
include_once 'files/apikey.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="robots" content="index, follow">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MoviesGoo – Stream Full HD Movies</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="./css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="./css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="./css/owl.carousel.min.css">
    <link rel="stylesheet" href="./css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="./css/nouislider.min.css">
    <link rel="stylesheet" href="./css/ionicons.min.css">
    <link rel="stylesheet" href="./css/plyr.css">
    <link rel="stylesheet" href="./css/photoswipe.css">
    <link rel="stylesheet" href="./css/default-skin.css">
    <link rel="stylesheet" href="./css/main.css">
</head>


<body class="body">
    <?php include 'files/header.php'; ?>
    <section class="section section--first section--bg" data-bg="img/section/section.jpg" style="background: url(&quot;img/section/section.jpg&quot;) center center / cover no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section__wrap">
                        <!-- section title -->
                        <h2 class="section__title">Contact Us</h2>
                        <!-- end section title -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact py-5 section">
        <div class="container">
            <div class="row">
                <form action="#" class="col-md-8 mx-auto">
                    <div class="row mx-auto">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label text-white">Name</label>
                                <input type="name" class="primary" name="name" placeholder="John Deo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label text-white">Email</label>
                                <input type="email" class="primary" name="email" placeholder="jogn.deo@example.com">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="" class="form-label text-white">Message</label>
                                <textarea rows="6" type="message" class="primary" name="message" placeholder="Message..."></textarea>
                            </div>
                        </div>
                        <div class="col-12 me-auto">
                            <button type="button" class="btn btn-main">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php include_once('files/footer.php'); ?>
</body>

</html>
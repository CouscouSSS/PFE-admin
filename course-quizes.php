<?php
session_start();
include "connexion.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="img/favicon.png" type="image/png" />
    <title>General Culture</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>

    <?php if(isset($_SESSION['flash'])) : ?>

    <?php foreach($_SESSION['flash'] as $type => $message):?>

        <div class="alert fade show alert-<?= $type ?>">
            <div style="font-family:Rubik,sans-serif;"
                class="pt-2 pb-2 lead text-align-center text-center ">
                <i class="fas fa-exclamation-circle"></i> <?= $message ?>
                <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"> <i class="far fa-times-circle" ></i> </span>
                </button>
            </div>
        </div>

    <?php  endforeach ?>

    <?php unset($_SESSION['flash']); ?>

    <?php endif ?>
    
    <!--================ Start Header Menu Area =================-->
    <header class="header_area white-header">
        <div class="main_menu">
            <div class="search_input" id="search_input_box">
                <div class="container">
                    <form class="d-flex justify-content-between" method="" action="">
                        <input type="text" class="form-control" id="search_input" placeholder="Search Here" />
                        <button type="submit" class="btn"></button>
                        <span class="ti-close" id="close_search" title="Close Search"></span>
                    </form>
                </div>
            </div>

            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about-us.php">About</a>
                            </li>
                            <li class="nav-item submenu dropdown active">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">Pages</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item">
                                        <a class="nav-link" href="courses.php">Courses</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="course-quizes.php">General culture</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <?php if (isset($_SESSION['id'])) : ?>
                                <a class="nav-link" href="calendrier/3a-calendar.php">Calendrier</a>
                                <?php endif; ?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.php">Contact</a>
                            </li>
                            <li class="nav-item">
                                <?php if (isset($_SESSION['id'])) : ?>
                                <a class="nav-link" href="profil.php">Profil</a>
                                <?php endif; ?>
                            </li>
                            <li class="nav-item">
                                <?php if(isset($_SESSION['id'])) : ?>
                                <a class="nav-link" href="deco.php">Log-out</a>
                                <?php endif; ?>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link search" id="search">
                                    <i class="ti-search"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!--================ End Header Menu Area =================-->

    <!--================Home Banner Area =================-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="overlay"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="banner_content text-center">
                            <h2>Course Details</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="courses.php">Pages</a>
                                <a href="#">Culture general</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================ Start Course Details Area =================-->
    <section class="course_details_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 course_details_left">
                    <div class="main_image">
                        <img class="img-fluid" src="img/courses/course-details.jpg" alt="">
                    </div>
                    <div class="content_wrapper">
                        <h4 class="title">Objectives</h4>
                        <div class="content">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda ullam necessitatibus
                            animi fugit provident, quasi quod amet, eum iure esse, sint soluta sapiente dicta eaque sit.
                            Cum molestiae maxime minima?


                        </div>



                        <h4 class="title">Beginner</h4>
                        <br>
                        <div class="content">
                            <ul class="course_list">
                                <li class="justify-content-between d-flex">
                                    <h3> First quiz </h3>
                                    <a class="primary-btn2 text-uppercase enroll rounded-0 text-black"
                                        href="culture1.php">View quizz</a>
                                </li>

                                <li class="justify-content-between d-flex">
                                    <h3> Second quiz </h3>
                                    <a class="primary-btn2 text-uppercase enroll rounded-0 text-black"
                                        href="culture2.php">View quizz</a>
                                </li>

                                <li class="justify-content-between d-flex">
                                    <h3> Third quiz </h3>
                                    <a class="primary-btn2 text-uppercase enroll rounded-0 text-black"
                                        href="culture3.php">View quizz</a>
                                </li>

                            </ul>
                        </div>

                        <h4 class="title">Intermediar</h4>
                        <br>
                        <div class="content">
                            <ul class="course_list">
                                <li class="justify-content-between d-flex">
                                    <h3> First quiz </h3>
                                    <a class="primary-btn2 text-uppercase enroll rounded-0 text-black"
                                        href="culture4.php">View quizz</a>
                                </li>

                                <li class="justify-content-between d-flex">
                                    <h3> Second quiz </h3>
                                    <a class="primary-btn2 text-uppercase enroll rounded-0 text-black"
                                        href="culture5.php">View quizz</a>
                                </li>

                                <li class="justify-content-between d-flex">
                                    <h3> Third quiz </h3>
                                    <a class="primary-btn2 text-uppercase enroll rounded-0 text-black"
                                        href="culture6.php">View quizz</a>
                                </li>

                            </ul>
                        </div>

                        <h4 class="title">Expert</h4>
                        <br>
                        <div class="content">
                            <ul class="course_list">
                                <li class="justify-content-between d-flex">
                                    <h3> First quiz </h3>
                                    <a class="primary-btn2 text-uppercase enroll rounded-0 text-black"
                                        href="culture7.php">View quizz</a>
                                </li>

                                <li class="justify-content-between d-flex">
                                    <h3> Second quiz </h3>
                                    <a class="primary-btn2 text-uppercase enroll rounded-0 text-black"
                                        href="culture8.php">View quizz</a>
                                </li>

                                <li class="justify-content-between d-flex">
                                    <h3> Third quiz </h3>
                                    <a class="primary-btn2 text-uppercase enroll rounded-0 text-black"
                                        href="culture9.php">View quizz</a>
                                </li>

                            </ul>
                        </div>

                    </div>
                </div>


                <div class="col-lg-4 right-contents">
                    <ul>
                        <li>
                            <a class="justify-content-between d-flex" href="#">
                                <p>Trainer’s Name</p>
                                <span class="or">Khalil ARCHKAK </span>
                            </a>
                        </li>

                        <li>
                            <a class="justify-content-between d-flex" href="#">
                                <p>Schedule </p>
                                <span>8 hours</span>
                            </a>
                        </li>
                    </ul>

                    <?php if(isset($_SESSION['id'])) : ?>
                    <h4 class="title">Notes</h4>
                    <div class="content">

                        <br>
                        <div class="review-top row pt-40">
                            <div class="col-lg-12">

                                <h3 class="mb-15">Beginner Quizzs</h3>
                                <div class="d-flex flex-row reviews justify-content-between">
                                    <strong class="text-dark">Test 1</strong>
                                    <?php
                                        $etat="Test Reussi";                 
                                        $req = $bdd->prepare("SELECT * FROM resultat WHERE  num=? AND etat=? AND id_user = ? ");
                                        $req->execute(array(5000,$etat,$_SESSION['id']));
                                        $ok=$req->rowCount();
                                        if($ok == 0){
                                            echo '<b class="text-danger"> Test Pas reussi </b>';
                                            }else{
                                            echo '<b class="text-success">Test reussi </b>';
                                            }
                                    ?>
                                </div>

                                <div class="d-flex flex-row reviews justify-content-between">
                                    <strong class="text-dark">Test 2</strong>
                                    <?php
                                        $etat="Test Reussi";                 
                                        $req = $bdd->prepare("SELECT * FROM resultat WHERE  num=? AND etat=? AND id_user = ? ");
                                        $req->execute(array(5001,$etat,$_SESSION['id']));
                                        $ok=$req->rowCount();
                                        if($ok == 0){
                                        echo '<b class="text-danger"> Test Pas reussi </b>';
                                        }else{
                                        echo '<b class="text-success">Test reussi </b>';
                                        }
                                    ?>
                                </div>

                                <div class="d-flex flex-row reviews justify-content-between">
                                    <strong class="text-dark">Test 3</strong>
                                    <?php
                                        $etat="Test Reussi";                 
                                        $req = $bdd->prepare("SELECT * FROM resultat WHERE  num=? AND etat=? AND id_user = ? ");
                                        $req->execute(array(5002,$etat,$_SESSION['id']));
                                        $ok=$req->rowCount();
                                        if($ok == 0){
                                        echo '<b class="text-danger"> Test Pas reussi </b>';
                                        }else{
                                        echo '<b class="text-success">Test reussi </b>';
                                        }
                                    ?>
                                </div>


                            </div>

                            <div class="col-lg-12 pt-4">

                                <h3 class="mb-15">Intermediar Quizzs</h3>
                                <div class="d-flex flex-row reviews justify-content-between">
                                    <strong class="text-dark">Test 1</strong>
                                    <?php
                                        $etat="Test Reussi";                 
                                        $req = $bdd->prepare("SELECT * FROM resultat WHERE  num=? AND etat=? AND id_user = ? ");
                                        $req->execute(array(5003,$etat,$_SESSION['id']));
                                        $ok=$req->rowCount();
                                        if($ok == 0){
                                            echo '<b class="text-danger"> Test Pas reussi </b>';
                                            }else{
                                            echo '<b class="text-success">Test reussi </b>';
                                            }
                                    ?>
                                </div>

                                <div class="d-flex flex-row reviews justify-content-between">
                                    <strong class="text-dark">Test 2</strong>
                                    <?php
                                        $etat="Test Reussi";                 
                                        $req = $bdd->prepare("SELECT * FROM resultat WHERE  num=? AND etat=? AND id_user = ? ");
                                        $req->execute(array(5004,$etat,$_SESSION['id']));
                                        $ok=$req->rowCount();
                                        if($ok == 0){
                                        echo '<b class="text-danger"> Test Pas reussi </b>';
                                        }else{
                                        echo '<b class="text-success">Test reussi </b>';
                                        }
                                    ?>
                                </div>

                                <div class="d-flex flex-row reviews justify-content-between">
                                    <strong class="text-dark">Test 3</strong>
                                    <?php
                                        $etat="Test Reussi";                 
                                        $req = $bdd->prepare("SELECT * FROM resultat WHERE  num=? AND etat=? AND id_user = ? ");
                                        $req->execute(array(5005,$etat,$_SESSION['id']));
                                        $ok=$req->rowCount();
                                        if($ok == 0){
                                        echo '<b class="text-danger"> Test Pas reussi </b>';
                                        }else{
                                        echo '<b class="text-success">Test reussi </b>';
                                        }
                                    ?>
                                </div>

                                <br>

                                <h3 class="mb-15">Expert Quizzs</h3>
                                <div class="d-flex flex-row reviews justify-content-between">
                                    <strong class="text-dark">Test 1</strong>
                                    <?php
                                        $etat="Test Reussi";                 
                                        $req = $bdd->prepare("SELECT * FROM resultat WHERE  num=? AND etat=? AND id_user = ? ");
                                        $req->execute(array(5006,$etat,$_SESSION['id']));
                                        $ok=$req->rowCount();
                                        if($ok == 0){
                                            echo '<b class="text-danger"> Test Pas reussi </b>';
                                            }else{
                                            echo '<b class="text-success">Test reussi </b>';
                                            }
                                    ?>
                                </div>

                                <div class="d-flex flex-row reviews justify-content-between">
                                    <strong class="text-dark">Test 2</strong>
                                    <?php
                                        $etat="Test Reussi";                 
                                        $req = $bdd->prepare("SELECT * FROM resultat WHERE  num=? AND etat=? AND id_user = ? ");
                                        $req->execute(array(5007,$etat,$_SESSION['id']));
                                        $ok=$req->rowCount();
                                        if($ok == 0){
                                        echo '<b class="text-danger"> Test Pas reussi </b>';
                                        }else{
                                        echo '<b class="text-success">Test reussi </b>';
                                        }
                                    ?>
                                </div>

                                <div class="d-flex flex-row reviews justify-content-between">
                                    <strong class="text-dark">Test 3</strong>
                                    <?php
                                        $etat="Test Reussi";                 
                                        $req = $bdd->prepare("SELECT * FROM resultat WHERE  num=? AND etat=? AND id_user = ? ");
                                        $req->execute(array(5008,$etat,$_SESSION['id']));
                                        $ok=$req->rowCount();
                                        if($ok == 0){
                                        echo '<b class="text-danger"> Test Pas reussi </b>';
                                        }else{
                                        echo '<b class="text-success">Test reussi </b>';
                                        }
                                    ?>
                                </div>


                            </div>
                        </div>


                        <div class="feedeback">
                            <h6>Your Feedback about The tests </h6>
                            <textarea name="feedback" class="form-control" cols="10" rows="10"></textarea>
                            <div class="mt-10 text-right">
                                <a href="#" class="primary-btn2 text-right rounded-0 text-black">Submit</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Course Details Area =================-->

    <!--================ Start footer Area  =================-->
    <footer class="footer-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Top Products</h4>
                    <ul>
                        <li><a href="#">Managed Website</a></li>
                        <li><a href="#">Manage Reputation</a></li>
                        <li><a href="#">Power Tools</a></li>
                        <li><a href="#">Marketing Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">Jobs</a></li>
                        <li><a href="#">Brand Assets</a></li>
                        <li><a href="#">Investor Relations</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Features</h4>
                    <ul>
                        <li><a href="#">Jobs</a></li>
                        <li><a href="#">Brand Assets</a></li>
                        <li><a href="#">Investor Relations</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 single-footer-widget">
                    <h4>Resources</h4>
                    <ul>
                        <li><a href="#">Guides</a></li>
                        <li><a href="#">Research</a></li>
                        <li><a href="#">Experts</a></li>
                        <li><a href="#">Agencies</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 single-footer-widget">
                    <h4>Newsletter</h4>
                    <p>You can trust us. we only send promo offers,</p>
                    <div class="form-wrap" id="mc_embed_signup">
                        <form target="_blank"
                            action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                            method="get" class="form-inline">
                            <input class="form-control" name="EMAIL" placeholder="Your Email Address"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address'"
                                required="" type="email" />
                            <button class="click-btn btn btn-default">
                                <span>subscribe</span>
                            </button>
                            <div style="position: absolute; left: -5000px;">
                                <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value=""
                                    type="text" />
                            </div>

                            <div class="info"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row footer-bottom d-flex justify-content-between">
                <p class="col-lg-8 col-sm-12 footer-text m-0 text-white">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
                <div class="col-lg-4 col-sm-12 footer-social">
                    <a href="#"><i class="ti-facebook"></i></a>
                    <a href="#"><i class="ti-twitter"></i></a>
                    <a href="#"><i class="ti-dribbble"></i></a>
                    <a href="#"><i class="ti-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!--================ End footer Area  =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="js/owl-carousel-thumb.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/mail-script.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/theme.js"></script>
    <script>
        $(".alert").delay(5000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>
</body>

</html>
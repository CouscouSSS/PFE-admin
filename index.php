<?php
session_start();

include "connexion.inc.php";

if(isset($_SESSION['role'])){
    if($_SESSION['role']=="admin" || $_SESSION['role']=="admin_cours"){
        header('Location:admin/index.php');
        $_SESSION['flash']['danger']="Vous ne pouvez pas accéder au site avec votre compte admin";
        exit();
    }
}

$req=$bdd->prepare("SELECT * from section");
$req->execute();
$sections=$req->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="img/favicon.png" type="image/png" />
    <title>English Learn</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
    <script>
    function showHint(str) {
        if (str.length == 0) {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "gethint.php?q=" + str, true);
            xmlhttp.send();
        }
    }
    </script>

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
    <header class="header_area">
        <div class="main_menu">
            <div class="search_input" id="search_input_box">
                <div class="container">
                    <form class="d-flex justify-content-between" method="" action="">
                        <input type="text" class="form-control" id="search_input" placeholder="Search Here"
                            onkeyup="showHint(this.value)" /><br />
                        <span id="txtHint" class="form-control">

                        </span>


                        <button type="submit" class="btn"></button>
                        <span class="ti-close" id="close_search" title="Close Search"></span>

                    </form>

                </div>
            </div>


            <nav class="navbar navbar-expand-lg navbar-light">

                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <a class="navbar-brand logo_h" href="index.html"></a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>

                    </button>

                    <!-- Collect the nav links, forms, and other content for toggling -->

                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">

                        <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about-us.php">About</a>
                            </li>
                            <li class="nav-item submenu dropdown">
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

    <!--================ Start Home Banner Area =================-->
    <section class="home_banner_area">

        <div class="banner_inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="banner_content text-center pb-5">
                            <p class="text-uppercase mt-2 ">
                                Best online education service In Morocco
                            </p>
                            <h2 class="text-uppercase mt-3 pb-4 ">
                                Let's learn English together
                            </h2>
                            <?php if (!isset($_SESSION['id'])) : ?>
                            <div>
                                <a href="register.php" class="primary-btn2 mb-2 mb-sm-0">Register</a>
                                <a href="login.php" class="primary-btn ml-sm-3 ml-0">log in</a>
                            </div>
                            
                            <?php else : ?> 
                                <?php if($_SESSION['sexe']=="homme") : ?> 
                                
                                    <div style="font-family:Rubik,sans-serif;" class="display-4 text-warning mb-2"> Bienvenue Mr:
                                    <span class="text-capitalize "><?= $_SESSION['name']?></span> </div>
                                
                                <?php else : ?>
                                    <div style="font-family:Rubik,sans-serif;" class="display-2 text-warning mb-2"> Bienvenue Mme:
                                <span class="text-capitalize "><?= $_SESSION['name']?></span> </div>
                                
                                <?php endif; ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Home Banner Area =================-->

    <!--================ Start Registration Area =================-->
    <section style="background-color:#002347;">
        <div class="container text-center text-white">

            <i class="pb-2 pt-4 text-danger fas fa-exclamation-triangle fa-10x"></i>

            <h2 class=" display-5 text-danger text-uppercase text-white" style="letter-spacing:2px;"> Coronavirus disease </h2>

            <div class=" mb-2 text-center lead" style="position:relative; bottom:45px;">

                <br><br>
                Throughout the past few weeks, the world has changed and to help minimize the impact of the coronavirus
                (COVID-19) outbreak on students,Our website is providing free courses about english to help you study.

                <br><br>
                The best way to prevent and slow down transmission is be well informed about the COVID-19 virus.

                <br><br>
                You can acess all of WHO (World Health Organization) information and advices about the virus or
                You can track the number of cases all around the world and on your country specially by using one of the
                buttons below.
                <br><br>



                <a href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019"> <button
                        class="m-3 btn btn-outline-light btn-lg "> World Health Organization </button></a>

                <a href="https://www.worldometers.info/coronavirus/"> <button
                        class="m-3 btn btn-outline-light btn-lg pl-5 pr-5"> Coronavirus Update </button></a>

                <h3 class=" display-1 text-danger ">Stay safe , Stay home.</h3>

            </div>




        </div>
    </section>
    <!--================ End Registration Area =================-->

    <!--================ Start Feature Area =================-->
    <section class="feature_area section_gap_top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="main_title">
                        <h2 class="mb-3">Awesome Feature</h2>
                        <p>
                            Those features exist only on our website
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single_feature">
                        <div class="icon"><span class="flaticon-student"></span></div>
                        <div class="desc">
                            <h4 class="mt-3 mb-2">Personalized learning</h4>
                            <p>
                                Students practice at their own pace, starting with courses then doing tests.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single_feature">
                        <div class="icon"><span class="flaticon-book"></span></div>
                        <div class="desc">
                            <h4 class="mt-3 mb-2">Trusted content</h4>
                            <p>
                                Created by experts, Our lessons covers grammar, english, and comprehension.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single_feature">
                        <div class="icon"><span class="flaticon-earth"></span></div>
                        <div class="desc">
                            <h4 class="mt-3 mb-2">Free and will always be</h4>
                            <p>
                                We’re a nonprofit delivering the education in english all of you need.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Feature Area =================-->

    <!--================ Start Popular Courses Area =================-->
    <div class="popular_courses">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="main_title">
                        <h2 class="mb-3">Our Popular Courses</h2>
                        <p>
                            This courses are the highest noted by our clients
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- single course -->
                <div class="col-lg-12">
                    <div class="owl-carousel active_course">
                    <?php $i=1; foreach($sections as $section) : ?>
                            <div class="single_course">
                                <div class="course_head">
                                <a href="course-section.php?id=<?=$section['id']?>"><img class="img-fluid" src="img/courses/c<?=$i;?>.jpg" alt=""/></a>
                                </div>
                                <div class="course_content">

                                    <span class="tag mb-4 d-inline-block"><?= $section['nom'] ?></span>
                                    <h4 class="mb-3">
                                        <a href="course-section.php?id=<?=$section['id']?>"><?= $section['niveau'] ?></a>
                                    </h4>
                                    <p>
                                        <?= $section['objectif'] ?>

                                    </p>
                                
                                </div>
                            </div>

                            <?php $i++;?>

                            <?php if($i==4) break; ?>

                        <?php endforeach; ?>    
                        
                              
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================ End Popular Courses Area =================-->


    <!--================ Start Trainers Area =================-->
    <section class="trainer_area section_gap_top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="main_title">
                        <h2 class="mb-3">Our Expert Trainers</h2>
                        <p>
                            <i>Our Best students will be your teachers </i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center d-flex align-items-center">




                <div class="col-lg-3 col-md-6 col-sm-12 single-trainer">
                    <div class="thumb d-flex justify-content-sm-center">
                        <img class="img-fluid" src="img/face1.png" alt="" />
                    </div>
                    <div class="meta-text text-sm-center">
                        <h4>Hamza IZEND</h4>
                        <p class="designation">Faculty of Science</p>
                        <div class="mb-4">
                            <p>
                                <i>I got the TOEFL last year with a score of 80 percent ,
                                    so i'm gonna give you the tips and advices you will need the most .</i>
                            </p>
                        </div>
                        <div class="align-items-center justify-content-center d-flex">
                            <a href="#"><i class="ti-facebook"></i></a>
                            <a href="#"><i class="ti-twitter"></i></a>
                            <a href="#"><i class="ti-linkedin"></i></a>
                            <a href="#"><i class="ti-pinterest"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 single-trainer">
                    <div class="thumb d-flex justify-content-sm-center">
                        <img class="img-fluid" src="img/face2.jpg" alt="" />
                    </div>
                    <div class="meta-text text-sm-center">
                        <h4>Khalil AR</h4>
                        <p class="designation">Sr. web designer</p>
                        <div class="mb-4">
                            <p>
                                <i> I've been teaching Basics of English for almost 5 years now .
                                    I can also give video-courses for the members of our website .
                                </i>

                            </p>
                        </div>
                        <div class="align-items-center justify-content-center d-flex">
                            <a href="#"><i class="ti-facebook"></i></a>
                            <a href="#"><i class="ti-twitter"></i></a>
                            <a href="#"><i class="ti-linkedin"></i></a>
                            <a href="#"><i class="ti-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Trainers Area =================-->



    <!--================ Start Testimonial Area =================-->
    <div class="testimonial_area section_gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="main_title">
                        <h2 class="mb-3">Client say about us</h2>
                        <p>
                            Those are comments left by our clients .
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="testi_slider owl-carousel">
                    <div class="testi_item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <img src="img/testimonials/t1.jpg" alt="" />
                            </div>
                            <div class="col-lg-8">
                                <div class="testi_text">
                                    <h4>Elite Martin</h4>
                                    <p>
                                        Him, made can't called over won't there on divide there
                                        male fish beast own his day third seed sixth seas unto.
                                        Saw from
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testi_item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <img src="img/testimonials/t2.jpg" alt="" />
                            </div>
                            <div class="col-lg-8">
                                <div class="testi_text">
                                    <h4>Davil Saden</h4>
                                    <p>
                                        Him, made can't called over won't there on divide there
                                        male fish beast own his day third seed sixth seas unto.
                                        Saw from
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testi_item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <img src="img/testimonials/t1.jpg" alt="" />
                            </div>
                            <div class="col-lg-8">
                                <div class="testi_text">
                                    <h4>Elite Martin</h4>
                                    <p>
                                        Him, made can't called over won't there on divide there
                                        male fish beast own his day third seed sixth seas unto.
                                        Saw from
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testi_item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <img src="img/testimonials/t2.jpg" alt="" />
                            </div>
                            <div class="col-lg-8">
                                <div class="testi_text">
                                    <h4>Davil Saden</h4>
                                    <p>
                                        Him, made can't called over won't there on divide there
                                        male fish beast own his day third seed sixth seas unto.
                                        Saw from
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testi_item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <img src="img/testimonials/t1.jpg" alt="" />
                            </div>
                            <div class="col-lg-8">
                                <div class="testi_text">
                                    <h4>Elite Martin</h4>
                                    <p>
                                        Him, made can't called over won't there on divide there
                                        male fish beast own his day third seed sixth seas unto.
                                        Saw from
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testi_item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <img src="img/testimonials/t2.jpg" alt="" />
                            </div>
                            <div class="col-lg-8">
                                <div class="testi_text">
                                    <h4>Davil Saden</h4>
                                    <p>
                                        Him, made can't called over won't there on divide there
                                        male fish beast own his day third seed sixth seas unto.
                                        Saw from
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================ End Testimonial Area =================-->

    <!--================ Start footer Area  =================-->
        <!-- Footer -->
        <footer class="page-footer font-small indigo bg-light">

        <!-- Footer Links -->
        <div class="container">

            <!-- Grid row-->
            <div class="row text-center d-flex justify-content-center pt-5  mb-3">

            <!-- Grid column -->
            <div class="col-md-2 mb-3">
                <h6 class="text-uppercase font-weight-bold">
                <a href="about-us.php">About us</a>
                </h6>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-2 mb-3">
                <h6 class="text-uppercase font-weight-bold">
                <a href="contact.php">Contact</a>
                </h6>
            </div>
            <!-- Grid column -->

            </div>
            <!-- Grid row-->
            <hr class="rgba-white-light" style="margin: 0 15%;">

            <!-- Grid row-->
            <div class="row d-flex text-center justify-content-center mb-md-0 mb-4">

            <!-- Grid column -->
            <div class="col-md-8 col-12 mt-5">
                <p style="line-height: 1.7rem">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos inventore qui minima corrupti eos quas pariatur atque eveniet, excepturi impedit, dolor voluptates unde quidem nam commodi, autem iste? Enim, libero!</p>
            </div>
            <!-- Grid column -->

            </div>
            <!-- Grid row-->
            <hr class="clearfix d-md-none rgba-white-light" style="margin: 10% 15% 5%;">

            </div>
            <!-- Grid row-->

            <!-- Copyright -->
        <div class="footer-copyright text-center py-3"> <b class="text-dark"> © 2020 Copyright: ARCHKAK Khalil && IZEND Hamza </b> </div>
        <!-- Copyright -->
        </div>
        <!-- Footer Links -->



        </footer>
        <!-- Footer -->
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
    <script src="https://kit.fontawesome.com/6e8ba3d05b.js" crossorigin="anonymous"></script>
    <script>
        $(".alert").delay(5000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>
    
</body>

</html>
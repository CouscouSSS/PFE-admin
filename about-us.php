<?php

session_start();

if(isset($_SESSION['role'])){
    if($_SESSION['role']=="admin" || $_SESSION['role']=="admin_cours"){
        header('Location:admin/index.php');
        $_SESSION['flash']['danger']="Vous ne pouvez pas accéder au site avec votre compte administrateur";
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="img/favicon.png" type="image/png" />
    <title>About Us</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
    <script>
    function getVote(int) {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("poll").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "poll_vote.php?vote=" + int, true);
        xmlhttp.send();
    }
    </script>
</head>

<body>
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
                    <?php if (isset($_SESSION['id'])) : ?>
                        <?php if($_SESSION['sexe']=="homme") : ?> 
                            <b style="font-family:Rubik; color: #FCC632;" class=" visible lead"> Bienvenue Monsieur : <?= $_SESSION['name'] ?> </b>
                        <?php else : ?>
                            <b style="font-family:Rubik; color: #FCC632;" class=" visible lead"> Bienvenue Madame : <?= $_SESSION['name'] ?> </b>
                        <?php endif ?>
                    <?php endif; ?>
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="about-us.php">About</a>
                            </li>
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" role="button" aria-haspopup="true"
                                    aria-expanded="false">Pages</a>
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
                            <h2>About Us</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="about-us.php">About Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================ Start About Area =================-->
    <section class="about_area section_gap">
        <div class="container">
            <div class="row h_blog_item">
                <div class="col-lg-6">
                    <div class="h_blog_img">
                        <img class="img-fluid" src="img/about.png" alt="" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="h_blog_text">
                        <div class="h_blog_text_inner left right">
                            <h4>Welcome to our Institute</h4>
                            <p>
                                In our Website you will be in contact with our teachers , who prepared those lessons for
                                you , after they were ranked the first on the TOEFL in 2019.
                            </p>
                            <div id="poll">
                                <h3>Do you like our Website So far ?</h3>
                                <form>
                                    Yes:
                                    <input type="radio" name="vote" value="0" onclick="getVote(this.value)">
                                    <br>No:
                                    <input type="radio" name="vote" value="1" onclick="getVote(this.value)">
                                </form>
                            </div>
                            <br />
                            <!--a class="primary-btn" href="#">
                  Learn More <i class="ti-arrow-right ml-1"></i>
                </a>!-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End About Area =================-->

    <!--================ Start Feature Area =================-->
    <section class="feature_area section_gap_top title-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="main_title">
                        <h2 class="mb-3 text-white">Awesome Feature</h2>
                        <p>
                            Replenish man have thing gathering lights yielding shall you
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single_feature">
                        <div class="icon"><span class="flaticon-student"></span></div>
                        <div class="desc">
                            <h4 class="mt-3 mb-2">Scholarship Facility</h4>
                            <p>
                                You can get a scholarship based on the score you'll get on the final test , so Good Luck
                                .
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single_feature">
                        <div class="icon"><span class="flaticon-book"></span></div>
                        <div class="desc">
                            <h4 class="mt-3 mb-2">Download Course</h4>
                            <p>
                                Our courses are available to be downloaded , so you can learn while being disconnected .
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single_feature">
                        <div class="icon"><span class="flaticon-earth"></span></div>
                        <div class="desc">
                            <h4 class="mt-3 mb-2">Global Certification</h4>
                            <p>
                                Our certificats are globaly recommended , we can provide you the TOEFL and TOEIC tests .
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Feature Area =================-->

    <!--================ Start Testimonial Area =================-->
    <div class="testimonial_area section_gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="main_title">
                        <h2 class="mb-3">Client say about me</h2>
                        <p>
                            Replenish man have thing gathering lights yielding shall you
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
    <!--================ End footer Area  =================--

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
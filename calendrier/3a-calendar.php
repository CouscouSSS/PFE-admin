<?php
session_start();  
// MONTHS
$months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

// DEFAULT MONTH/YEAR = TODAY
$unix = strtotime("today");
$monthNow = date("M", $unix);
$yearNow = date("Y", $unix);

if (!isset($_SESSION['id'])) {
    $_SESSION['flash']['danger']="Pour accéder a cette page veuillez vous connecter,Le calendrier est seulement accesible au membre";
    header('Location: ../index.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="../img/favicon.png" type="image/png" />
    <title>Calendar</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <link rel="stylesheet" href="../css/flaticon.css" />
    <link rel="stylesheet" href="../css/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="../vendors/nice-select/css/nice-select.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- main css -->
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="..//css/css-sign/style.css">
    <link rel="stylesheet" href="../fonts/material-icon/css/material-design-iconic-font.min.css">
    <script src="public/3b-calendar.js"></script>
    <link href="public/3cc-theme.css" rel="stylesheet">
    <script src="public/3b-calendar.js"></script>
    <link href="public/3cc-theme.css" rel="stylesheet">
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

                    <?php if (isset($_SESSION['id'])) : ?>
                    <b style="font-family:Rubik; color: #FCC632;" class=" visible lead"> Bienvenue Monsieur :
                        <?= $_SESSION['name'] ?> </b>
                    <?php endif; ?>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">

                    <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="../index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../about-us.php">About</a>
                            </li>
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">Pages</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item">
                                        <a class="nav-link" href="../courses.php">Courses</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="../course-quizes.php">General culture</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item active">
                            <?php if (isset($_SESSION['id'])) : ?>
                                <a class="nav-link" href="3a-calendar.php">Calendrier</a>
                            <?php endif; ?>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="../contact.php">Contact</a>
                            </li>
                            <li class="nav-item">
                                <?php if (isset($_SESSION['id'])) : ?>
                                <a class="nav-link" href="../profil.php">Profil</a>
                                <?php endif; ?>
                            </li>
                            <li class="nav-item">
                                <?php if(isset($_SESSION['id'])) : ?>
                                <a class="nav-link" href="../deco.php">Log-out</a>
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

    <!-- Sign up form -->
    <section class="sign-in">
        <div class="container-signup" style="margin-bottom:120px;">
          <!-- [DATE SELECTOR] -->

          <div class="p-3 d-flex row justify-content-around" id="selector">

            <div>
              
            <select id="month">
              <?php
                foreach ($months as $m) {
                printf("<option %svalue='%s'>%s</option>", 
                $m==$monthNow ? "selected='selected' " : "", $m, $m
                );
                }
              ?>    
            </select>
            </div>

            <div>
            <select id="year">
              <?php
                for ($y=$yearNow; $y<=$yearNow+10; $y++) {
                  printf("<option %svalue='%s'>%s</option>",
                  $y==$yearNow ? "selected='selected' " : "", $y, $y
                  );
                }
              ?>
            </select>
            </div>
            <div >
                <input class="btn btn-outline-dark rounded" type="button" value="Set date" onclick="cal.list()" />
            </div>
          </div>
            <!-- [CALENDAR] -->
            <div class="container pb-5" id="container"> </div>

            <!-- [EVENT] -->
            <div class="container text-center" id="event"></div>
        </div>
    </section>


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
                <a href="../about-us.php">About us</a>
                </h6>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-2 mb-3">
                <h6 class="text-uppercase font-weight-bold">
                <a href="../contact.php">Contact</a>
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
        <div class="footer-copyright text-center py-3"> <b class="text-dark "> © 2020 Copyright: ARCHKAK Khalil && IZEND Hamza </b> </div>
        <!-- Copyright -->
        </div>
        <!-- Footer Links -->



        </footer>
        <!-- Footer -->
    <!--================ End footer Area  =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../vendors/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="../vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="../js/owl-carousel-thumb.min.js"></script>
    <script src="../js/jquery.ajaxchimp.min.js"></script>
    <script src="../js/mail-script.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="../js/gmaps.min.js"></script>
    <script src="../js/theme.js"></script>
    <script src="../vendor2/jquery/jquery.min.js"></script>
    <script src="../js/js-login/main.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>

</html>
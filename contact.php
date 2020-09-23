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
    <title>Contact</title>
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
                            <li class="nav-item active">
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
                            <h2>Contact Us</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="contact.php">Contact</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================Contact Area =================-->
    <section class="contact_area">
        <br>
        <h1 class="text-center">Contact Us</h1>
        <br>
        <div class="container">
            <div class="text-center pb-3"> <img src="data:image/png;base64,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" alt="image for contact"> </div>
            <br>
            <div class="row">
                <div class="col-lg-3">
                    <div class="contact_info">
                        <div class="info_item">
                            <i class="ti-home"></i>
                            <h6>Rabat-MOROCCO</h6>
                            <p></p>
                        </div>
                        <div class="info_item">
                            <i class="ti-headphone"></i>
                            <h6><a href="#">+212 615985617</a></h6>
                            <p>Monday to Friday 9am to 6 pm</p>
                        </div>
                        <div class="info_item">
                            <i class="ti-email"></i>
                            <h6><a href="#">hamzaizend666@gmail.com</a></h6>
                            <p>Send us your query anytime!</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <form class="row contact_form" action="contact_process.php" method="post" id="contactForm"
                        novalidate="novalidate">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your name" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter your name'" required="" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter email address" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter email address'" required="" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="subject" name="subject"
                                    placeholder="Enter Subject" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter Subject'" required="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea class="form-control" name="message" id="message" rows="1"
                                    placeholder="Enter Message" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter Message'" required=""></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" value="submit" class="btn primary-btn mb-4">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--================Contact Area =================-->

    <!--================ start footer Area  =================-->
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
                        <form target="_blank" action="" method="get" class="form-inline">
                            <input class="form-control" name="EMAIL" placeholder="Your Email Address"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address '"
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

    <!--================Contact Success and Error message Area =================-->
    <div id="success" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                    <h2>Thank you</h2>
                    <p>Your message is successfully sent...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals error -->

    <div id="error" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                    <h2>Sorry !</h2>
                    <p>Something went wrong</p>
                </div>
            </div>
        </div>
    </div>
    <!--================End Contact Success and Error message Area =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/stellar.js"></script>
    <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="js/owl-carousel-thumb.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/mail-script.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/contact.js"></script>
    <script src="js/theme.js"></script>
    <script>
        $(".alert").delay(5000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>
</body>

</html>
<?php
session_start();  
include "connexion.inc.php";

if(!isset($_SESSION['id'])){

    if(isset($_POST['signin'])){
        
        $name=htmlspecialchars($_POST['name']);
        $email=htmlspecialchars($_POST['email']);
        $password= password_hash($_POST['password'],PASSWORD_BCRYPT);

        if(!empty($email) AND !empty($password)){
            $requser = $bdd->prepare("SELECT * FROM membre WHERE email=?");
            $requser->execute(array($email));
            $userexist = $requser->rowCount();
            $userinfo = $requser->fetch();

            if($userinfo['role'] === 'admin'){
                if($_POST['password']=='root'){
                    $_SESSION['id'] = $userinfo['id'];
                    $_SESSION['name']= $userinfo['name'];
                    $_SESSION['email'] = $userinfo['email'];
                    $_SESSION['role'] = $userinfo['role'];
                    header('Location:admin/index.php');
                    exit();
                }else{
                $erreur = "Veuillez verifier votre mot de passe ou email ";
                }
            }

            if($userinfo['role'] === 'admin_membre' || $userinfo['role'] === 'admin_cours'){
                if(password_verify($_POST['password'],$userinfo['password'])){
                    $_SESSION['id'] = $userinfo['id'];
                    $_SESSION['name']= $userinfo['name'];
                    $_SESSION['email'] = $userinfo['email'];
                    $_SESSION['role'] = $userinfo['role'];
                    header('Location:admin/index.php');
                    exit();
                }else{
                $erreur = "Veuillez verifier votre mot de passe ou email ";
                }
            }

            if($userexist && password_verify($_POST['password'],$userinfo['password'])){       
                if($userinfo['confirmed_at']){
                    $_SESSION['id'] = $userinfo['id'];
                    $_SESSION['email'] = $userinfo['email'];
                    $_SESSION['name'] = $userinfo['name'];
                    $_SESSION['flash']['success']="Vous etes maintenant connecté";
                    header('location:index.php?id='.$_SESSION['id']);
                    exit();    
                }else{
                    $_SESSION['flash']['success']="Veuillez d'abord confirmez votre compte , veuillez cliquez sur le lien envoyé a votre boite mail";
                }
            }else{
                $erreur = "*Mauvais mail ou Mot de passe ";
            }
        }else{
            $erreur = "*Tous les champs doivent être complétés";
        }
    }
}else{
    $_SESSION['flash']['danger']="Vous n'avais pas accés a cette page car vous etes déja connecté";
    header('location:index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="img/favicon.png" type="image/png" />
    <title>Sign in</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="./css/css-sign/style.css">
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
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
                    <b class="lead">Bienvenue Monsieur <?= $_SESSION['name'] ?> </b>
                    <?php endif; ?>

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

    <!-- Sign up form -->
    <section class="sign-in">
        <div class="container-signup" style="margin-bottom:120px;">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="img/sign/signin-image.jpg" alt="sing up image"></figure>
                    <a href="register.php" class="signup-image-link btn btn-outline-dark">Create an account</a>
                </div>
                <div class="signin-form">
                    <form method="POST" class="register-form pt-3" id="login-form">
                        <fieldset style="border:3px solid black;" class="p-3 border-dark rounded ">
                            <legend style="width:auto; letter-spacing: 1px;" class="pr-3 pl-3 "> Sign-in </legend>
                            <div class="form-group">
                                <label for="your_mail"><i class="fas fa-envelope"></i></label>
                                <input type="text" name="email" id="your_name" placeholder="E-mail" />
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="fas fa-lock"></i></label>
                                <input type="password" name="password" id="your_pass" placeholder="Password" />
                            </div>

                            <div class="text-right">
                                <span class="text-primary mb-2"> <i class="fas fa-unlock-alt"></i> </span><a style=" font-family: 'Open Sans', sans-serif; font-size:14px; font-weight:bold;" href="recover.php"> Mot de passe oublié ? </a>
                            </div>

                            <?php if(isset($erreur)) : ?>
                            <b style="letter-spacing:1px;" class="text-danger"> <?= $erreur ?> </b>
                            <?php endif; ?>
                            <div class="form-group form-button">
                                <button class="btn btn-lg btn-outline-dark btn-block" type="submit" name="signin"
                                    id="signin"> Login</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </div>

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
    <script src="vendor2/jquery/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/6e8ba3d05b.js" crossorigin="anonymous"></script>
    <script src="js/js-login/main.js"></script>
    <script>
        $(".alert").delay(5000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>

</body>

</html>
<?php
session_start();

include "connexion.inc.php";

if (!isset($_SESSION['id'])) {
  $_SESSION['flash']['danger']="Pour accéder au exercices veuillez vous connecter";
  header('Location: index.php');
  exit();
}

if(isset($_SESSION['role'])){
    if($_SESSION['role']=="admin" || $_SESSION['role']=="admin_cours"){
        header('Location:admin/index.php');
        $_SESSION['flash']['danger']="Vous ne pouvez pas accéder au site avec votre compte administrateur";
        exit();
    }
}

$requete= $bdd->prepare('SELECT id FROM resultat WHERE id_user=? and num=? and etat=?');
$requete->execute(array($_SESSION['id'],5008,'Test Reussi'));
$ok=$requete->rowCount();
if($ok){
    $_SESSION['flash']['danger']="Vous avez déja réussi ce test vous pouvez passé au test suivant";
    header('Location: course-quizes.php');
    exit();
}


$score = 0;

if(isset($_POST['submit'])){
  
if(isset($_POST['x1']) AND $_POST['x1'] == "3"){
  $score++;
}
if(isset($_POST['x2']) AND $_POST['x2'] == "1"){
  $score++;
}
if(isset($_POST['x3']) AND $_POST['x3'] == "3"){
  $score++;
}
if(isset($_POST['x4']) AND $_POST['x4'] == "3"){
  $score++;
}
if(isset($_POST['x5']) AND $_POST['x5'] == "2"){
  $score++;
}
if(isset($_POST['x6']) AND $_POST['x6'] == "1"){
  $score++;
}
if(isset($_POST['x7']) AND $_POST['x7'] == "3"){
  $score++;
}
if(isset($_POST['x8']) AND $_POST['x8'] == "2"){
  $score++;
}
if(isset($_POST['x9']) AND $_POST['x9'] == "2"){
  $score++;
}
if(isset($_POST['x10']) AND $_POST['x10'] == "2"){
  $score++;
}


$resultat = "Votre score est de ".$score." /10";

if($score == 10){
    $res_success = "Félécitations vous avez réussi le test ";
    $insert=$bdd->prepare("INSERT INTO resultat(id_user,num,etat) VALUES(?,?,?)");
    $delete=$bdd->prepare("DELETE FROM resultat WHERE etat=? AND id_user=? AND num=?");
    $insert->execute(array($_SESSION['id'],5008,'Test Reussi'));
    $delete->execute(array('Test Pas Reussi',$_SESSION['id'],5008));
    $_SESSION['flash']['success']=$res_success ." <br> ".$resultat;
    header('Location: course-quizes.php');
    exit();
    }else{
        $res_fail = "EMM Dommage , vous pouvez réessayer ";
          $find=$bdd->prepare("SELECT id FROM resultat WHERE id_user=? AND num=? AND etat=?");
          $find->execute(array($_SESSION['id'],5008,'Test Pas Reussi'));
          $ok=$find->rowCount();
        if(!$ok){ 
          $insert=$bdd->prepare("INSERT INTO resultat(id_user,num,etat) VALUES(?,?,?)");
          $insert->execute(array($_SESSION['id'],5008,'Test Pas Reussi'));
          $_SESSION['flash']['danger']=$res_fail ." <br> ".$resultat;
        }
        else{
        $updatereq=$bdd->prepare("UPDATE resultat SET etat = Test Pas Reussi WHERE id_user=? and num=? ");
        $updatereq->execute(array($_SESSION['id'],5008));
        $_SESSION['flash']['danger']=$res_fail ." <br> ".$resultat;
        }
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
    <title>Courses Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />

    <style>
    p,
    label {
        font: 1rem 'Fira Sans', sans-serif;
    }

    input {
        margin: .4rem;
    }
    </style>







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
                                <a class="nav-link" href="home.php">Home</a>
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
                                <a href="home.php">Home</a>
                                <a href="courses.php">Courses</a>
                                <a href="course-details.php">Courses Details</a>
                                <a href="course-detail.php">Culture Générale</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================ Start Course Details Area =================-->
   <section class="course_details_area bg-light text-center">
        <br>
        <h2 class="text-capitalize text-success display-4 font-weight-bold "><i class="fas fa-feather-alt" style="transform:rotateZ(180deg);"></i> Quizz 3 - Expert level <i class="fas fa-feather-alt" style="transform: rotate(180deg) rotateY(180deg);"></i></h2>
        <form method="POST">
            <br>
            <img src="https://i2.wp.com/cms.babbel.news/wp-content/uploads/2017/11/Nouveaux-Mots-Dictionnaire-Header.jpg?h=9999&quality=100&w=993" width="800" height="400">
            <br>
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 1 -</b> Choisissez la bonne forme : Jean-Mi n’arrête pas de … Gisèle. </legend>
            <input type="radio" name="x1" value="1" > déblatérer sur  <?php if(isset($_POST['x1']) AND $_POST['x1'] == "1"){
                
                            echo "<font color='red'>  x  </font>"; } ?>
                            <br>

            <input type="radio" name="x1" value="2"> déblatérer sur  <?php if(isset($_POST['x1']) AND $_POST['x1'] == "2"){
                           
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
             <input type="radio" name="x1" value="3"> déblatérer contre <?php if(isset($_POST['x1']) AND $_POST['x1'] == "3"){
                           
                            echo "<font color='green'>  ✔  </font>";
                           } ?>
            
                           <br>
                           <br>

                           <img src="https://previews.123rf.com/images/argus456/argus4561702/argus456170219463/72130958-grunge-old-afghanistan-flag.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 2 -</b> Quelles sont les langues officielles de l’Afghanistan ?</legend>
            <input type="radio" name="x2" value="1"> Persan et pashtou .<?php if(isset($_POST['x2']) AND $_POST['x2'] == "1"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
<br>
            <input type="radio" name="x2" value="2"> Hindi et turc . <?php if(isset($_POST['x2']) AND $_POST['x2'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
                            <input type="radio" name="x2" value="3"> Arab et turc . <?php if(isset($_POST['x2']) AND $_POST['x2'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
                            <input type="radio" name="x2" value="4"> Afghan et anglais .<?php if(isset($_POST['x2']) AND $_POST['x2'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <br>

            <img src="https://s.rfi.fr/media/display/f29c7986-16cd-11ea-991e-005056bf7c53/w:1240/p:16x9/sykes-picot_0.webp" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 3 -</b> Que décident les accords de Sykes-Picot de 1916 ?</legend>
            <input type="radio" name="x3" value="1"> Le décombrement de l'empire allemand . <?php if(isset($_POST['x3']) AND $_POST['x3'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x3" value="2"> La division du Proche-Orient entre Français et Anglais . <?php if(isset($_POST['x3']) AND $_POST['x3'] == "2"){
                            
                            echo "<font color='green'>  ✔  </font>";
                           } ?> <br>
                           <input type="radio" name="x3" value="3"> Le partage des colonies allemandes .<?php if(isset($_POST['x3']) AND $_POST['x3'] == "3"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?> <br>
                           <input type="radio" name="x3" value="4"> La lutte contre la Russie bolchévique . <?php if(isset($_POST['x3']) AND $_POST['x3'] == "4"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?> <br>
            <br>
            <img src="https://www.woimacorporation.com/wp-content/uploads/2019/01/Beirut-Libanon-Landscape-Drowning-in-Waste-WOIMA-Corporation.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 ">  <b> 4 -</b> À quel type d’œuvre est consacré le festival de Bayreuth ?</legend>
            <input type="radio" name="x4" value="1"> À la musique de chambre . <?php if(isset($_POST['x4']) AND $_POST['x4'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?>
<br>
            <input type="radio" name="x4" value="2"> À la symphonie . <?php if(isset($_POST['x4']) AND $_POST['x4'] == "2"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
                           <input type="radio" name="x4" value="3">  À l'opéra .<?php if(isset($_POST['x4']) AND $_POST['x4'] == "3"){
                            
                            echo "<font color='green'>  ✔  </font>";
                           } ?><br>
                           <input type="radio" name="x4" value="4">  Au ballet . <?php if(isset($_POST['x4']) AND $_POST['x4'] == "4"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
            <br>
             <img src="https://www.babelio.com/users/QUIZ_Qui-a-dit--La-nature_2110.jpeg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 5 -</b> « Peu importe si le chat est blanc ou noir du moment qu’il attrape les souris. » À qui doit-on cette sentence ?</legend>
            <input type="radio" name="x5" value="1"> François Mitterand <?php if(isset($_POST['x5']) AND $_POST['x5'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x5" value="2"> Deng Xiao Ping <?php if(isset($_POST['x5']) AND $_POST['x5'] == "2"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <input type="radio" name="x5" value="3"> Fidel Castro  <?php if(isset($_POST['x5']) AND $_POST['x5'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x5" value="4"> Reagan <?php if(isset($_POST['x5']) AND $_POST['x5'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>

            <img src="https://geeko.lesoir.be/wp-content/uploads/sites/58/2018/12/expo-Vermeer.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 6 -</b> Qui a peint ce tableau ? </legend>
            <input type="radio" name="x6" value="1"> Vermeer  <?php if(isset($_POST['x6']) AND $_POST['x6'] == "1"){
                            echo "<font color='green'>  ✔  </font>"; } ?><br>
            <input type="radio" name="x6" value="2"> Rembrandt  <?php if(isset($_POST['x6']) AND $_POST['x6'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x6" value="3"> Van Gogh <?php if(isset($_POST['x6']) AND $_POST['x6'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x6" value="4"> Rubens  <?php if(isset($_POST['x6']) AND $_POST['x6'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>
            <img src="https://www.actualitte.com/images/actualites/images/Les%20ensables/les-dieux-ont-soif-anatole-france.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 7 -</b> De quel épisode historique traite « Les Dieux ont soif » d’Anatole France ?</legend>
            <input type="radio" name="x7" value="1"> De la Fronde . <?php if(isset($_POST['x7']) AND $_POST['x7'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x7" value="2"> Du massacre de la Saint-Barthélemy . <?php if(isset($_POST['x7']) AND $_POST['x7'] == "2"){
                            echo "<font color='red'>  x </font>"; } ?>
            <br>
            <input type="radio" name="x7" value="3"> De la terreur . <?php if(isset($_POST['x7']) AND $_POST['x7'] == "3"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <input type="radio" name="x7" value="4"> De l'affaire Dreyfus . <?php if(isset($_POST['x7']) AND $_POST['x7'] == "4") {
                            echo "<font color='red'>  x </font>"; } ?>
            <br>
            <br>
<img src="https://lnt.ma/wp-content/uploads/2018/11/chapo-925x430.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 8 -</b> Quel cartel « El Chapo » dirige-t-il ?</legend>
            <input type="radio" name="x8" value="1"> Le cartel de Tijuana . <?php if(isset($_POST['x8']) AND $_POST['x8'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x8" value="2"> Le cartel de Sinaloa . <?php if(isset($_POST['x8']) AND $_POST['x8'] == "2"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <input type="radio" name="x8" value="3"> Le cartel de Medellin . <?php if(isset($_POST['x8']) AND $_POST['x8'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x8" value="4"> Le cartel de Juarez . <?php if(isset($_POST['x8']) AND $_POST['x8'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>
            <img src="https://jeunes-ihedn.org/wp-content/uploads/2019/11/thumb2-democratic-republic-of-the-congo-flag-4k-grunge-flag-of-democratic-republic-of-congo-africa.jpg.png" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 9 -</b> Quel animal endémique ne trouve-t-on qu’en République démocratique du Congo ?</legend>
            <input type="radio" name="x9" value="1"> L'oryx <?php if(isset($_POST['x9']) AND $_POST['x9'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x9" value="2"> L'okapi <?php if(isset($_POST['x9']) AND $_POST['x9'] == "2"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
             <input type="radio" name="x9" value="3"> La grue royale <?php if(isset($_POST['x9']) AND $_POST['x9'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x9" value="4"> Le trogon <?php if(isset($_POST['x9']) AND $_POST['x9'] == "4"){ 
                            echo "<font color='red'>  x  </font>"; } ?>

                ?>            <br>
            <br>
            <img src="https://cache.marieclaire.fr/data/photo/w1000_ci/4x/jodie-foster.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 10 -</b> Quel film révèle Jodie Foster au grand public ?</legend>
            <input type="radio" name="x10" value="1"> Ragging bull <?php if(isset($_POST['x10']) AND $_POST['x10'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x10" value="2"> Taxi driver <?php if(isset($_POST['x10']) AND $_POST['x10'] == "2"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
             <input type="radio" name="x10" value="3"> Le silence des agneaux <?php if(isset($_POST['x10']) AND $_POST['x10'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x10" value="4"> Casino  <?php if(isset($_POST['x10']) AND $_POST['x10'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>
            <input class="btn btn-outline-dark pl-5 pr-5" type="submit" name="submit" value="Finish">

        </form>

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
    <script src="https://kit.fontawesome.com/6e8ba3d05b.js" crossorigin="anonymous"></script>
    <script src="js/theme.js"></script>
    <script>
        $(".alert").delay(5000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>
</body>

</html>
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
$requete->execute(array($_SESSION['id'],5003,'Test Reussi'));
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
if(isset($_POST['x2']) AND $_POST['x2'] == "2"){
  $score++;
}
if(isset($_POST['x3']) AND $_POST['x3'] == "4"){
  $score++;
}
if(isset($_POST['x4']) AND $_POST['x4'] == "4"){
  $score++;
}
if(isset($_POST['x5']) AND $_POST['x5'] == "1"){
  $score++;
}
if(isset($_POST['x6']) AND $_POST['x6'] == "3"){
  $score++;
}
if(isset($_POST['x7']) AND $_POST['x7'] == "3"){
  $score++;
}
if(isset($_POST['x8']) AND $_POST['x8'] == "4"){
  $score++;
}
if(isset($_POST['x9']) AND $_POST['x9'] == "1"){
  $score++;
}
if(isset($_POST['x10']) AND $_POST['x10'] == "4"){
  $score++;
}


$resultat = "Votre score est de ".$score." /10";

if($score == 10){
    $res_success = "Félécitations vous avez réussi le test ";
    $insert=$bdd->prepare("INSERT INTO resultat(id_user,num,etat) VALUES(?,?,?)");
    $delete=$bdd->prepare("DELETE FROM resultat WHERE etat=? AND id_user=? AND num=?");
    $insert->execute(array($_SESSION['id'],5003,'Test Reussi'));
    $delete->execute(array('Test Pas Reussi',$_SESSION['id'],5003));
    $_SESSION['flash']['success']=$res_success ." <br> ".$resultat;
    header('Location: course-quizes.php');
    exit();
    }else{
        $res_fail = "EMM Dommage , vous pouvez réessayer ";
          $find=$bdd->prepare("SELECT id FROM resultat WHERE id_user=? AND num=? AND etat=?");
          $find->execute(array($_SESSION['id'],5003,'Test Pas Reussi'));
          $ok=$find->rowCount();
        if(!$ok){ 
          $insert=$bdd->prepare("INSERT INTO resultat(id_user,num,etat) VALUES(?,?,?)");
          $insert->execute(array($_SESSION['id'],5003,'Test Pas Reussi'));
          $_SESSION['flash']['danger']=$res_fail ." <br> ".$resultat;
        }
        else{
        $updatereq=$bdd->prepare("UPDATE resultat SET etat = Test Pas Reussi WHERE id_user=? and num=? ");
        $updatereq->execute(array($_SESSION['id'],5003));
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
                                <a href="course-detail.php">Grammar</a>

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
            <h2 class="text-capitalize text-success display-4 font-weight-bold "><i class="fas fa-feather-alt" style="transform:rotateZ(180deg);"></i> Quizz 1 - Intermediar level <i class="fas fa-feather-alt" style="transform: rotate(180deg) rotateY(180deg);"></i></h2>

        <form method="POST">
            <br>
            <img src="https://f.hypotheses.org/wp-content/blogs.dir/1157/files/2013/08/483px-Raffael_067.jpg" height="400" width="800">
            <br>
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 1 -</b> De quel courant philosophique Plotin est-il le grand représentant ?</legend>
            <input type="radio" name="x1" value="1"> L'aristotélisme  <?php if(isset($_POST['x1']) AND $_POST['x1'] == "1"){
                
                            echo "<font color='red'>  x  </font>"; } ?>
                            <br>

            <input type="radio" name="x1" value="2"> Le scepticisme  <?php if(isset($_POST['x1']) AND $_POST['x1'] == "2"){
                           
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
             <input type="radio" name="x1" value="3"> Le néoplatonisme  <?php if(isset($_POST['x1']) AND $_POST['x1'] == "3"){
                           
                            echo "<font color='green'>  ✔  </font>"; 
                           } ?>
            <br>
             <input type="radio" name="x1" value="4"> Le stoïcisme  <?php if(isset($_POST['x1']) AND $_POST['x1'] == "4"){
                           
                            echo "<font color='red'>  x  </font>"; 
                           } ?>
                           <br>
                           <br>

                           <img src="https://static.rogerebert.com/uploads/review/primary_image/reviews/in-the-mood-for-love-2001/Mood-For-Love-201.jpg" height="400" width="800">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 2 -</b> Qui a réalisé le film « In the mood for love » ?</legend>
            <input type="radio" name="x2" value="1"> Zhang Yimou <?php if(isset($_POST['x2']) AND $_POST['x2'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?>
<br>
            <input type="radio" name="x2" value="2"> Wong Kar-Wai <?php if(isset($_POST['x2']) AND $_POST['x2'] == "2"){
                             echo "<font color='green'>  ✔  </font>"; } ?><br>
                            <input type="radio" name="x2" value="3"> Chan Feng Zhao <?php if(isset($_POST['x2']) AND $_POST['x2'] == "3"){
                            echo "<font color='red'>  x   </font>"; } ?><br>
                            <input type="radio" name="x2" value="4"> Scorsese <?php if(isset($_POST['x2']) AND $_POST['x2'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <br>

            <img src="https://cdnuploads.aa.com.tr/uploads/Contents/2019/01/24/thumbs_b_c_7cad2e15b901fdc92839ca17c73574f5.jpg?v=011801" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 3 -</b> Parmi les hommes politiques suivants, lequel a succédé à Hugo Chavez en tant que Président du Venezuela ?</legend>
            <input type="radio" name="x3" value="1"> Rafael Correa <?php if(isset($_POST['x3']) AND $_POST['x3'] == "1") {
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x3" value="2"> Evo Morales <?php if(isset($_POST['x3']) AND $_POST['x3'] == "2"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?> <br>
                           <input type="radio" name="x3" value="3"> Lula <?php if(isset($_POST['x3']) AND $_POST['x3'] == "3"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?> <br>
                           <input type="radio" name="x3" value="4"> Nicolas Maduro <?php if(isset($_POST['x3']) AND $_POST['x3'] == "4"){
                            
                            echo "<font color='green'>  ✔  </font>";
                           } ?> <br>
            <br>
            <img src="data:image/jpeg;base64,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" height="400" width="800">
            <legend class="font-weight-bold text-dark pb-2 pt-4 ">  <b> 4 -</b> De l’œuvre de quel écrivain est tirée la célèbre question « Que sais-je ? »</legend>
            <input type="radio" name="x4" value="1"> Voltaire <?php if(isset($_POST['x4']) AND $_POST['x4'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?>
<br>
            <input type="radio" name="x4" value="2"> Étienne de la Boétie <?php if(isset($_POST['x4']) AND $_POST['x4'] == "2"){
                            
                            echo "<font color='red'>  x   </font>"; 
                           } ?><br>
                           <input type="radio" name="x4" value="3"> Diderot   <?php if(isset($_POST['x4']) AND $_POST['x4'] == "3"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
                           <input type="radio" name="x4" value="4">  Montaigne  <?php if(isset($_POST['x4']) AND $_POST['x4'] == "4"){
                            
                            echo "<font color='green'>  ✔  </font>";
                           } ?><br>
            <br>
             <img src="https://i.pinimg.com/originals/28/ab/16/28ab1600c526d6c157b1adf2bbfed3e1.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 5 -</b> Quelle année retient-on habituellement comme l’année de la chute de l’Empire romain d’Occident ?</legend>
            <input type="radio" name="x5" value="1"> 476 ap. J.-C. <?php if(isset($_POST['x5']) AND $_POST['x5'] == "1"){
                            echo "<font color='green'>  ✔  </font>"; } ?><br>
            <input type="radio" name="x5" value="2"> 410 ap. J.-C. <?php if(isset($_POST['x5']) AND $_POST['x5'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x5" value="3"> 375 ap. J-.C. <?php if(isset($_POST['x5']) AND $_POST['x5'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x5" value="4"> 496 ap. J.-C. <?php if(isset($_POST['x5']) AND $_POST['x5'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>

            <img src="http://dessin-creation.com/wp-content/uploads/2015/01/cours-de-dessin-gratuit.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 6 -</b> Quelle race d’animal est un briard ?</legend>
            <input type="radio" name="x6" value="1"> Un canard  <?php if(isset($_POST['x6']) AND $_POST['x6'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x6" value="2"> Un chat <?php if(isset($_POST['x6']) AND $_POST['x6'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x6" value="3"> Un chien <?php if(isset($_POST['x6']) AND $_POST['x6'] == "3") {
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <input type="radio" name="x6" value="4"> Un cheval <?php if(isset($_POST['x6']) AND $_POST['x6'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>
            <img src="https://www.napolike.it/wp-content/uploads/2018/01/mozart.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 7 -</b> Où est né Mozart ?</legend>
            <input type="radio" name="x7" value="1"> Turin <?php if(isset($_POST['x7']) AND $_POST['x7'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x7" value="2"> Venise <?php if(isset($_POST['x7']) AND $_POST['x7'] == "2"){
                            echo "<font color='red'>  x </font>"; } ?>
            <br>
            <input type="radio" name="x7" value="3"> Salsbourg <?php if(isset($_POST['x7']) AND $_POST['x7'] == "3"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <input type="radio" name="x7" value="4"> Vienne <?php if(isset($_POST['x7']) AND $_POST['x7'] == "4"){
                            echo "<font color='red'>  x </font>"; } ?>
            <br>
            <br>
<img src="https://static.latribune.fr/full_width/1423775/l-allemagne-designe-le-hezbollah-libanais-comme-organisation-terroriste.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 8 -</b> Combien d’états fédérés (Länder) l’Allemagne compte-t-elle ?</legend>
            <input type="radio" name="x8" value="1"> 24 <?php if(isset($_POST['x8']) AND $_POST['x8'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x8" value="2"> 8 <?php if(isset($_POST['x8']) AND $_POST['x8'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x8" value="3"> 4 <?php if(isset($_POST['x8']) AND $_POST['x8'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x8" value="4"> 16 <?php if(isset($_POST['x8']) AND $_POST['x8'] == "4"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <br>
            <img src="https://www.leparisien.fr/resizer/9ryEFwIfjOm9VF-v5JVb8ek7lH0=/932x582/arc-anglerfish-eu-central-1-prod-leparisien.s3.amazonaws.com/public/6VTJ7JHKBBTRKO2KMSUVVYOQOE.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 9 -</b> Que signifie « procrastiner » ?</legend>
            <input type="radio" name="x9" value="1"> Remettre à plus tard quelque chose  <?php if(isset($_POST['x9']) AND $_POST['x9'] == "1"){
                            echo "<font color='green'>  ✔  </font>"; } ?><br>
            <input type="radio" name="x9"  value="2"> Parler dans un langage particulièrement vulgaire  <?php if(isset($_POST['x9']) AND $_POST['x9'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x9" value="3"> Contredire systématiquement son interlocuteur  <?php if(isset($_POST['x9']) AND $_POST['x9'] == "3")  {
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x9" value="4"> Étudier beaucoup en vue d'un examen  <?php if(isset($_POST['x9']) AND $_POST['x9'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>
            <img src="https://www.fredzone.org/wp-content/uploads/2017/12/newton.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 10 -</b> Quelle théorie doit-on à Isaac Newton ?</legend>
            <input type="radio" name="x10" value="1"> La théorie atomique<?php if(isset($_POST['x10']) AND $_POST['x10'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x10" value="2"> La théorie de l'évolution des espèces  <?php if(isset($_POST['x10']) AND $_POST['x10'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x10" value="3"> La théorie des cordes  <?php if(isset($_POST['x10']) AND $_POST['x10'] == "3") {
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x10" value="4"> La théorie de la gravitation universelle  <?php if(isset($_POST['x10']) AND $_POST['x10'] == "4"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
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
    <script src="https://kit.fontawesome.com/6e8ba3d05b.js" crossorigin="anonymous"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/theme.js"></script>
    <script>
        $(".alert").delay(5000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>
</body>

</html>
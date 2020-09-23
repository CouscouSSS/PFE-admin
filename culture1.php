<?php
session_start();

include "connexion.inc.php";

if(isset($_SESSION['role'])){
    if($_SESSION['role']=="admin" || $_SESSION['role']=="admin_cours"){
        header('Location:admin/index.php');
        $_SESSION['flash']['danger']="Vous ne pouvez pas accéder au site avec votre compte administrateur";
        exit();
    }
}

if (!isset($_SESSION['id'])) {
  $_SESSION['flash']['danger']="Pour accéder au exercices veuillez vous connecter";
  header('Location: index.php');
  exit();
}

$requete= $bdd->prepare('SELECT id FROM resultat WHERE id_user=? and num=? and etat=?');
$requete->execute(array($_SESSION['id'],5000,'Test Reussi'));
$ok=$requete->rowCount();
if($ok){
    $_SESSION['flash']['danger']="Vous avez déja réussi ce test vous pouvez passé au test suivant";
    header('Location: course-quizes.php');
    exit();
}

$score = 0;

if(isset($_POST['submit'])){
  
if(isset($_POST['x1']) AND $_POST['x1'] == "4"){
  $score++;
}
if(isset($_POST['x2']) AND $_POST['x2'] == "4"){
  $score++;
}
if(isset($_POST['x3']) AND $_POST['x3'] == "4"){
  $score++;
}
if(isset($_POST['x4']) AND $_POST['x4'] == "2"){
  $score++;
}
if(isset($_POST['x5']) AND $_POST['x5'] == "1"){
  $score++;
}
if(isset($_POST['x6']) AND $_POST['x6'] == "1"){
  $score++;
}
if(isset($_POST['x7']) AND $_POST['x7'] == "2"){
  $score++;
}
if(isset($_POST['x8']) AND $_POST['x8'] == "4"){
  $score++;
}
if(isset($_POST['x9']) AND $_POST['x9'] == "3"){
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
    $insert->execute(array($_SESSION['id'],5000,'Test Reussi'));
    $delete->execute(array('Test Pas Reussi',$_SESSION['id'],5000));
    $_SESSION['flash']['success']=$res_success ." <br> ".$resultat;
    header('Location: course-quizes.php');
    exit();
    }else{
        $res_fail = "EMM Dommage , vous pouvez réessayer ";
          $find=$bdd->prepare("SELECT id FROM resultat WHERE id_user=? AND num=? AND etat=?");
          $find->execute(array($_SESSION['id'],5000,'Test Pas Reussi'));
          $ok=$find->rowCount();
        if(!$ok){ 
          $insert=$bdd->prepare("INSERT INTO resultat(id_user,num,etat) VALUES(?,?,?)");
          $insert->execute(array($_SESSION['id'],5000,'Test Pas Reussi'));
          $_SESSION['flash']['danger']=$res_fail ." <br> ".$resultat;
        }
        else{
        $updatereq=$bdd->prepare("UPDATE resultat SET etat = Test Pas Reussi WHERE id_user=? and num=? ");
        $updatereq->execute(array($_SESSION['id'],5000));
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
                            <h1 class="text-white font-weight-bold " style="letter-spacing:2px;"> General Culture Quizzs</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================ Start Course Details Area =================-->
   <section class="course_details_area  bg-light text-center lead">
   <br>
   <h2 class="text-capitalize text-success display-4 font-weight-bold "><i class="fas fa-feather-alt" style="transform:rotateZ(180deg);"></i> Quizz 1 - Beginner level <i class="fas fa-feather-alt" style="transform: rotate(180deg) rotateY(180deg);"></i></h2>

        <form method="POST">
           
        <br>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/CroppedStalin1943.jpg/220px-CroppedStalin1943.jpg" width="800" height="400">
            <br>
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 1 - </b>  Quel célèbre dictateur dirigea l’URSS du milieu des années 1920 à 1953 ? </legend>
            <input type="radio" name="x1" value="1" > Trotski <?php if(isset($_POST['x1']) AND $_POST['x1'] == "1"){
                
                            echo "<font color='red'>  x  </font>"; } ?>
                            <br>

            <input type="radio" name="x1" value="2"> Lénine <?php if(isset($_POST['x1']) AND $_POST['x1'] == "2"){
                           
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
             <input type="radio" name="x1" value="3"> Motolov <?php if(isset($_POST['x1']) AND $_POST['x1'] == "3"){
                           
                            echo "<font color='red'>  x  </font>"; 
                           } ?>
            <br>
             <input type="radio" name="x1" value="4"> Staline <?php if(isset($_POST['x1']) AND $_POST['x1'] == "4"){
                           
                            echo "<font color='green'>  ✔  </font>"; 
                           } ?>
                           <br>
                           <br>

                           <img src="https://resize-europe1.lanmedia.fr/img/var/europe1/storage/images/media/images/drapeau-de-la-catalogne/44529638-1-fre-FR/Drapeau-de-la-Catalogne.png" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 2 -</b> Dans quel pays peut-on trouver la Catalogne, l’Andalousie et la Castille ?</legend>
            <input type="radio" name="x2" value="1"> Le Portugal <?php if(isset($_POST['x2']) AND $_POST['x2'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?>
<br>
            <input type="radio" name="x2" value="2"> L'Italie <?php if(isset($_POST['x2']) AND $_POST['x2'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
                            <input type="radio" name="x2" value="3"> La France <?php if(isset($_POST['x2']) AND $_POST['x2'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
                            <input type="radio" name="x2" value="4"> L'Espagne<?php if(isset($_POST['x2']) AND $_POST['x2'] == "4"){
                            echo "<font color='green'>  ✔  </font>"; } ?><br>
            <br>

            <img src="https://toutpourlejeu.com/1065-medium_default/grand-de-a-jouer-32-mm-de-1-a-6-.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 3 -</b> Qui a dit : « Le sort en est jeté » (Alea jacta est) ?</legend>
            <input type="radio" name="x3" value="1"> Vercingétorix <?php if(isset($_POST['x3']) AND $_POST['x3'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x3" value="2"> Auguste <?php if(isset($_POST['x3']) AND $_POST['x3'] == "2"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?> <br>
                           <input type="radio" name="x3" value="3"> Attila <?php if(isset($_POST['x3']) AND $_POST['x3'] == "3"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?> <br>
                           <input type="radio" name="x3" value="4"> César <?php if(isset($_POST['x3']) AND $_POST['x3'] == "4"){
                            
                            echo "<font color='green'>  ✔  </font>"; 
                           } ?> <br>
            <br>
            <img src="https://img-4.linternaute.com/Qz81ml7dAr0wfho1xXZkMx7zUGA=/620x/smart/45f0ae961471407ebeb80551557ed386/ccmcms-linternaute/10759231.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 ">  <b> 4 -</b> Quel cinéaste a réalisé « Parle avec elle » et « Volver » ? </legend>
            <input type="radio" name="x4" value="1"> Guillermo del Toro <?php if(isset($_POST['x4']) AND $_POST['x4'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?>
<br>
            <input type="radio" name="x4" value="2"> Pedro Almodovar <?php if(isset($_POST['x4']) AND $_POST['x4'] == "2"){
                            
                            echo "<font color='green'>  ✔  </font>"; 
                           } ?><br>
                           <input type="radio" name="x4" value="3">  Woody Allen <?php if(isset($_POST['x4']) AND $_POST['x4'] == "3"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
                           <input type="radio" name="x4" value="4">  Pablo Trapero <?php if(isset($_POST['x4']) AND $_POST['x4'] == "4"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
            <br>
             <img src="https://bdn-data.s3.amazonaws.com/uploads/2017/06/16548361_H20577819-600x407.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 5 -</b> À qui doit-on la chanson « I Shot the Sheriff » ?e</legend>
            <input type="radio" name="x5" value="1"> Bob Marley <?php if(isset($_POST['x5']) AND $_POST['x5'] == "1"){
                            echo "<font color='green'>  ✔  </font>"; } ?><br>
            <input type="radio" name="x5" value="2"> UB40 <?php if(isset($_POST['x5']) AND $_POST['x5'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x5" value="3"> Jim Morrison <?php if(isset($_POST['x5']) AND $_POST['x5'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x5" value="4"> Eric Clapton <?php if(isset($_POST['x5']) AND $_POST['x5'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>

            <img src="https://static.onzemondial.com/photo_article/154867/30262/1200-L-coupe-du-monde-2014-l-equipe-type-onze-mondial.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 6 -</b> Quel pays a remporté la coupe du monde de football en 2014 ?</legend>
            <input type="radio" name="x6" value="1"> L'allemagne <?php if(isset($_POST['x6']) AND $_POST['x6'] == "1"){
                            echo "<font color='green'>  ✔  </font>"; } ?><br>
            <input type="radio" name="x6" value="2"> L'argentine <?php if(isset($_POST['x6']) AND $_POST['x6'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x6" value="3"> L'Italie <?php if(isset($_POST['x6']) AND $_POST['x6'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x6" value="4"> Le Brésil <?php if(isset($_POST['x6']) AND $_POST['x6'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Shakespeare.jpg/1280px-Shakespeare.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 7 -</b> Dans quelle ville italienne l’action de la pièce de Shakespeare « Roméo et Juliette » se situe-t-elle ? </legend>
            <input type="radio" name="x7" value="1"> Milan <?php if(isset($_POST['x7']) AND $_POST['x7'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x7" value="2"> Vérone <?php if(isset($_POST['x7']) AND $_POST['x7'] == "2"){
                            echo "<font color='green'>  ✔ </font>"; } ?>
            <br>
            <input type="radio" name="x7" value="3"> Rome <?php if(isset($_POST['x7']) AND $_POST['x7'] == "3"){
                            echo "<font color='red'>  x </font>"; } ?>
            <br>
            <input type="radio" name="x7" value="4"> Venise <?php if(isset($_POST['x7']) AND $_POST['x7'] == "4") {
                            echo "<font color='red'>  x </font>"; } ?>
            <br>
            <br>
<img src="https://i.pinimg.com/474x/b1/21/7b/b1217be13186b112d4ba6b7d944bd3a7--growth-factor-woman-portrait.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 8 -</b> Par quel mot désigne-t-on une belle-mère cruelle ?</legend>
            <input type="radio" name="x8" value="1"> Une jocrisse <?php if(isset($_POST['x8']) AND $_POST['x8'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x8" value="2"> Une chenapan <?php if(isset($_POST['x8']) AND $_POST['x8'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x8" value="3"> Une godiche <?php if(isset($_POST['x8']) AND $_POST['x8'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x8" value="4"> Une marâtre <?php if(isset($_POST['x8']) AND $_POST['x8'] == "4"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <br>
            <img src="https://latatoueuse.com/dieux-et-deesses/images/1/ares.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 9 -</b> Qui était le dieu de la guerre dans la mythologie grecque ?</legend>
            <input type="radio" name="x9" value="1"> Apollon <?php if(isset($_POST['x9']) AND $_POST['x9'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x9" value="2"> Hadès <?php if(isset($_POST['x9']) AND $_POST['x9'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x9" value="3"> Arès <?php if(isset($_POST['x9']) AND $_POST['x9'] == "3"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
             <input type="radio" name="x9" value="4"> Hermès <?php if(isset($_POST['x9']) AND $_POST['x9'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>
            <img src="http://soutien67.free.fr/svt/animaux/zoo/expos/felins/images/bt_g_felin.png" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 10 -</b> Parmi les animaux suivants, lequel peut se déplacer le plus rapidement ?</legend>
            <input type="radio" name="x10" value="1"> Le chevreuil <?php if(isset($_POST['x10']) AND $_POST['x10'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x10" value="2"> Le mgbobe <?php if(isset($_POST['x10']) AND $_POST['x10'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x10" value="3"> Le léopard <?php if(isset($_POST['x10']) AND $_POST['x10'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x10" value="4"> Le springbok <?php if(isset($_POST['x10']) AND $_POST['x10'] == "4"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <br>
            <input class="btn btn-outline-dark pl-5 pr-5" type="submit" name="submit" value="Finish">

        </form>

    </section>
    <!--================ End Course Details Area =================-->

    <!--================ Start footer Area  =================-->
        <!-- Footer -->
        <footer class="page-footer font-small indigo bg-light border-top border-primary rounded-top">

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
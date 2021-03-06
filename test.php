<?php
session_cache_limiter('private_no_expire,must-revalidate');

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

//recuperation de la section du cours 
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    //recuperation du numero de la section
    $get_section=$bdd->prepare("SELECT id_section FROM cours WHERE id=?");
    $get_section->execute(array($_GET['id']));


    $section_num=$get_section->fetch();
    

    //recuperation des info de la section
    $get_section_information=$bdd->prepare("SELECT * FROM section WHERE id= ?");
    $get_section_information->execute(array($section_num['id_section']));
    $section_info=$get_section_information->fetch();
}else{
    $_SESSION['flash']['danger']="La valeur que vous avez entré n'est pas valide";
    header('location: index.php');
    exit();
}

//recuperation du numero de test et question du test
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $get_test=$bdd->prepare("SELECT * from test WHERE id_cours=?");
    $get_test->execute([$_GET['id']]);
    $test_info=$get_test->fetch();
    
    $req = $bdd->prepare("SELECT * FROM question WHERE id_test = ?");
    $req->execute(array($test_info['id']));
    $questions=$req->fetchAll();
    if(empty($questions)){
        $_SESSION['flash']['danger']="Le test de ce cours n'est pas encore disponible,nous allons l'ajouter tres bientot.";
        header('Location: course-section.php?id='.$section_num['id_section']);
        exit();
    }

}else{
    $_SESSION['flash']['danger']="Veuillez entrez une valeur valide.";
    header('location: index.php');
    exit();
}


//verificiation si le test est deja réussi si deja redirection vers la sectiond des cours
$requete= $bdd->prepare('SELECT id FROM resultat WHERE id_user=? and num=? and etat=?');
$requete->execute(array($_SESSION['id'],$test_info['id'],'Test Reussi'));
$ok=$requete->rowCount();
if($ok){
    $_SESSION['flash']['danger']="Vous avez déja réussi ce test vous pouvez passé au cours suivant";
    header('Location:course-section.php?id='.$section_num['id_section']);
    exit();
}

/*
//verification si le test d'avant et deja reussi sinon renvoie vers l'index
if($test_info['position']!=1){
    $testprecedent=$test_info['position']-1; 
    $requete= $bdd->prepare("SELECT id FROM resultat WHERE id_user=? and num=? and etat=?");
    $requete->execute(array($_SESSION['id'],$testprecedent,'Test Reussi'));
    $ok=$requete->rowCount();
    if(!$ok){
        $_SESSION['flash']['danger']="Vous devez d'abbord passé et reussir le test numero ".$testprecedent." de la section ".$section_info['nom'];
        header('Location: course-section.php?id='.$section_num['id_section']);
        exit();
    }
}
*/

//traitement des reponse de l'utilisateur
$score = 0;
if(isset($_POST['submit'])){
    if(isset($_POST['a1']) AND $_POST['a1'] != 0){
        $score++;
    }    
    if(isset($_POST['a2']) AND $_POST['a2'] != 0){
        $score++;
    }
    if(isset($_POST['a3']) AND $_POST['a3'] != 0){
        $score++;
    }
    if(isset($_POST['a4']) AND $_POST['a4'] != 0){
        $score++;
    }
    if(isset($_POST['a5']) AND $_POST['a5'] != 0){
        $score++;
    }

   
    $resultat = "Votre score est de ".$score." /5";

    //traitement de l'ajout du resultat du QCM de l'etudiant
    if($score == 5){
        $res_success = "Félécitations vous avez réussi le test ";
        $insert=$bdd->prepare("INSERT INTO resultat(id_user,num,etat) VALUES(?,?,?)");
        $delete=$bdd->prepare("DELETE FROM resultat WHERE etat=? AND id_user=? AND num=?");
        $insert->execute(array($_SESSION['id'],$test_info['id'],'Test Reussi'));
        $delete->execute(array('Test Pas Reussi',$_SESSION['id'],$test_info['id']));
        $_SESSION['flash']['success']=$res_success ." <br> ".$resultat;
        header('Location: course-section.php?id='.$section_num['id_section']);
        exit();
    }else{
        $res_fail = "EMM Dommage , vous pouvez réessayer ";
        $find=$bdd->prepare("SELECT id FROM resultat WHERE id_user=? AND num=? AND etat=?");
        $find->execute(array($_SESSION['id'],$test_info['id'],'Test Pas Reussi'));
        $ok=$find->rowCount();
        if(!$ok){ 
        $insert=$bdd->prepare("INSERT INTO resultat(id_user,num,etat) VALUES(?,?,?)");
        $insert->execute(array($_SESSION['id'],$test_info['id'],'Test Pas Reussi'));
        $_SESSION['flash']['danger']=$res_fail ." <br> ".$resultat;
        }
        else{
        $updatereq=$bdd->prepare("UPDATE resultat SET etat = Test Pas Reussi WHERE id_user=? and num=? ");
        $updatereq->execute(array($_SESSION['id'],$test_info['id']));
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
                        <b style="font-family:Rubik; color: #FCC632;"class=" visible lead"> Bienvenue Monsieur : <?= $_SESSION['name'] ?> </b>
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
                            <h2>Course Details</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
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
    <section class="course_details_area section_gap_top2 bg-light text-center">
        <div class="container">

        <form action="" method="POST">

            <?php 
                $get_test=$bdd->prepare("SELECT * from test WHERE id_cours=?");
                $get_test->execute([$_GET['id']]);
                $test_info=$get_test->fetch(); 
            ?>
                    
            <h2 class="text-capitalize text-success display-4 font-weight-bold "><i class="fas fa-feather-alt" style="transform:rotateZ(180deg);"></i> <?= $test_info['titre'] ?> Quizz <i class="fas fa-feather-alt" style="transform: rotate(180deg) rotateY(180deg);"></i></h2>
                                
            <small class="font-weight-bold text-success" style="font-size: 16px;"><i class="fab fa-google-wallet"></i> You have to answer these 5 question to pass the test of your course good luck !  <i class="fab fa-google-wallet" style="transform: rotate(180deg);"></i></small>
            <?php $i=0; foreach($questions as $question) : ;?>  
                
                <?php $i++; ?>
            
                <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b><?= $i ?> :</b> <?= $question['question'] ?>  </legend>

                <?php $reponse=$question['answer']; ?>

                <input type="radio" name="a<?=$i;?>" value="<?php if($reponse==1) echo 1; else echo 0; ?>"> <b class="font-weight-bold text-secondary "> <?= $question['choix1'] ?> </b>
                    <?php if(isset($_POST["a".$i]) && $_POST["a".$i] == "1" ) :  ?>
                        <i class="fas fa-check text-success"></i>
                    <?php endif; ?>
                 <br>

                <input type="radio" name="a<?= $i; ?>" value="<?php if($reponse==2) echo 2; else echo 0; ?>"> <b class="font-weight-bold text-secondary "> <?= $question['choix2'] ?> </b>
                    <?php if(isset($_POST["a".$i]) && $_POST["a".$i] == "2" ) : ?>
                        <i class="fas fa-check text-success"></i>
                    <?php endif; ?>
                    <br>
                
                <input type="radio" name="a<?= $i; ?>" value="<?php if($reponse==3) echo 3; else echo 0; ?>"> <b class="font-weight-bold text-secondary "> <?= $question['choix3'] ?> </b>
                    <?php if(isset($_POST["a".$i]) && $_POST["a".$i] == "3" ) : ?>
                        <i class="fas fa-check text-success"></i>
                    <?php endif; ?>
                    <br>
                
                <input type="radio" name="a<?= $i; ?>" value="<?php if($reponse==4) echo 4; else echo 0; ?>"> <b class="font-weight-bold text-secondary "> <?= $question['choix4'] ?> </b>
                    <?php if(isset($_POST["a".$i]) && $_POST["a".$i] == "4" ) : ?>
                        <i class="fas fa-check text-success"></i>
                    <?php endif; ?>
                    <br>
                
            <?php endforeach; ?>

            <div class="pt-4 pb-4">

                <input class="btn btn-outline-dark btn-lg pr-5 pl-5" type="submit" name="submit" value="Submit Answers" >

                <input class="btn btn-outline-dark btn-lg pr-5 pl-5" type="reset" name="reset" value="Reset Choices">

            </div>

        </form>

        </div>
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
        $(".alert").delay(3000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>
</body>

</html>

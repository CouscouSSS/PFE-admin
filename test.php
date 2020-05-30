<?php
session_cache_limiter('private_no_expire,must-revalidate');

session_start();

include "connexion.inc.php";

if (!isset($_SESSION['id'])) {
    $_SESSION['flash']['danger']="Pour accéder au exercices veuillez vous connecter";
    header('Location: index.php');
    exit();
}

//recuperation de la section du cours 
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    //recuperation du numero de la section
    $get_section=$bdd->prepare("SELECT id_section FROM cours WHERE id=(SELECT id_cours from test WHERE id=?)");
    $get_section->execute(array($_GET['id']));
    $ok=$get_section->rowCount();
    if($ok){
    $section_num=$get_section->fetch();
    }else{
        $_SESSION['flash']['danger']="La valeur que vous avez entré n'est pas valide";
        header('location: index.php');
        exit();
    }

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
    if(isset($_POST['a1'])  AND $_POST['a1'] != 0){
    $score++;
    }    
    if(isset($_POST['a2'])  AND $_POST['a2'] != 0){
        $score++;
    }
    if(isset($_POST['a3'])  AND $_POST['a3'] != 0){
        $score++;
    }
    if(isset($_POST['a4'])  AND $_POST['a4'] != 0){
        $score++;
    }
    if(isset($_POST['a5'])  AND $_POST['a5'] != 0){
        $score++;
    }
    if(isset($_POST['a6'])  AND $_POST['a6'] != 0){
        $score++;
    }
    if(isset($_POST['a7'])  AND $_POST['a7'] != 0){
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
            <div class="aler alert-<?= $type ?>"> 
                <div style="font-family:Rubik,sans-serif;" class="pt-2 pb-2 lead text-align-center text-center border "> <?= $message ?> </div>
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
            
                <legend class="font-weight-bold text-dark pt-4 pb-4"> <b><?= $i ?> :</b> <?= $question['question'] ?>  </legend>

                <?php  $reponse=$question['answer']; ?>

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
        $(".alert").delay(3000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>
</body>

</html>

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
$requete->execute(array($_SESSION['id'],5006,'Test Reussi'));
$ok=$requete->rowCount();
if($ok){
    $_SESSION['flash']['danger']="Vous avez déja réussi ce test vous pouvez passé au test suivant";
    header('Location: course-quizes.php');
    exit();
}

$score = 0;

if(isset($_POST['submit'])){
  
if(isset($_POST['x1']) AND $_POST['x1'] == "1"){
  $score++;
}
if(isset($_POST['x2']) AND $_POST['x2'] == "2"){
  $score++;
}
if(isset($_POST['x3']) AND $_POST['x3'] == "2"){
  $score++;
}
if(isset($_POST['x4']) AND $_POST['x4'] == "1"){
  $score++;
}
if(isset($_POST['x5']) AND $_POST['x5'] == "2"){
  $score++;
}
if(isset($_POST['x6']) AND $_POST['x6'] == "4"){
  $score++;
}
if(isset($_POST['x7']) AND $_POST['x7'] == "3"){
  $score++;
}
if(isset($_POST['x8']) AND $_POST['x8'] == "1"){
  $score++;
}
if(isset($_POST['x9']) AND $_POST['x9'] == "4"){
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
    $insert->execute(array($_SESSION['id'],5006,'Test Reussi'));
    $delete->execute(array('Test Pas Reussi',$_SESSION['id'],5006));
    $_SESSION['flash']['success']=$res_success ." <br> ".$resultat;
    header('Location: course-quizes.php');
    exit();
    }else{
        $res_fail = "EMM Dommage , vous pouvez réessayer ";
          $find=$bdd->prepare("SELECT id FROM resultat WHERE id_user=? AND num=? AND etat=?");
          $find->execute(array($_SESSION['id'],5006,'Test Pas Reussi'));
          $ok=$find->rowCount();
        if(!$ok){ 
          $insert=$bdd->prepare("INSERT INTO resultat(id_user,num,etat) VALUES(?,?,?)");
          $insert->execute(array($_SESSION['id'],5006,'Test Pas Reussi'));
          $_SESSION['flash']['danger']=$res_fail ." <br> ".$resultat;
        }
        else{
        $updatereq=$bdd->prepare("UPDATE resultat SET etat = Test Pas Reussi WHERE id_user=? and num=? ");
        $updatereq->execute(array($_SESSION['id'],5006));
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
        <h2 class="text-capitalize text-success display-4 font-weight-bold "><i class="fas fa-feather-alt" style="transform:rotateZ(180deg);"></i> Quizz 1 - Expert level <i class="fas fa-feather-alt" style="transform: rotate(180deg) rotateY(180deg);"></i></h2>


        <form method="POST">
            <br>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Pope_Hadrian_IV.jpg/280px-Pope_Hadrian_IV.jpg" width="800" height="400">
            <br>
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 1 -</b> Selon la légende, comment le pape Adrien IV est-il mort en 1159 ? </legend>
            <input type="radio" name="x1" value="1" > En avalant une mouche . <?php if(isset($_POST['x1']) AND $_POST['x1'] == "1"){
                
                            echo "<font color='green'>  ✔  </font>"; } ?>
                            <br>

            <input type="radio" name="x1" value="2"> En se cognant contre une porte . <?php if(isset($_POST['x1']) AND $_POST['x1'] == "2"){
                           
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
             <input type="radio" name="x1" value="3"> En tombant d'un balcon <?php if(isset($_POST['x1']) AND $_POST['x1'] == "3"){
                           
                            echo "<font color='red'>  x  </font>"; 
                           } ?>
            <br>
             <input type="radio" name="x1" value="4"> En chutant d'un cheval . <?php if(isset($_POST['x1']) AND $_POST['x1'] == "4"){
                           
                            echo "<font color='red'>  x  </font>"; 
                           } ?>
                           <br>
                           <br>

                           <img src="https://i2.wp.com/cms.babbel.news/wp-content/uploads/2017/11/Nouveaux-Mots-Dictionnaire-Header.jpg?h=9999&quality=100&w=993" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 2 -</b> Que signifie « palimpseste » ?</legend>
            <input type="radio" name="x2" value="1"> Raisonnement par lequel on démontre la vérité d'une proposition en prouvant l'impossibilité ou l'absurdité de la proposition contraire.<?php if(isset($_POST['x2']) AND $_POST['x2'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?>
<br>
            <input type="radio" name="x2" value="2"> Manuscrit dont on a fait disparaître l'écriture pour y écrire un autre texte. <?php if(isset($_POST['x2']) AND $_POST['x2'] == "2"){
                            echo "<font color='green'>  ✔  </font>"; } ?><br>
                            <input type="radio" name="x2" value="3"> Ce qui aide, ce qui sert d'auxiliaire. <?php if(isset($_POST['x2']) AND $_POST['x2'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
                            <input type="radio" name="x2" value="4"> Farceur, personnage qui manque de sérieux et sur lequel on ne peut compter.<?php if(isset($_POST['x2']) AND $_POST['x2'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <br>

            <img src="https://static.timesofisrael.com/fr/uploads/2019/11/Df8ER7Bg-e1573178807602.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 3 -</b> De quel ouvrage de la Bible l’expression « rien de nouveau sous le Soleil » est-elle tirée ?</legend>
            <input type="radio" name="x3" value="1"> La Genèse <?php if(isset($_POST['x3']) AND $_POST['x3'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x3" value="2"> L'Ecclésiaste <?php if(isset($_POST['x3']) AND $_POST['x3'] == "2"){
                            
                            echo "<font color='green'>  ✔  </font>";
                           } ?> <br>
                           <input type="radio" name="x3" value="3"> Le Cantique des cantiques <?php if(isset($_POST['x3']) AND $_POST['x3'] == "3"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?> <br>
                           <input type="radio" name="x3" value="4"> Le Libre de Job <?php if(isset($_POST['x3']) AND $_POST['x3'] == "4"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?> <br>
            <br>
            <img src="https://cdn.radiofrance.fr/s3/cruiser-production/2018/04/8360dca2-927b-4633-9cf8-4c93ac1e6108/600x337_rachma.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 ">  <b> 4 -</b> Segueï Rachmaninov est resté (surtout) dans les mémoires comme …</legend>
            <input type="radio" name="x4" value="1"> compositeur <?php if(isset($_POST['x4']) AND $_POST['x4'] == "1"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
<br>
            <input type="radio" name="x4" value="2"> chef d'orchestre <?php if(isset($_POST['x4']) AND $_POST['x4'] == "2"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
                           <input type="radio" name="x4" value="3">  pianiste de génie <?php if(isset($_POST['x4']) AND $_POST['x4'] == "3"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
                           <input type="radio" name="x4" value="4">  chanteur <?php if(isset($_POST['x4']) AND $_POST['x4'] == "4"){
                            
                            echo "<font color='red'>  x  </font>"; 
                           } ?><br>
            <br>
             <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxISEhUSExMWFhUXFhcYFRcVFRYYFxcVFRcWFhYYFhUYHSggGBolHxUXITEhJSorLi4uGB8zODMtNygtLisBCgoKDg0OGxAQGi0lICUyLS0tLS0tLS0tLTUtLy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIALEBHQMBIgACEQEDEQH/xAAcAAAABwEBAAAAAAAAAAAAAAAAAgMEBQYHAQj/xABNEAACAQIEAwQGBAoJAgQHAAABAhEAAwQSITEFBkETIlFhBzJxgZHBFCOhsTM0QlJicnOC0fAVQ1OSsrPCw/E14SRjg6IWFyV0k6Py/8QAGgEAAgMBAQAAAAAAAAAAAAAAAQIAAwUEBv/EADARAAICAQMDAQUIAwEAAAAAAAABAhEDBCExEkFRBRNhgbHwFSIjMnGhweFCkfEU/9oADAMBAAIRAxEAPwCgRQijxQivUnnrCRXIo8UIoEsJFCKNFCKlBsLFdoRQioQUzDJlyicxObrEDTwjrSdGe0ViQRIkSIkHY+Y03otKkFnKFdoUaAcrkUahUolgFChQqUQ5XDRq5FSiBa5FHiuRQoNhYowFdAowFSiNnRRSKPXIo0KcUUtbFERaWRalAsUQU6srSCCndlaDHQ4RKWCUZBpSuSkLQltaDilQKLcWoQbhaUVaAFKKlQgXLXQlKolKBaAxTIoRR4oRXTRxWJxQilIrkVKJYnFCKPFCKFBsTiuhJ0G52o0VIcAw+e+k7KQx8oIg/Eilm+mLl4HguqSQbmS0VuqpjS1bGgjZBOh21momKnubSTfDEzNtD94+VQkVXg3xx/QfNtkYSKEUeKEVbRXYSKEUaKEVKJZyKEUaK7FSgWEijXrDIQGESAR5hhII8RQI6eOnx0qY5hwiqLTpOUoF1HVdvjP2VRPN05Y4/Nl8MfVjlPxRBxQijxTjBYNrhgbASx6AVbJqKt8FcU5OkH4ZghczFiVUKe8Pz47oPlO/lTSK1Hlfhq2wDlgx3R1WRGY/pH+fCqpzbwHsHDKpCOTHgtzUm35A6svvX80Vm4tepZWnw+Pr3ndl0bWK1yuSsxQiuxRgK1KM2zqClVFJrSgo0Cxa3TywKZW6fYelaLIsf2Kchab2BT+1aqplyEhbpN7dPGSudnQsahmLVKC3S5WisalkCVwvSbtRCaNAsrMVyKUihFddGfYnFcilIoZalBsTiuRSkVyKFBsJFTXLlrUmOjH90DJv4Tdn226iIqz8Ew3dYbQUT95ZZ9fa4ri18+nHXk7NFHqyX4I7msfWr5JH913FQsVP81r9ZPm4+Dk/OoOKt0u+GJXqdsshOKEUpFcir6KLCRXIpSKEVKDYSKEUeK5FSiWJZLjXLVu0FLO0AvJQaE96Nf8AirDxzheLsWV7TsrlokDNbDIyEiQSjaEdJBnXaozhf4xZj+0H3Gr9zVadsIFgksbceEyOtYur21kN/BraXfSy28md4TCtcYIu5+AHifKrxy7woTkSCoQtJmXbQT7NdPd723D+FKlvKHAJjOxB736KkDQefz2uuEw+SGyhWiNCII3GnQVRrdX7V9Mfy/Mu0mm9mrlyQnHeNDDDLaW3dxPZh+xlzcZTIGS2o1jUnWYBIBpPBcVGPw/Y3bfZtctpcABOV7bAMCjRII0MbiJqevYYB0u5Az20ZVJAD97KO6/5I0Mx5ew1XlXl1Exd28MP2ORlW0c7Mty33pchjOeNDPj1Ik59naVXj/B3w11rb6kahojOh9V4G0wQR0YHoVmNite5r4P9KsqFA7RDKmY0IhknwP2aHcCsoxFkqxBBEEiG3BBghh0I2Nb/AKfqvaR6Jcr9zE12n9nLrjw/2EQKPbAObeVynpENmHjP5Ph1oAU84HDG6CYUkW9dpCq3iNZbbXaujV53hgpLyv8AXf8AYo0uJZZuL8P+hC2tP8MtNwhVip0IOtPLRq9u1aK4qnuSGDtVKomlMsAk1LKlc83udUFsIFKSuECl7rVH3rlBKwt0FuXKQuPQZqRMmrEits6WoyITR7Nqn9u0IoN0FKynZa5lpSKEV30ZlicVyKVihFCiWJRXIpSKASalBscWcJorkaSxM9QusAbnYjSprhXErNsWrVy4BcuMzZYMxqQSYI1CjffXwpHjlns7VoaQEKe1g2dzHXvMvxNL/wDw7aFxbkAMjKdvWZVFuTI0OgPtArzerzyyy9y4PRabDHFH3vkZczmWB/TuH4lahIq2Yj8szqEukDXUlSAZ6RqR5j21VorU9PydeKvBma+HTkvyJ5aEUpFciu+jisJFcilIoRQolicUCKUiuW7KXbiWGn6yRAgSFBZpJIgQInzqvLNY4Ob7FmKLyTUV3G1q4rYjD2wZzXbbeRAcAa+Z09orZ+N4NTbAnKARJy6gRr/PsrKOaMDl4lg7FuLbKtlXyj1A10kAQ24DDaNxr1q92eHY1VNy5iruRSM1shbhKyJgm2WJ99eX1Gd5p9bPR4MKxQ6US/D8CIIYKR3QukCB5kTG3xqYB6R7iNvYagcJxnC52AuINdmBVtAAJzQY0O1TiXkYSrqQfBgaoZcjl66ER3aYUFiBJMATAjUnyqH5Y5gs41LjW1uW2R8rpdVVdTGYSgJ0I6+RqWxyg2rqyJ7NvDTTc++q1y1g0TH3mWB2uHDGNibd0rm9sMo91VOX3qLVH7tlmLTpGtUHnfhAUm+qnf60RsAO7cEbwNG8VA/NE6KveXSf5+2m94EKZnbQ76jT31fjyShJSXKKZwU4tPgxN7ZBg7095M4LhnxFw3kW7mIIFwZgAzENCnTw13pXmjDLh8QFBGS4W7IRGTLqbZ9k90+EDpqy4LxRrOMRUjv5UYnpLSPae79tbOryxz6VTXNmTpccsOpcO1Ehxvh6YfEXLVtcqAgqNYAYBoE7CSdKWwdqaf8AO9hvpAcj1kGw3gkUXhNiRXXp5p6eLXj5bHPli1nkn5JDA2oFOXauxAikLrUvLLeEJ33plcFOGWuZJp1sI9xmVoJamni2PGnFq0KLkBRE8Ph4FO1tiigUoBVTZYijxQil2QdKJlrVMSxKKEUrlrmWpRLEoqS5ewue+s7L3z+7t/7itMctSXLOF7bFLZLOEa3cL5CBqpthSZ8Cx+Nc2syezwSkvB1aOKyZ4xf13JnmfBlltXQQVtOzOCdxGZR73RFI8Hqr2+J3Q4btSQpB6d4/lAj3nwrQ8RycHQoMRcA0kMAdtvCoH/5dtMpeQweqsJiN9/DpXlFmieoeNivCMGxLdooE3GX2ouZFPtlrh08RVOe2QSDuND7RV8xOEx1hDdYWWS0rM0ORooLMZMeZqkXrvaMXy5cxLZZnLmMxPWJitn0ial1Je7+TI9VjSi37/wCBDLXIpXLQy1tUY/UJRQilMtDLUoliUUbhXex+Gtj1vrSQPA2nAE9J+VI8QxS2ULt02HiegFR3o3uNd4paZjJYuTp/5T9PAVl+p51HH7PuzT9NwuU/adkWHjGANvi2FEQXNlm01J7bLJ8dFA91a1xLDt2bhQGJH5SvlJ8GCkGPYRWa812gOM4TXZLPiI+vYfM1peP1RwJ1HjvXnG9j0CW5W7/D+gt6kbpfuIVDaZe/2p6AxHWmeG4I4zTmkt3O5h3hdAczAWmJ89fdUzhkfTMdB+bvPnGhPnUiqqRJ950Ee06xtSJ3uwtFLx/Db9pO5cbKwbMW+kHMrbqT9agGsRHhvTDAtfwwN60URlBUl3tPmRmUH6r6oico1yyI+Nm45xu2qaKGUE/W3bgtWgW3l21YmSQQrKY3FUTiHObXH7NcRhiFgBVW9aVlU+qb7PCmJGbrprTJgot9vmbiCswbB5lSMz5Lg3AJIKZ9IJ33pxhedZPeskCQMwuqBtuVuZGHwplwTj+FxRW29sWMRlAKXFQNcAgnK8APoTqDrqYGlWi9hkOYDOVMMQHuFRoBAUnLECpZKM49IhGMRUs227ZbmeTouQqZ+sBy75dzVJ4S12zibYZQbouofWkaEbss/Zrqa2LEYVBA7FBDbstmY3EC0qsNfPrWVqtxcVf7WBcFw5gsnbYAnUjw6xFMnsLW5feOcUOJyZrDIyz3tCpGoiTB38jTvBqEWKleOYDMq3FWFAzQAIg6zoTvUGHrZ9Pk5YunwzM1kVHJ1eUOmuU3dqI7zQQV3KNHI5WGXWlkWiqKcW7dBhQFFKLbo6oBRLl3wqss4OmBSTX/AAFJsZo626NAsq2WhlpXJQy1qmEI5aGWlctDLRAI5KsvIWH+vd4JhI/vf/yKgMtW/kjCrDuwBkwJAMZQCSDEj1qzfVZVpZfD5mj6XG9TH3X8ixY7iVuwoNwlQTlEK7anQaICRrRLeJtLcCZrYLiUCjLP5W40YxJ8YnSJqO5kwYumzbZUYC5mAdAxQjKAyHt7bKdTqA/s8UbuBX6Wt02znW2FFz/xCqVXK+USnYnXXRpldtDHk1Haz1d70PebXDYW9akS9txB3ylSGIHvrMoq781uAXh1JFpUINvv95tfrAfBtsvU1Tctek9EhWKUvL/j+zzvrU/xIx9318hKKEUstomumyRWyY+43iuEUsUqt828TyjsE9Zh346KentP3e2qs+aOGDnItwYpZpqESF47xA4i7lU9xdF8/Fvf91T3oyEcSsjSAHG07W7nQb9arGBwTu0KpbocomNRuR6vvq2+jmw1vilpHBDANI33tXDuPbXks2SWSTnLlnrMWOOOKhHhFo51IXi+FO/ds7Aje+2hnprWjYnEAq0KwnQZd/drvWac5t/9Yw28dnZ01/t2rUmtAqw2B3BjY1zPgvXI2wuFPXbedfnUfxi7cuHsrQB13eezXwZwINxpghJHiSuhMxcHZ28o6/zp/PWk8Nho1HX4fwpFux3siBwnKFnN2l0G9d/PvQ0fqoAEt/uqPfS/E+U8NiEK3batpocsEfqkaj3Gl+I8c7IlUtXLzz6tpRCztmdiqjfaZ1GlVpfSSVuvbuYO4MgYkoVbMq+syyRmAmZWadNCuyscb5bxHDkYqGxGCM50J79rrmVgNCIkMBodSNAat/JHH3vWQHuC6CSqXfyukJfXpcjSRo2kkSpexcA45hsbaz2HDDYjqD5qdfjVE5h4SeE4j6XZWcHdYLiLQGlssdHQDYa6eBMAgMIjV8ET8l8uYYNBnpA1Ij2gag+M+FZJzRY7PieJUxDi22v6izpudZrTuF8V7RXUQXTKRDT2lm5Js3VOkgiVJj1lPQg1m/OjTxFcykZrC7jSQzj3juigmiNGpcKui9hLcGS1lQdFOuUA7Gd6o4virfyjfzYKzB2zKdtgzAfZFUfiIy3rq+Fxht+kYra9IpuUf0Mn1V9KjL9R8t8UcXhUSLhpey9bTxmTHNZL2Xp8pio3C+NPM1c01udUHsduXqRgmlclHt2TS7IbdiCzSyIx2p3bsAedLgHwApHMsUCoZK5kpzkrmStWzF6RtkoZKcZKGSpYOkb5Ku/KNvLYE9ST9sf6aqAt1cOGYe/btLCaGO6LqkiR1lFA1896xvWp/gxh5d/6/wCmv6PD8WUvC+f/AANxHXEW11gDNu4E5jEDsWRz3f7RSNNBIJZtxHDpiTLJne52fc7BnZswUBuzPaaZQO+B0GtLXEvI5c27skRmDWdd4B+sAOrGB8Kq3MPGBa4hghdF8w5ZgQ5K55RQoYmBm3CwCFiDpXnlVUb78iHM3FFt3rjsucdsUIJOy92RlI2y+NN7vEsPmRezgPMFXOkeIaf5FQ/HLwa12w1z3y4DDcObj6j5edMuH4ftyTnVMon1WgSToI9UV3Yc08cajJo5M2GGSVyin8Cf/pHDwT3gBv3lJ1MDTLr8aUTG2DoLjjWBKCJPmH+VR2F4ApJzXC+vq2FJJ69527qe+rbwnldwpZFWzqIJHaXCJ177CF66Qwq/7RzR/wAvkUfZ2F/4/Mj7mFYIXzoo6G7ntiTtMr9gqL4dyUhY3WW5ibhaS9wNatSTOltQbjbdRlPlWgYTg1tNWHenR2bO/wDeYyonoNKeXAEAgzrtoCx9pO/8a5dRrcmaursdOn0ePDfT3K7guVwIVyMuh7JE7NANdwpmT4EkVBcJwqrx5lS2qAQMqwAB9GO2XStEsGSXyuJjSAdpOkDf3+FUHg1qePYi4PVQqum2c2QDv1GVh+9XMndnQ0J87ALxjDsdhZtSd4AvMfCtH/pKwxAW4veMAbNJPQHr7RWXelC6fp++2EBEQDOe4d/hS2A4hBUlWIVwwOZTqpkbpI28albBvc1K8ZYCiYliqEgSY08yRprR21JP2n3VH8xYc3cLdQZQWXQn1TG4JOgBGknTXXSqEvulje5nXH7t6xiRiLZAIctbfMxR0mShCkg6SCvQiuWrNy3fN8EEYf60Z5hhcDIgBHX6yN4lSKb2+CYnDI7dzDBgxPaQbdwidOwUMbnuUjbXapoYbtXF9bi/QMoiXy4c2BIULbn6t1I1AggjyIq5tJFa3K3w25izimxdq4zPbtM7qQIcIQRbJRQAGkgaGDHnGuYW7Zx2EBIzWr1vUHqrDUeR+6sox2OxVtpVjYDAZOxFsWmicsFBlujUzqevWtM5NBFp1ZMhFwsViMrXUt33AHSGusI6bUJbNBXBS+Aq+EdrTk58E5Uk/wBZgbxWSfEIezuT5FRRPSlay4vCOI7yXFOgnukEa/v1ZeZcEEx+HvEApfRsPdHiDOQEdfwj/wB0VWefCxw2BdjmZLjWifFlhGPxtTSraVDP8tlp9H1xjhWWR3brCPAEK3zNV/mW1GJu+ZB+Kg/Oj8lcbSx2tt57xVxEaaZTI9w+NPuNYO5iGGItLnQr3gIFwFSVOhMP0MaHQwToK0fTtRHBk6p8NUZ/qGnlnx9MOU7K4FpzZAFEQAiRtMdRB8CDqp8iAaVRa9OpKcbi9jzajKEqktx5ZNPbY0phbMUq10+6qJR3o6oS2sei6BTzDHN7KhLbEmpbBvpoaqyQpF2KdskCoG1FKmjWiTS/ZTvXK3R1pWVo4U0mbJ8KkhH8zR8gPX7RWl7Roy/ZJkQbdcyVLnDfzIpI4EnpRWVCvCznL1oG8CRIUM0ewb/bVkwFruow0ZkBYyxEsASSJid6icBhOzW650i0w+P/ABVhtOCJtkERA0I1G2vh7q836tk6srrskb3pmNxxb92wmINxj9WUUeLqXLeUBhA89axT0gcTa7i7rAAdnFsAGQDb0bKf1sxrZMfe7K29w7BGZ+8dMonT7RpWHcLwfbu5cmBLufHWTJ3rOxHfMkMfgmfC2FW7bJgEqXRCIBUasQCYOtOOQMQuHxxwuJUKbqAKS6xnWSqysiTPjvA3Iqy4XhSJhe2xFqxk7EOpCgPmyLlzFVBnpE6mPKneIA7vaEEpcR7TafhFMrA6tBYCPGr+vaivp3sspw1nMMupXcZpjYjQmoq1imNzMCDDwFiIG3Tei4JHtXkzsT26ktJ2ZZKge6alUwwLhjHtga6ddDVbY9Di8A389aYXFuLDLESBqB1PjPuqSNsAkADXoAPkBSZw5ELmJO4WQTHjHhrqarY6Gt68UBdpCqCzERoFGYzrtFUH0R3rl67irtwA53FzYd1rjXM2u/5IrSWACmfAzI+8VQvQ4YtXTprkk7dblMuBXyQPpHeeJOIMCwqn4Fv9VWUct4YmPo1pSbgtd0AaZYzEgA6+t74qtekXvcSeBH1KH292PlWmpcIfKxYAsAAVkbCIbpTNgD8tWr3YDt2Bc+AgAbAQB4QdqldIgn7dKGFHdGx0G3so1wb/APf+FBrYJnPNvL2MuYwtbtkpcyxcWMiqAB3m0yhY2JEgab6w/Gbti3jmQKFRT9HJUQ2TS3m01JDd+teQSIYAjqpAIPuNReI5Uwdy8t9rZzCDGc5WKRlLL1iB7Y1mon5JRnvLWBxVjHLaVXVS0XwM3ZvbAb62dtDGVt+m+2mYKxkBjqSdTqZ0BM9YApybKqCFWNSTruTqSQPMzRBrtp7QfvpN3K2NslSK/wA730SzZu3Cq5MTbYMSBrDiNp6/ZVG524tYv4JhZuhjbxzOsTDK2csARpvcOvXLWl8x8Lt4nDXbVwTKMVMSVcKcrDzB1rIuZuGrh8PdRAwU4i2wGVgIe3eA6Rtb+2rKV2Je1CFm+ReskAnNmQhRrDLn0A80H21oHKWLbMUhhIle0R1BI3CkjvaHpOwqkct96/hZEgvAHmyFP9dapgcEtsLoJB310kQYB2JFC9qDW434zwdL0ukJeCgBgPWA6ONnG+hHsjeqxjsM9k5boy6AhxPZkExqf6szpDaagBidKvROvv8AD+NNLtw9qgIAUqy6lTIaNGBB0hftq/T6rJhdwfw7FGfTY8yqS+PcpbLG+kbzpHtoxYnc+8nxqe4nyiLlt1tv2alCMkqyAxoRKkqNB3RppoNayIcKur2tu46B7TOrN2gAbs/rPVKywIllO+w0rV+101fR+/8ARmr0reuv9v7Jni/Mpw1/sVIOiks5YhWadDBmIynWfduHnAOeLatlviFYjvICUTTUnSSNOgPQeJqjXMGGdS961DZZZnYhQS3rBUzRp0BgMPOJRuD2TZdxiLIysV0uXGbulgSq5NVISQJnLBga1w5NZllPqT+BoYtLijDpa+Pc1nGcy2UtC7aIvAhyuQ90lFzlWYA5GgGJHSNKpWJ9IOMYyi2bY8MrOfexYT8BVKwePuWDKMykSO6WCupYiU016+RApSw3dHTSPhpQ/wDRKXuGeCMVa3NovWYBJIA89qU+jGqvi+KXLqMl0rliSABmnbQD2n7Kjn45dzE9s6jwDEAeAAOwrq+1ldqLr6s5vsjanJX9V/JeXw2m++nx0rj3OzAzMFEhQWIAk6AAnqfCst4zzljLTqEun1Se8qmCdiNNSB46a7VBcY5rxeKVFv3A4Rg69xF7wEa5QJ3p16kmroql6f0ulI342C9kgk9+5bQ665S6Ztd9RmFTOEwi2lyrOpnWTqQOp9lVXkzE3buEwl26O/euvcbKIEBb2WANtFSrHxi/2di84Pq27jTt6qk9ax9VkU5truzSwQ6IJPwQHpG4gLeBuQwm4RaEGdzLj+6rCqZyAgNrGuR6tldY0EC62vwFVXmvGEYPD4eZm7dunWdgltftD1b+QYXhmOuP6uUqT+j2UH2+uaWMelDOVsJ6Yce6phsDbaA6jtFnUhSq2ww/NkE+1R4VJcwctWbOO4atpLao15mZANWa2ocEnwGXQR1NZriMf9M4mL4mLuKTLO+QuqqCBpMRpWv8y5jxPhvl9Kby0tqPnTPbYC3Jnjw7isEGZWGUgaiBEDwnWnuCJZEZtCYJEbHqKa8ZBZVBG7dNZ0P8af4ZQgCgbARoI/jSDCV7Fi0Lrkd22mYnTMdyQB7oE9fZWXX+ZLr4kXSYGYCBoEUkd4NvI6k77iK0Tmi0BgsU+kugHgYDAAH3sT76x/HYIKjH9HxPUe2jBJ2STaNmsG4yO7nTIAB+kofMdPEZNPhVN9Ddkm1dmf6voPG5V6Olhj+i32Jp86pXoaI7G7J/s9//AFKWL2DJblf9JAC8Sc6/gE8PCtLsYhpB10jQdRA0I/4rMfSTA4k8tp2Cfcf4Vp+FCSGzEaqYgjoPKjLsBEnhwIBBGw28YpX+dv8AtTOydBrOnl4Ux45i2VcozbSQqljG2Uqis0HXYfkxuYIvYNDu7xzDI2V7yqZjUjf+fnUkIIncdIrOeKcFzDsw6tcKsy2nAXOAFkKfWUglRm6ZjI3pbkfjFy07Ye4+cFWKyFJVkZldWZO67AwCRqYmaClYXEuuMxCoBmZVGm590amjoVbUHpVP4phe2LFgGn862bgjukHwHsXy0MGonl3iVzB3+yIc2GfIUYu5tNupVoJZCCsSZ+4BSTYXE0m0AdNddPjWV823Jwl2QfUw5BOXdQoJ087xrUyRpFZ1zPhc1m6pU6WbnU/1d9I/yTT2JRUOXb+U4d/zXtnw2cHf3Vs9y8oDTJAnxOg1MDesJ4c4FmYOhP31vFrEKwU665T06wfnUYURlrier23ADLlPZrJYSM2VmJjPtoIHSaeOgbKwggajb+P31k9nG3Vx+Z831l82n1Goe52evUQSD7vOtgsKBEDSOp6yZ31PtNCqdB5RnHpC4jduYnDYO3dZAxHaZWIzZmA7yg94AK0A6a00blhDfv8A0q9LZlU9wqzqgWJdTsyqm0az4TSPM+Gy8WS643ysAYMdnc1A8NCDWrX+BYXEHPew9q4w2L21aAemoNWx8Fb8ma2OHYS2cyDKYP5RgSOgbwOo9tVviPLlkg9ncAH5WcyzEAwZ8ySSI8K13j/KmEGGvG1hMMrrbZkP0e0TmUEjdY6eFUj0eYHC4o3hicNZYoFyEWraKA+acwQD8wawY121prBRndzD3EJXNlBEAK0r4wTIKn8oSNz5mk8HmC5mDBWkozCAwGjZTs0EEaVsGP8AR0AAbd1QAANbS91M4b6s5oBA1JadARppFK47hcIpOHxF4G3bu3GsPbkgreW07gBSxgHWT+cY2gS6IbzgrTARoY01J6eJO9C/hVZu9atnQ7wfD9Gl7DQJia6Gkk+wfefmKrdFyszH0p4ZA1lRatr3XJygDcrE90T6prPjgEY/gwfcvzNXX0nY0/Sym+VLarHTNrHmZf7arXDRmv208biL8WANXxS6UUyu2aFj7jYNMJYsgns7TzC5gAvZrJABgEs1SnHbv/hCGBJuIFJUgauNd9B16Uth7J+mXWLEqLFgAEmAxe+WgdJC2/bVX9IWCfD4G9dS/cWMkfvOLZ6SNDvNczVtDp0Y/wA3NGIZASQhgSQSAe9BI03Jq343HnDcDRACGxbaeGQGWOo1kAD96s4VZMCpTi3FGvC0raLZtJbQdBlHeb2sZPsgdKuorsl/R5wk4jHWFERbbtWk6RbgjbrmitK5qusOI4XK2Urh7zAg6jMyr/pqp+hVS1/EMTEW06AySx69BoanOIWze4teC3COxwUgrkksO+Fhgwgm4KRv7wy4LVwBbt4ntbpYDVR3d+utWHL0BOlV3lDB3QjPed5LQoZVAyDYwqDUz9gqwkAa6T7KR8joh+dtOHYjXcKDPibiCscxNxTbjuzr4T9lbBz4xbh14AEkm2IAJJ+tQnQa7Cse+iO5AFtjqNkY9fIUcbVME02bje/AN+q/+Df7PtqlehsfU3Z/8v8A3KuuOcdg2/qXPhkP/aqX6IbgXDXWOuqfDv1XDgaXJX/SRbH9JtOo7BfuNaRhmtlthoU2IHQACI+dZn6S7k8SYAb2F2M7g1oOFWGUbTkjeTIHup5dgRLDZUQsEHTXpEdKZcRFgA3b1zIiAhiSQFIO8kRO9PMKvdXUe8eHSqZ6SsABYa+AVJKKQDAhn72g01kz4yfGgtwj7+leEkZfp1oDf8Mo1md403PxNM8PhcO2LV7OItuvan8pXYqcLbzsrA+r3rc6bsKyS9YBkAfGD8qmeQOEszWj2rjNea0UB7ozWrztIIIknDW9fZ1AIZRiBto129jOFqXRsbZU6qyNiLIgz3gVOxmZ86g+Y/ot0hrOJtOotXGZhcttBstaIhlYAEdqdI2PSslvZnJuOSzNqWYyToNyZNOeAcFa+15Q7KIEgHQoyux082sp/wAwREotEfUmegLK5UUBgxUASDOw8apPMmaLq9W+lKNTuUxF0feKsfKub6Mhdy7EAlmImWVW1gD86J3MayZJieL2gb7AkR2pH/5LWHT/AFtSPkKMq4UwyMDG50rbuCXw2FsOW1azb/J6hB16VhPDWEOOvQxtpWu8rYn/AMFhjmnu5dAPybjId6aQFwUrmkC1iMQ5iVvG4oG+ji7r4abVrtrVdNpPyPzrIfSJZy4y8CTDrbaJ0M21Xb2qa0vl/EC7hrNz8+3ab3tbE/dQn2YY9yqek7CAHDuBEtcSQInOmb/bq7cs8Yt3goViWNtWMjwgN7wTVb9KNmMGjaSt+2Rt1zJuP16hORbuJt3LYAU21usNWK5Uhc8iIjvmD7PCmi9xWtjWr2oKxup1iRrp86zrA8mXcC7Pg8Q0soUrdeAe8DpKHYeYmSNNxd+ZGYYa+EuZLnZXOzMgEOFJWPOYrz1f5w4gW/HL+XwFxhoR5edWCml4qzxnDB7gW1dkBilstqQSXLJABGUxIIZsq6SSKzTma3dv32vXMMLVxjD2ybhIIAOY6aTOxJPdOg0nQOE89WkwdhDjbdm4Ey3C9u7euBkYqDkCkQVWdSN/ORFcZ5l4ZiWD4nEXbrhcuazZKJA10RgCNSdyaJDYr9oM6mDmUGILxqQdQDB1tj3MfEy9tjU77n7NB91Vbi/FgL7i21uFMalfWXRpGXxmorjPOFzD2XulrZyjQKVJJOgAGTxNVSmroujjdWUTmC323FcQwB/DnxGlsok+f4Kf3qLydD42wCJGed49VWYE6Hqo0qK5OxlzEYjEG42Yth7rNP5xdCT9pqY9DFtr+KuXHOlq1pt6zmAdvANtVzktyhJmt8P717EEgQLiIOui2bZ0PtdtKq/pnvBeHOPz7lsRPUEvt+7Vq4Dy4SxxNy44Z7txgojLkkrbJEblQpqvemfgc8NLm6fq7iNqoJcmUAJkZR3vOkUGFyR5+waTJ8KSunWllGSQZ18PL/mkrsQvs19uZvlFOKah6ELRJxTfsh/mE/Kp7l6LvGceRqq2rSiI6hCd/MGoz0JKBYvt+ddA+Cg/6qleTmH9KcTYCBmtrp5Aj5VU+WOuEXyyuUAa6eAB+NcZ1OkN8K4lzT1spn3+6ar3M+IvKytbdgoILZUJ2Os+RBI7sGq2tx0WHH4E3UCC4ygb5SAW8JMVGJy0qEMLjSCDrlOu/gKkuF5jaUkkkidd/YdBrSiWzMiaRwQykxDiwBsXegyXD0/Mbzqhei24VwtwgH1l8P06vnGrhFi9P9ld/wABrN/R3iCuEJBGroOp6PTpUhWyK9JDn+lDM/gE+dX6xZllcCQezjVvBfd4VnHpIYniRlp+pTX+9Wj4PD5ohkWFtySRJBVehHmKaSugJ0WC0wEENMt4eZioH0kd7At45regB/PX+NTWEbZZGk7DqGioXn24TgbuvW2f/wBidaCD3MguqQdRFWj0cSCuvq8QQ7/nW7i7f+rVZvTOtTnJWIKeH47h/gbmHWfg9GFXsGfG5BXrcEr4Ej4Eipjkq4Ribq7TYU6jqLy2/uumoziygXro8Ltwf+5qc8osBih529f3b9hvlQjQZ2bNy0AbIGaAMg/u2rQ+VQPMZK3gZkm5h203jMWP+RTzlTEg2onck9Ns9xf9FMebrcF3H5NpWECYy/SB/uRUb3ERkpXs711B0Yr/AHSRWl8j3gMCm/duXljNAmRc8f0qzzi4FvHYgH+2u7joXJH2GrxyDF3C3UJIC35OXTuvaUbnzSjIkTQMRZe4AEu3LcA6poCekmou0uMtutuLdzNvcdmOUgnwQFum/jvUvhIW2APAfdSN3iKKVLEQTCnxOg0+I+NV9Kux+p0QHpDQvw/EBRORQ+qHRrbK5OYbCAd6znlXmE21uW8yhWIJUhYMoyncGDoPs8a1/juCTEWLqMitmtOASFJBKmCCRoZg6VhXK11VLjKWL2SfyTDLEMAw116CTr5U6WwYyXDIC/3mJY5jrJJJk+M0TJP/AAad8Sshb9xFmAxjNoY3BI9hpmBOYfzpV0RMldjqYcswXYmYkeAruKw6rkIYnMgY6RlMkR57A+/ypNth/PT+INGxW4Piqn7IP2g0SovXH/8AqN/9tiP816qvMvrr7DQoUH+YZflH/I3r3/2Df4lq7ehX8XxXtP8AgFChQkKjcuDfgU/UX/CKqHpp/wClXv17X+YtChV65K+x5qvbe+kr35P6o+80KFVjmvehf8Uu/tz/AJdunPI/4/xP9uv33KFCqnyyxdi+W/n8qgOdfxb99flQoUvcYkODfgMP+z+VTKfOhQpWQjuZPxe7+yu/4DWe+jD8Ub9dfuahQpuwCtekT/qTfsl+41qvL3rn9iv3JQoVHwgLknj6q+35mqzz1+J3/wBz/Mt0KFR8BjyZPdqS5Z9c/wD3WH/z8JQoUIcj5OBlxn8Pe/a3P8bV3lr8at/qP96UKFCHIZ8Gl8m7fuf7+Ip9zrs/7D/cWuUKZ8lfYx3nX/qGI/X+VXT0b/i2J/Xt/wCG5XKFM+BUX21+DX9n/Cqzx78Ha9vzFChVfccvP9WPYPurz5yv/sXfuoUKKJ3K7ifwh/n8kUSz6x99ChXQiqXITp8Pvaj3vVT9U/43rlCoA//Z" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 5 -</b> À quel ordre de l’église catholique le pape François appartient-il ?</legend>
            <input type="radio" name="x5" value="1"> Aux bénédictains <?php if(isset($_POST['x5']) AND $_POST['x5'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x5" value="2"> Aux jésuites <?php if(isset($_POST['x5']) AND $_POST['x5'] == "2"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <input type="radio" name="x5" value="3"> Aux dominicains <?php if(isset($_POST['x5']) AND $_POST['x5'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x5" value="4"> Aux franciscains <?php if(isset($_POST['x5']) AND $_POST['x5'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>

            <img src="https://i.pinimg.com/originals/ba/63/56/ba6356c1d7619f01788904bf67cf4307.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 6 -</b> Quel état des États-Unis a pour capitale Montgomery ?</legend>
            <input type="radio" name="x6" value="1"> Le Nouveau-Mexique <?php if(isset($_POST['x6']) AND $_POST['x6'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x6" value="2"> L'Ohio <?php if(isset($_POST['x6']) AND $_POST['x6'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x6" value="3"> La Californie <?php if(isset($_POST['x6']) AND $_POST['x6'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x6" value="4"> L'Alabama <?php if(isset($_POST['x6']) AND $_POST['x6'] == "4"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <br>
            <img src="https://blog.aqmanager.com/hs-fs/hubfs/Design%20sans%20titre-3-21.png?width=1200&name=Design%20sans%20titre-3-21.png" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 7 -</b> Quel animal est la drosophile, utilisée dans des expérimentations génétiques ?</legend>
            <input type="radio" name="x7" value="1"> Un rat <?php if(isset($_POST['x7']) AND $_POST['x7'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x7" value="2"> Un cochon d'Inde <?php if(isset($_POST['x7']) AND $_POST['x7'] == "2"){
                            echo "<font color='red'>  x </font>"; } ?>
            <br>
            <input type="radio" name="x7" value="3"> Une mouche <?php if(isset($_POST['x7']) AND $_POST['x7'] == "3"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <input type="radio" name="x7" value="4"> Une chèvre <?php if(isset($_POST['x7']) AND $_POST['x7'] == "4") {
                            echo "<font color='red'>  x </font>"; } ?>
            <br>
            <br>
<img src="https://static.latribune.fr/full_width/965677/philo.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 8 -</b> Quel philosophe a écrit « Les origines du totalitarisme » et « La crise de la culture » ?</legend>
            <input type="radio" name="x8" value="1"> Hannah Arendt <?php if(isset($_POST['x8']) AND $_POST['x8'] == "1"){
                            echo "<font color='green'>  ✔  </font>"; } ?><br>
            <input type="radio" name="x8" value="2"> Edmund Husserl <?php if(isset($_POST['x8']) AND $_POST['x8'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x8" value="3"> John Dewey <?php if(isset($_POST['x8']) AND $_POST['x8'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <input type="radio" name="x8" value="4"> Henri Bergson <?php if(isset($_POST['x8']) AND $_POST['x8'] == "4"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
            <br>
            <img src="https://i.pinimg.com/originals/75/47/09/754709b3ce37943bd5d39b55b6c66a2c.jpg" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 9 -</b> Parmi les castes suivantes, laquelle correspond en Inde à la caste des prêtres ?</legend>
            <input type="radio" name="x9" value="1"> Les kshatriya<?php if(isset($_POST['x9']) AND $_POST['x9'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x9" value="2"> Les vaishya <?php if(isset($_POST['x9']) AND $_POST['x9'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x9" value="3"> Les sudras <?php if(isset($_POST['x9']) AND $_POST['x9'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x9" value="4"> Les brahmanes <?php if(isset($_POST['x9']) AND $_POST['x9'] == "4"){
                            echo "<font color='green'>  ✔  </font>"; } ?>
            <br>
            <br>
            <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/8/8d/Logo_Akira.svg/1200px-Logo_Akira.svg.png" width="800" height="400">
            <legend class="font-weight-bold text-dark pb-2 pt-4 "> <b> 10 -</b> Quel objet est devenu le symbole du film d’animation « Akira » ?</legend>
            <input type="radio" name="x10" value="1"> Une mitrailleuse <?php if(isset($_POST['x10']) AND $_POST['x10'] == "1"){
                            echo "<font color='red'>  x  </font>"; } ?><br>
            <input type="radio" name="x10" value="2"> Une voiture bleue <?php if(isset($_POST['x10']) AND $_POST['x10'] == "2"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x10" value="3"> Une épée rouge <?php if(isset($_POST['x10']) AND $_POST['x10'] == "3"){
                            echo "<font color='red'>  x  </font>"; } ?>
            <br>
             <input type="radio" name="x10" value="4"> Une moto rouge <?php if(isset($_POST['x10']) AND $_POST['x10'] == "4"){
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
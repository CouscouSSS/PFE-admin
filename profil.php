<?php
session_start();

include "connexion.inc.php";

if (!isset($_SESSION['id'])) {
    $_SESSION['flash']['danger']="Vous ne pouvez pas accéder a votre profil si vous n'etes pas connecté";
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

$req=$bdd->query("SELECT * FROM section");
$sections=$req->fetchAll();


if(isset($_POST['changepwd'])){
    if(!empty($_POST['oldpassword'])){
        if(!empty($_POST['newpassword'])){
            if(!empty($_POST['confirmnewpassword'])){  
                $req=$bdd->prepare("SELECT * FROM membre WHERE id=? ");
                $req->execute(array($_SESSION['id']));
                $userinfo=$req->fetch();
                if(password_verify($_POST['oldpassword'],$userinfo['password'])){
                    if($_POST['newpassword']==$_POST['confirmnewpassword']){
                        $password=$_POST['newpassword'];
                        $newpassword=password_hash($password,PASSWORD_BCRYPT);
                        $req=$bdd->prepare("UPDATE membre SET password = ? WHERE id=? ");
                        $req->execute(array($newpassword,$_SESSION['id']));
                        unset($_SESSION['id'], $_SESSION['email'],$_SESSION['name']);
                        $_SESSION['flash']['success']="Votre mot de passe a été changé avec succes veuillez vous reconnectez";
                        header('location:index.php');
                        exit();
                    }
                    else{
                        $_SESSION['flash']['danger']="Les nouveau mot de passe que vous avez saisie ne sont pas identique";
                        header('location:profil.php?section=setting&option=changepwd');
                        exit();
                    }
                }else{
                    $_SESSION['flash']['danger']="Votre ancien mot de passe n'est pas juste";
                    header('location:profil.php?section=setting&option=changepwd');
                    exit();
                }
            }else{
                $_SESSION['flash']['danger']="Veuillez confirmer votre nouveau mot de passe";
                header('location:profil.php?section=setting&option=changepwd');
                exit();
            }
        }else{
            $_SESSION['flash']['danger']="Veuillez saisir votre novueau mot de passe";
            header('location:profil.php?section=setting&option=changepwd');
            exit();
        }
    }else{
        $_SESSION['flash']['danger']="Veuillez saisir votre ancien mot de passe";
        header('location:profil.php?section=setting&option=changepwd');
        exit();
    }
}


if(isset($_POST['changemail'])){

    if(!empty($_POST['password'])){
        if(!empty($_POST['oldemail'])){
            if(!empty($_POST['newemail'])){
                $req=$bdd->prepare("SELECT * FROM membre WHERE id=? ");
                $req->execute(array($_SESSION['id']));
                $userinfo=$req->fetch();
                if(password_verify($_POST['password'],$userinfo['password'])){
                    if($_POST['oldemail']==$userinfo['email'] && filter_var($_POST['newemail'],FILTER_VALIDATE_EMAIL)){
                        $req=$bdd->prepare("SELECT * FROM membre");
                        $req->execute();
                        $members=$req->fetchAll();
                        foreach($members as $membre){
                            if($membre['email']==$_POST['newemail']){
                                $_SESSION['flash']['danger']="Le nouveau email que vous avez rentrez apratient a un autre compte";
                                header('location:profil.php?section=setting&option=changemail');
                                exit();
                            }
                        }
                        
                        $req=$bdd->prepare("UPDATE membre SET email = ? WHERE id=? ");
                        $req->execute(array($_POST['newemail'],$_SESSION['id']));
                        unset($_SESSION['id'], $_SESSION['email'],$_SESSION['name']);
                        $_SESSION['flash']['success']="Votre email a été changé avec succes veuillez vous reconnectez";
                        header('location:index.php');
                        exit();
                        
                    }else{
                        $_SESSION['flash']['danger']="Veuillez saisir un email correcte ou bien votre ancien email n'est pas juste";
                        header('location:profil.php?section=setting&option=changemail');
                        exit();
                    }
                }else{
                    $_SESSION['flash']['danger']="Votre mot de passe actuelle n'est pas correcte";
                    header('location:profil.php?section=setting&option=changemail');
                    exit();
                }
            }else{
                $_SESSION['flash']['danger']="Vous n'avez pas saisie votre nouveau email";
                header('location:profil.php?section=setting&option=changemail');
                exit();
            }
        }else{
            $_SESSION['flash']['danger']="Vous n'avez pas saisie votre ancien email";
            header('location:profil.php?section=setting&option=changemail');
            exit();
        }
    }else{
        $_SESSION['flash']['danger']="Vous n'avez pas saisie votre mote de passe";
        header('location:profil.php?section=setting&option=changemail');
        exit();
    } 
}

if(isset($_POST['deleteaccount'])){
    $req=$bdd->prepare("DELETE FROM resultat WHERE id_user = ?");
    $req=$req->execute([$_SESSION['id']]);

    $req=$bdd->prepare("DELETE FROM events WHERE id_user = ?");
    $req=$req->execute([$_SESSION['id']]);

    $req=$bdd->prepare("DELETE FROM recover WHERE email = ?");
    $req=$req->execute([$_SESSION['email']]);

    $req=$bdd->prepare("DELETE FROM membre WHERE id = ?");
    $req=$req->execute([$_SESSION['id']]);

    unset($_SESSION['id'],$_SESSION['email'],$_SESSION['name']);    
    $_SESSION['flash']['success']="Votre compte a été suprimer avec succée";
    header('location:index.php');
    exit();

}


if(isset($_POST['annuler'])){
    header('location:profil.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="img/favicon.png" type="image/png" />
    <title>Profil</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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

            <?php endif; ?>

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
    <section class="sign-in lead">
        <div class="container-signup" style="margin-bottom:120px;">
            <div class="container" style="padding:7px">
                <div class="p-2 text-center">
                    <img src="https://static.change.org/profile-img/default-user-profile.svg" class="img-fluid" alt="">
                    <h2 style="font-family:Roboto,verdana,helvetica,sans-serif,serif;" class="text-dark">
                        <?= $_SESSION['name'] ?> </h2>
                    <a href="http://localhost/pfe-lastversion/profil.php"
                        class="list-group-item list-group-item-action bg-light">Over view</a>
                    <a href="http://localhost/pfe-lastversion/profil.php?section=setting"
                        class="list-group-item list-group-item-action bg-light">Settings</a>
                </div>

                <!-- Page Content -->
                <div class=" w-100 ">
                    <div class="container text-center ">

                        <?php if( (isset($_GET['section']) && $_GET['section'] == "" ) || !isset($_GET['section']) ) : ?>

                        <h1 class="mt-4 pb-3">Personal information : </h1>

                        <h4 class="text-warning font-weight-bold "> 
                            Your name : <b class="text-dark text-uppercase">
                                <?= $_SESSION['name']; ?> </b> 
                        </h4>

                        <h4 class="text-warning font-weight-bold"> Your email : <b class="text-dark text-uppercase">
                                <?= $_SESSION['email']; ?> </b> 
                        </h4>

                        <h4 class="text-warning font-weight-bold"> Your birthday : <b class="text-dark text-uppercase">
                                <?= $_SESSION['birth']; ?> </b> 
                        </h4>

                        <h4 class="text-warning font-weight-bold"> Your phone : <b class="text-dark text-uppercase">
                                <?= $_SESSION['phone']; ?> </b> 
                        </h4>

                        <h4 class="text-warning font-weight-bold"> Your gender : <b class="text-dark text-uppercase">
                                <?= $_SESSION['sexe']; ?> </b> 
                        </h4>
                    
                        <div>
                            <h1 class="mt-4 text-center">Advancement in courses : </h1>
                            <div class="d-flex flex-column pt-4 justify-content-around">

                            <?php foreach($sections as $section) : ?>
                                <div>
                                    <?php 
                                        $req=$bdd->prepare("SELECT * FROM cours WHERE id_section = ?"); 
                                        $req->execute([$section['id']]);
                                        $courses=$req->fetchAll();
                                    ?>
                                    <?php if(!empty($courses)) : ?>
                                        <table class="table table-dark table-striped table-bordered ">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="text-capitalize"> <?=$section['nom']?> courses </th>
                                                    <th> Statut of tests </th>
                                                </tr>
                                            </thead>

                                        <?php foreach ($courses as $course) : ?>
                                        
                                            <?php 
                                                $req=$bdd->prepare("SELECT id FROM test WHERE id_cours=?"); 
                                                $req->execute([$course['id']]);
                                                $test_info=$req->fetch();
                                                $etat="Test Reussi";                 
                                                $req = $bdd->prepare("SELECT * FROM resultat WHERE  num=? AND etat=? AND id_user = ? ");
                                                $req->execute(array($test_info['id'],$etat,$_SESSION['id']));
                                                $ok=$req->rowCount();
                                                if($ok){
                                                    $resultat="Test reussi";
                                                }else{
                                                    $resultat="Test pas reussi";
                                                }
                                            ?>
                                            <tr <?php if(isset($resultat) && $resultat=="Test reussi") : ?> class="bg-success" <?php else : ?> class="bg-danger" <?php endif; ?>> 

                                                <td><?= $course['titre'] ?></td>

                                                <td><?= $resultat;?></td>

                                            </tr>
                                            
                                        <?php endforeach; ?>
                                        </table>
                                        <br>
                                        <hr class="w-50 ">
                                        <br>
                                    <?php else : ?>

                                    <?php endif; ?>
                                </div>

                               
                            <?php endforeach; ?>
                            </div>

                        </div>

                        <?php elseif(isset($_GET['section']) && !isset($_GET['option']) && $_GET['section']='setting' ): ?>

                        <a href="http://localhost/pfe-lastversion/profil.php?section=setting&option=changepwd">
                            <button class="btn btn-outline-dark p-2 m-5"> Change your password </button></a>
                        <a href="http://localhost/pfe-lastversion/profil.php?section=setting&option=changemail">
                            <button class="btn btn-outline-dark p-2 pr-4 pl-4 m-5"> Change your email </button></a>
                        <br>

                        <a href="http://localhost/pfe-lastversion/profil.php?section=setting&option=delete"> <button
                                class="btn btn-outline-danger p-2 mb-2"> Delete your account
                            </button></a>

                        <?php endif; ?>

                        <?php if(isset($_GET['section']) && isset($_GET['option']) && $_GET['section']=='setting' && $_GET['option']=='changepwd') :  ?>
                        
                        <form action="" method="POST">
                            <fieldset style="border:3px solid black;" class="p-3 border-dark rounded ">
                                <legend style="width:auto; letter-spacing: 2px;" class="pr-3 pl-3"> Change password
                                </legend>
                                <div class="form-group">
                                    <label for="oldpassword"><i
                                            class="zmdi zmdi-account material-icons-name"></i></label>
                                    <input type="password" name="oldpassword" id="oldpassword"
                                        placeholder="Votre ancien mot de pase" />
                                </div>
                                <div class="form-group">
                                    <label for="newpassword"><i class="zmdi zmdi-email"></i></label>
                                    <input type="password" name="newpassword" id="newpassword"
                                        placeholder="New password" />
                                </div>
                                <div class="form-group">
                                    <label for="confirmnewpassword"><i class="zmdi zmdi-lock"></i></label>
                                    <input type="password" name="confirmnewpassword" id="confirmnewpassword"
                                        placeholder="Confirm new password" />
                                </div>
                                <div class="form-group form-button">
                                    <input class="btn btn-lg btn-outline-dark btn-block" type="submit" name="changepwd"
                                        value="Modifier son mot de passe"> </input>
                                </div>
                        </form>

                        <?php endif; ?>

                        <?php if(isset($_GET['section']) && isset($_GET['option']) && $_GET['section']=="setting" && $_GET['option']=='changemail') :  ?>
                        
                        <form action="" method="POST">
                            <fieldset style="border:3px solid black;" class="p-3 border-dark rounded ">
                                <legend style="width:auto; letter-spacing: 2px;" class="pr-3 pl-3"> Change email
                                </legend>
                                <div class="form-group">
                                    <label for="password"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                    <input type="password" name="password" id="password"
                                        placeholder="Votre mot de passe actuelle" />
                                </div>
                                <div class="form-group">
                                    <label for="oldemail"><i class="zmdi zmdi-email"></i></label>
                                    <input type="email" name="oldemail" id="oldemail"
                                        placeholder="Votre ancien email" />
                                </div>
                                <div class="form-group">
                                    <label for="newemail"><i class="zmdi zmdi-lock"></i></label>
                                    <input type="email" name="newemail" id="newemail"
                                        placeholder="Votre nouveau email" />
                                </div>
                                <div class="form-group form-button">
                                    <input class="btn btn-lg btn-outline-dark btn-block" type="submit" name="changemail"
                                        value="Modifier son email"> </input>
                                </div>
                        </form>

                        <?php endif; ?>

                        <?php if(isset($_GET['section']) && isset($_GET['option']) && $_GET['section']=='setting' && $_GET['option']=='delete') :  ?>

                        <form action="" method="POST">
                            <h3 class="text-danger font-weight-bold lead text-center"> Etes vous sur de vouloir
                                suprrimer votre compte ? </h3>
                            <br>
                            <h3 class="text-danger font-weight-bold lead text-center"> Tout vos données vont etre
                                suprimmer </h3>
                            <br>
                            <div class="form-group form-button">
                                <input class="btn btn-lg btn-outline-danger btn-block" type="submit"
                                    name="deleteaccount" value="Suprimmer mon compte"> </input>
                            </div>
                            <div class="form-group form-button">
                                <input class="btn btn-lg btn-outline-dark btn-block" type="submit" name="annuler"
                                    value="Annuler"> </input>
                            </div>
                        </form>

                        <?php endif; ?>
                    </div>


                </div>
            </div>
        </div>
    </section>

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
    <script src="js/js-login/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(".alert").delay(5000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>

</body>

</html>
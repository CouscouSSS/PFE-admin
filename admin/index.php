<?php 

session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Panneau d'administration</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">Panneau d'administration</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Interface</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <?php if($_SESSION['role']=='admin' || $_SESSION['role']=='admin_membre') : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Membres</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Gestion des membres</h6>
                            <a class="collapse-item" href="listemembre.php">Liste des membres</a>
                            <a class="collapse-item" href="ajoutermembre.php">Ajouter un membre</a>
                            <a class="collapse-item" href="confirmermembre.php">Confirmer un membre</a>
                            <a class="collapse-item" href="suprimermembre.php">Suprimer un membre</a>
                            <a class="collapse-item" href="modifiermembre.php">Editer un membre</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <?php if($_SESSION['role']=='admin' || $_SESSION['role']=='admin_cours') : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSection"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Section</span>
                    </a>
                    <div id="collapseSection" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Gestion des section</h6>
                            <a class="collapse-item" href="listesections.php">Liste des sections</a>
                            <a class="collapse-item" href="ajoutersection.php">Ajouter une section</a>
                            <a class="collapse-item" href="suprimersection.php">Suprimer une section</a>
                            <a class="collapse-item" href="modifiersection.php">Modifier une section</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <!-- Nav Item - Utilities Collapse Menu -->
            <?php if($_SESSION['role']=='admin' || $_SESSION['role']=='admin_cours') : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Cours</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Gestion des cours</h6>
                            <a class="collapse-item" href="listecours.php">Liste des cours</a>
                            <a class="collapse-item" href="ajoutercours.php">Ajouter un cours</a>
                            <a class="collapse-item" href="modifiercours.php">Modifier un cours</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <?php if($_SESSION['role']=='admin' || $_SESSION['role']=='admin_cours') : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseChapitre"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Chapitre</span>
                    </a>
                    <div id="collapseChapitre" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Gestion des chapitre</h6>
                            <a class="collapse-item" href="listechapitre.php">Liste des chapitre</a>
                            <a class="collapse-item" href="ajouterchapitre.php">Ajouter un chapitre</a>
                            <a class="collapse-item" href="suprimerchapitre.php">Suprimer un chapitre</a>
                            <a class="collapse-item" href="modifierchapitre.php">Modifier un chapitre</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <?php if($_SESSION['role']=='admin' || $_SESSION['role']=='admin_cours') : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseExercice"
                        aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Exercice</span>
                    </a>
                    <div id="collapseExercice" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Gestion des chapitre</h6>
                            <a class="collapse-item" href="listexercice.php">Liste des exercices</a>
                            <a class="collapse-item" href="ajouterexercice.php">Ajouter un exercice</a>
                            <a class="collapse-item" href="suprimerexercice.php">Suprimmer un exercice</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <?php if($_SESSION['role']=='admin') : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseadmin"
                        aria-expanded="true" aria-controls="collapseadmin">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Administration</span>
                    </a>
                    <div id="collapseadmin" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Gestion administrateur</h6>
                            <a class="collapse-item" href="listadmin.php">List des admin</a>
                            <a class="collapse-item" href="ajouteradmin.php">Ajouter un admin</a>
                            <a class="collapse-item" href="suprimeradmin.php">Suprimer un admin </a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <!-- Divider -->
            <hr class="sidebar-divider">


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <a href="../deco.php"> <button class="btn btn-outline-danger"> Log-out </button> </a>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa molestiae blanditiis inventore dolores quasi consectetur, quidem illo laborum! Nam, repellat asperiores maxime quisquam voluptates reiciendis minus officia aspernatur perspiciatis rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat neque ipsum qui nulla possimus fugiat dolore maxime, voluptas voluptatum illum? Aliquid placeat recusandae modi officiis natus in ab quidem! Perferendis? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quas, sed sequi distinctio earum aliquid eius laborum sint voluptates! Et est inventore labore veritatis corrupti fuga ipsa doloremque aliquid error reprehenderit? Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut autem id voluptatibus illo eligendi accusantium ipsa laborum quas dolor illum, officiis modi ab error tempora, saepe maxime possimus esse eaque. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, nihil sequi necessitatibus quos qui ullam laboriosam non unde repellendus voluptas odit libero accusantium tempore dolorum, quae hic architecto excepturi officiis! </h1>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script>
        $(".alert").delay(3000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>

</body>

</html>
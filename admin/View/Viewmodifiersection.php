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
                            <a class="collapse-item" href="suprimercours.php">Supprimer un cours</a>
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
                            <a class="collapse-item" href="listexercice.php">List des exercice</a>
                            <a class="collapse-item" href="ajouterexercice.php">Ajouter un exercice</a>
                            <a class="collapse-item" href="modifierexercice.php">Modifier un exercice</a>
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
                    <?php if(!isset($_GET['section'])): ?>
                    <h3 class=" text-center pb-3 font-weight-bold mb-0 text-gray-800"> Voici la liste des section
                        disponible maitenant : </h3>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['flash'])) : ?>

                        <?php foreach($_SESSION['flash'] as $type => $message):?>

                            <div class="alert fade show alert-<?= $type ?>">
                                <div style="font-family:Rubik,sans-serif;"
                                    class="pt-2 pb-2 lead text-align-center text-center ">
                                    <i class="fas fa-exclamation-circle"></i> <?= $message ?>
                                    <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                                    </button>
                                </div>
                            </div>

                        <?php  endforeach ?>

                        <?php unset($_SESSION['flash']); ?>

                    <?php endif ?>

                    <?php if(!isset($_GET['section'])) : ?>
                        <form method="POST" action="">
                            <div class="form-row mb-2">
                                <div class="col-10">
                                    <input type="text" name="search_bar" class="form-control" placeholder="Search..." ">
                                    </div>
                                    <div class=" col-2">
                                    <input type="submit" name="submit" class="psm-2 form-control border " value="Search">
                                </div>
                            </div>
                        </form>

                        <?php if(!empty($sections)) : ?>
                            <table class="font-weight-bold table-responsive table text-center table-bordered" id="dataTable"
                                width="100%" cellspacing="0">
                                <thead class="thead-dark ">
                                    <tr>
                                    <tr>
                                        <th style="vertical-align: middle;">Nom</th>
                                        <th style="vertical-align: middle;">Niveau </th>
                                        <th style="vertical-align: middle;">Objectif</th>
                                        <th style="vertical-align: middle;">Modifier la section</th>
                                    </tr>
                                </thead>

                                <?php foreach($sections as $section) : ?>

                                <tr>
                                <tr>
                                <td class="bg-warning text-white text-uppercase" style="vertical-align: middle;">
                                    <?=$section['nom'] ?> </td>
                                <td style="vertical-align: middle;"> <?=$section['niveau'] ?> </td>
                                <td style="vertical-align: middle;"> <?=$section['objectif'] ?> </td>
                                <td style="vertical-align: middle;"> <a href="modifiersection.php?section=edit&id=<?=$section['id']?>"> <button class="btn btn-lg btn-outline-warning"> Modifier </button></a> </td>
                            </tr>


                                </tr>

                                <?php endforeach; ?>

                                <tfoot class="thead-dark ">
                                    <tr>
                                        <th style="vertical-align: middle;">Nom</th>
                                        <th style="vertical-align: middle;">Niveau </th>
                                        <th style="vertical-align: middle;">Objectif</th>
                                        <th style="vertical-align: middle;">Modifier la section</th>
                                    </tr>
                                </tfoot>

                            </table>
                            
                        <?php else : ?>
                            <br>

                            <div class="text-center bg-danger text-white pb-3 " style="border-radius:5px;">
                                
                                <h1 class="display-3 "> <i class="fas fa-exclamation-circle"></i> Aucune section n'a été trouvé pour la recherche que vous avez effectué </h1>
                                <a href="modifiersection.php"> <button class="btn btn-lg btn-outline-light"> Revenir en arriere ? </button></a>
                            </div>
                            
                        <?php endif; ?>

                    <?php else : ?>
                        <?php  
                            $req=$bdd->prepare("SELECT * FROM section WHERE id=?");
                            $id=htmlentities($_GET['id']);
                            $req->execute([$id]); 
                            $sections=$req->fetch();
                        ?>

                        <h3 class="font-weight-bold  text-center pb-3">Vous etes entrain de modier maintenant les
                        information de la section : <br> <b class="text-danger"><?= $sections['nom'] ?>.</b></h3>

                        <?php if(!empty($errors)) : ?>
                            <div class="alert alert-danger bg-danger ">
                                <div class="text-white pb-3"> <i class="fas fa-exclamation-circle"></i> Veuillez verifié les
                                    champs suivant : </div>
                                <?php foreach($errors as $error) : ?>
                                <ul>
                                    <li class="text-white"> <?= $error ?> </li>
                                </ul>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    <form action="" method="POST">

                        <div class="form-group">
                        <h3 class="font-weight-bold font-size my-1 mr-2 text-dark" > Modifier le nom de la section : </h3>
                            <input type="text" name="nom" class="form-control form-control-user"
                                placeholder="Modifier le nom de la section" value="<?=$sections['nom']?>" />
                        </div>

                        <div class="form-group">
                        <h3 class="font-weight-bold font-size my-1 mr-2 text-dark" > Modifier le niveau de la  section : </h3>
                            <input type="text" name="niveau" class="form-control form-control-user"
                                placeholder="Modifier le niveau de la section"
                                value="<?=$sections['niveau']?>" />
                        </div>

                        <div class="form-group">
                        <h3 class="font-weight-bold font-size my-1 mr-2 text-dark" > Modifier l'objectif de la section : </h3>
                        <textarea name="objectif" class="form-control" id="exampleFormControlTextarea1" rows="3" 
                        placeholder="Modifier l'objectif de la section"><?=$sections['objectif']?></textarea>
                            
                        </div>

                        <div class="form-group">
                            <button type="submit" name="update_section" style="border-radius:100px;"
                                class="btn btn-primary btn-user btn-block text-uppercase"> Modifier les informations de la section </button>
                        </div>

                    </form>

                    <?php endif; ?>

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
    <script src="https://kit.fontawesome.com/6e8ba3d05b.js" crossorigin="anonymous"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script>
        $(".alert").delay(3000).slideUp(400, function() {
            $(this).alert('close');
        });
    </script>

</body>

</html>
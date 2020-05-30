<?php

    include "../connexion.inc.php";

    session_start();

    if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

        $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
        header('location: ../index.php');
    
    }

    $req=$bdd->query("SELECT * FROM cours");
    $courses=$req->fetchAll();

    $req=$bdd->query("SELECT * FROM section ");
    $sections=$req->fetchAll();

    if(isset($_POST['submit'])){
        if(!empty($_POST['search_bar'])){
            $searchbar='%'.$_POST['search_bar'].'%'; 

            $req=$bdd->prepare("SELECT * FROM cours WHERE id_section=(SELECT id FROM section WHERE nom LIKE ?) OR titre LIKE ? OR sous_titre LIKE ?");
            $req->execute([$searchbar,$searchbar,$searchbar]);
            $courses=$req->fetchAll();

            $req=$bdd->query("SELECT * FROM section ");
            $sections=$req->fetchAll();
        }else{

            $req=$bdd->query("SELECT * FROM cours");
            $courses=$req->fetchAll();

            $req=$bdd->query("SELECT * FROM section ");
            $sections=$req->fetchAll();
        }

    }



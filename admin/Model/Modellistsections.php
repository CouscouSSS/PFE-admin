<?php 

    include "../connexion.inc.php";

    session_start();

    if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

        $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
        header('location: ../index.php');
    
    }

    $req=$bdd->query("SELECT * FROM section");
    $sections=$req->fetchAll();

    if(isset($_POST['submit'])){
        if(!empty($_POST['search_bar'])){
            $searchbar='%'.$_POST['search_bar'].'%'; 
            $req=$bdd->prepare("SELECT * FROM section WHERE nom LIKE ? OR niveau LIKE ? OR objectif LIKE ?");
            $req->execute([$searchbar,$searchbar,$searchbar]);
            $sections=$req->fetchAll();
        }else{
            $req=$bdd->query("SELECT * FROM section");
            $sections=$req->fetchAll();
        }
    }


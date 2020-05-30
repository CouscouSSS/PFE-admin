<?php

include "../connexion.inc.php";
session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}

$req=$bdd->query("SELECT * FROM chapitre");
$chapitres=$req->fetchAll();

$req=$bdd->query("SELECT * FROM cours");
$courses=$req->fetchAll();

if(isset($_POST['submit'])){
    if(!empty($_POST['search_bar'])){
        $searchbar='%'.$_POST['search_bar'].'%'; 

        $req=$bdd->prepare("SELECT * FROM chapitre WHERE id_cours=(SELECT id FROM cours WHERE titre LIKE ?) OR titre LIKE ? OR contenue LIKE ? ");
        $req->execute([$searchbar,$searchbar,$searchbar]);
        $chapitres=$req->fetchAll();

        $req=$bdd->query("SELECT * FROM cours");
        $courses=$req->fetchAll();
    }else{

        $req=$bdd->query("SELECT * FROM chapitre");
        $chapitres=$req->fetchAll();

        $req=$bdd->query("SELECT * FROM cours");
        $courses=$req->fetchAll();
    }

}

if(isset($_GET['id'])){
    $req=$bdd->prepare("DELETE FROM chapitre WHERE id=?");
    $req->execute([$_GET['id']]);
    $_SESSION['flash']['success']="Votre chapitre a été suprimer avec succées";
    header('location:suprimerchapitre.php');
    exit();
}





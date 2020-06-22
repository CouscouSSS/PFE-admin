<?php 
include "../connexion.inc.php";

session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}

$req=$bdd->query("SELECT * FROM membre ");
$membres=$req->fetchAll();

if(isset($_POST['submit'])){
    if(!empty($_POST['search_bar'])){
        $req=$bdd->prepare("SELECT * FROM membre WHERE name LIKE ? OR email LIKE ? OR dateofbirth LIKE ? OR sexe LIKE ? or phone LIKE ? or confirmed_at LIKE ? ");
        $searchbar='%'.$_POST['search_bar'].'%'; 
        $req->execute(array($searchbar,$searchbar,$searchbar,$searchbar,$searchbar,$searchbar));
        $membres=$req->fetchAll();
    }else{
        $req=$bdd->query("SELECT * FROM membre ");
        $membres=$req->fetchAll();
    }
}



if(isset($_GET['id'])){
    //recuperation de ces info pour le suprimmer de la table recover
    $req=$bdd->prepare("SELECT * FROM membre WHERE id=?");
    $req->execute([$_GET['id']]);
    $userinfo=$req->fetch();

    //supression de la table resultat
    $req=$bdd->prepare("DELETE FROM resultat WHERE id_user=?");
    $req->execute([$_GET['id']]);

    //supression de la table evenement du calendrier
    $req=$bdd->prepare("DELETE FROM events WHERE id_user=?");
    $req->execute([$_GET['id']]);

    //supression de la table reover 
    $req=$bdd->prepare("DELETE FROM recover WHERE email=?");
    $req->execute([$userinfo['email']]);

    //supression du membre
    $req=$bdd->prepare("DELETE FROM membre WHERE id=?");
    $req->execute([$_GET['id']]);
    
    $_SESSION['flash']['success']="Le compte que vous avez chois a été suprimer avec succes";
    header('location:suprimermembre.php');
    exit();
}


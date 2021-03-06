<?php

include "../connexion.inc.php";

session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}

$req=$bdd->query("SELECT * FROM membre WHERE confirmation_token IS NOT NULL");
$membres=$req->fetchAll();


if(isset($_POST['submit'])){
    if(!empty($_POST['search_bar'])){
        $req=$bdd->prepare("SELECT * FROM membre WHERE name LIKE ? or email LIKE ? or confirmed_at LIKE ? ");
        $searchbar='%'.$_POST['search_bar'].'%'; 
        $req->execute(array($searchbar,$searchbar,$searchbar));
        $membres=$req->fetchAll();
    }else{
        $req=$bdd->query("SELECT * FROM membre WHERE confirmation_token IS NOT NULL");
        $membres=$req->fetchAll();
    }
}

if(isset($_GET['id'])){
    $req=$bdd->prepare("UPDATE membre SET confirmed_at = NOW(),confirmation_token = NULL WHERE id=?");
    $req->execute([$_GET['id']]);
    $_SESSION['flash']['success']="Votre compte a été confirmé avec succées";
    header('location:confirmermembre.php');
    exit();
}




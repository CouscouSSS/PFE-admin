<?php 

include "../connexion.inc.php";
session_start();

if($_SESSION['role']!='admin'){

    $_SESSION['flash']['danger']="Vous n'avez pas accés a cette page ";
    header('location: ../index.php');

}

$req=$bdd->prepare("SELECT * FROM membre WHERE role LIKE ?");
$req->execute(["admin_%"]);
$admins=$req->fetchAll();

if(isset($_POST['submit'])){
    if(!empty($_POST['search_bar'])){

    $searchbar='%'.$_POST['search_bar'].'%'; 

    $req=$bdd->prepare("SELECT * FROM membre WHERE name LIKE ? or email LIKE ? or confirmed_at LIKE ?");
    $req->execute([$searchbar,$searchbar,$searchbar]);
    $admins=$req->fetchAll();
    
    }else{
        $req=$bdd->prepare("SELECT * FROM membre WHERE role LIKE ?");
        $req->execute(["admin_%"]);
        $admins=$req->fetchAll();
    }
}



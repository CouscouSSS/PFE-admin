<?php 

include "../connexion.inc.php";

session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');
    exit();
}


$req=$bdd->query("SELECT * FROM test");
$tests=$req->fetchAll();

if(isset($_POST['submit'])){
    if(!empty($_POST['search_bar'])){
        $searchbar='%'.$_POST['search_bar'].'%'; 

        $req=$bdd->prepare("SELECT * FROM test WHERE id_cours=(SELECT id FROM cours WHERE titre LIKE ?) OR titre LIKE ?");
        $req->execute([$searchbar,$searchbar]);
        $tests=$req->fetchAll();

    }else{

        $req=$bdd->query("SELECT * FROM test");
        $tests=$req->fetchAll();
        
    }

}


if(isset($_GET['id']) && is_numeric($_GET['id'])){

    $req=$bdd->prepare("DELETE FROM question WHERE id_test = ?");
    $req->execute([$_GET['id']]);

    
    $req=$bdd->prepare("DELETE FROM test WHERE id = ?");
    $req->execute([$_GET['id']]);

    $_SESSION['flash']['success']="Votre exercice a été suprimer avec succes";
    header('location:suprimerexercice.php');
    exit();

}




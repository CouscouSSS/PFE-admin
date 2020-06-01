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

if(isset($_GET['id'])){
    $req=$bdd->prepare("SELECT * FROM section WHERE id=?");
    $req->execute([$_GET['id']]);
    $ok=$req->rowCount();
    if(!$ok){
        $_SESSION['flash']['danger']="Une erreur s'est produite : Cette section n'existe pas";
        header('location:modifiersection.php');
        exit();
    }
}

if(isset($_GET['id'])){
    $idsection=htmlentities($_GET['id']);

    $req=$bdd->prepare("DELETE FROM question WHERE id_test=(SELECT id FROM test WHERE id_cours=(SELECT id from cours WHERE id_section=?))");
    $req->execute([$idsection]);

    $req=$bdd->prepare("DELETE FROM test WHERE id_cours=(SELECT id FROM cours WHERE id_section=?)");
    $req->execute([$idsection]);

    $req=$bdd->prepare("DELETE FROM cours WHERE id_section=?");
    $req->execute([$idsection]);

    $req=$bdd->prepare("DELETE FROM section WHERE id=?");
    $req->execute([$idsection]);

    $_SESSION['flash']['success']="Votre section a été suprimer avec succes";
    header("location: listesections.php");
    exit();

}

?>
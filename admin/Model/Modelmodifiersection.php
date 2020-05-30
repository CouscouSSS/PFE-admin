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

if(isset($_POST['update_section'])){
    $errors=array();

    if(empty($_POST['nom'] && $_POST['niveau'] && $_POST['objectif'])){
        $errors['empty']="Vous devez modifier au moins un champ pour pouvoir modifier une section";
    }

    if(!empty($_POST['nom'])){
        $req=$bdd->prepare("SELECT * FROM section WHERE titre=?");
        $req->execute([$_POST['nom']]);
        $ok=$req->rowCount();
        if($ok){
            $errors['nom']="Cette nom de section existe déja vous ne pouvez pas l'utiliser";
        }
        else{
            $req=$bdd->prepare(" UPDATE section SET nom = ? WHERE id=?");
            $req->execute(array($_POST['nom'],$_GET['id']));
            $_SESSION['flash']['success']="La section a été modifié avec success";
            header("location: modifiersection.php");
            exit();
        }
    }
    else{
        $errors['nom']="Veuillez saisir le nom de la section";
    }

    if(!empty($_POST['niveau'])){
        $req=$bdd->prepare(" UPDATE section SET niveau = ? WHERE id=?");
        $req->execute(array($_POST['niveau'],$_GET['id']));
        $_SESSION['flash']['success']="La section a été modifié avec success";
        header("location: modifiersection.php");
        exit();
    }
    else{
        $errors['niveau']="Veuillez saisir le niveau de la section";
    }

    if(!empty($_POST['objectif'])){
        $req=$bdd->prepare("SELECT * FROM section WHERE objectif=?");
        $req->execute([$_POST['objectif']]);
        $ok=$req->rowCount();
        if($ok){
            $errors['objectif']="Cette objectif existe déja pour une autre section vous ne pouvez pas l'utiliser";
        }
        else{
            $req=$bdd->prepare(" UPDATE section SET objectif = ? WHERE id=?");
            $req->execute(array($_POST['objectif'],$_GET['id']));
            $_SESSION['flash']['success']="La section a été modifié avec success";
            header("location: modifiersection.php");
            exit();
        }
    }
    else{
        $errors['objectif']="Veuillez saisir l'objectif de la section";
    }


}


?>
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


if(isset($_GET['section']) && $_GET['section']!='edit'){ 
    $_SESSION['flash']['danger']="Une erreur s'est produite : Veuillez ne pas essayé d'entré des information erroné";
    header('location:index.php');
    exit();
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

if(isset($_POST['update_section'])){
    
    $errors=array();
    $success=false;

    if(empty($_POST['nom']) && empty($_POST['niveau']) && empty($_POST['objectif'])){
        $errors['empty']="Vous devez modifier au moins un champ pour pouvoir modifier une section";
    }else{

        if(!empty($_POST['nom'])){
            $req=$bdd->prepare("SELECT * FROM section WHERE titre=?");
            $req->execute([$_POST['nom']]);
            $ok=$req->rowCount();

            $req=$bdd->prepare(" UPDATE section SET nom = ? WHERE id=?");
            $req->execute(array($_POST['nom'],$_GET['id']));
            $success=true;
        }
        
    
        if(!empty($_POST['niveau'])){
            $req=$bdd->prepare(" UPDATE section SET niveau = ? WHERE id=?");
            $req->execute(array($_POST['niveau'],$_GET['id']));
            $_SESSION['flash']['success']="La section a été modifié avec success";
            header("location: modifiersection.php");
            $success=true;
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
                $success=true;
            }
        }

    }

    if($success){
        $_SESSION['flash']['success']="Votre section a été modifier avec succès";
        header('location:modifiersection.php');
        exit();
    }

}




?>
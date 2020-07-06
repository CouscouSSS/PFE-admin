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

$errors=array();

if(isset($_POST['update_section'])){
    
    $req=$bdd->prepare("SELECT * FROM section WHERE id =?");
    $req->execute([$_GET['id']]);
    $sectioninfo=$req->fetch();

    //Verification si un changement a été fait
    if($_POST['nom']==$sectioninfo['nom'] && $_POST['niveau']==$sectioninfo['niveau'] && $_POST['objectif']==$sectioninfo['objectif']){
        $errors['nochange']="Il faut au moins modifier un champ pour pouvoir modifier les informations d'une section";
    }


    //Modification du nom de la section
    if(!empty($_POST['nom'])){
        if($_POST['nom']!=$sectioninfo['nom']){
            $nom=htmlentities($_POST['nom']);
            $req=$bdd->prepare("UPDATE section SET nom=? WHERE id=?");
            $req->execute([$nom,$_GET['id']]);
            $_SESSION['flash']['success']="Votre section a été modifier avec succes";
            header('location:modifiersection.php');
        }
    }

    //Modification du niveau de la section
    if(!empty($_POST['niveau'])){
        if($_POST['niveau']!=$sectioninfo['niveau']){
            $niveau=htmlentities($_POST['niveau']);
            $req=$bdd->prepare("UPDATE section SET niveau=? WHERE id=?");
            $req->execute([$niveau,$_GET['id']]);
            $_SESSION['flash']['success']="Votre section a été modifier avec succes";
            header('location:modifiersection.php');
        }
    }

    //Modification du objectif de la section
    if(!empty($_POST['objectif'])){
        if($_POST['objectif']!=$sectioninfo['objectif']){
            $req=$bdd->prepare("SELECT * FROM section WHERE objectif=?");
            $req->execute([$_POST['objectif']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['objectif']="Cette objectif et le meme objectif d'une autre section vous ne pouvez pas l'utiliser";
            }
            else{
                $objectif=htmlentities($_POST['objectif']);
                $req=$bdd->prepare("UPDATE section SET objectif=? WHERE id=?");
                $req->execute([$objectif,$_GET['id']]);
                $_SESSION['flash']['success']="Votre section a été modifier avec succes";
                header('location:modifiersection.php');
            }
        }
    }


}





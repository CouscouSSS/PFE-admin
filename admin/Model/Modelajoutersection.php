<?php 

include "../connexion.inc.php";
session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}

$errors=array();

if(isset($_POST['add_section'])){


    if(empty($_POST['nom']) || !preg_match("/^[a-zA-Z]+$/",$_POST['nom'])){
        $errors['nom']="Veuillez saisir un nom valide ou bien remplire ce champ";
    }

    if(empty($_POST['niveau']) ){
        $errors['niveau']="Veuillez saisir le niveau de la section";
    }

    if(empty($_POST['objectif'])){
        $errors['objectif']="Veuillez saisir l'objectif de la section";
    }else{
        $req=$bdd->prepare("SELECT * FROM section WHERE objectif=?");
        $req->execute([$_POST['objectif']]);
        $ok=$req->rowCount();
        if($ok){
            $errors['objectif']="L'objectif d'une section doit etre unique.";
        }
    }


    if(empty($errors)){
        $req=$bdd->prepare("INSERT INTO section(nom,niveau,objectif) VALUES(?,?,?) ");
        $req->execute([$_POST['nom'],$_POST['niveau'],$_POST['objectif']]);
        $_SESSION['flash']['success']="La section a été ajouté avec succées";
        header('location: listesections.php');
        exit();
    }


}

?>
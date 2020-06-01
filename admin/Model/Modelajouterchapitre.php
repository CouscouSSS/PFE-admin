<?php

include "../connexion.inc.php";
session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}

$req=$bdd->query("SELECT * FROM cours ");
$courses=$req->fetchAll();

$errors=array();

if(isset($_POST['add_chapitre'])){

    if($_POST['cours']=='Cours'){
        $errors['cours']="Veuillez saisir le cours ou vous voulez ajouter ce chapitre";
    }

    if(empty($_POST['titre'])){
        $errors['titre']="Veuillez saisir le titre du chapitre";
    }

    if(empty($_POST['contenue'])){
        $errors['contenue']="Veuillez saisir le contenue du chapitre";
    }else{
        $req=$bdd->prepare("SELECT * FROM chapitre WHERE contenue=?");
        $req->execute([$_POST['contenue']]);
        $ok=$req->rowCount();
        if($ok){
            $errors['contenue']="Le contenue de ce chapitre est le meme qu'un autre chapitre veuillez le changer s'il vous plait";
        }
    }

    if(empty($errors)){
        $req=$bdd->prepare("INSERT INTO chapitre(id_cours,titre,contenue) VALUES(?,?,?)");
        $req->execute([$_POST['cours'],$_POST['titre'],$_POST['contenue']]);
        $_SESSION['flash']['success']="Votre chapitre a été ajouté avec succeés";
        header('location:ajouterchapitre.php');
        exit();
    }



}



?>

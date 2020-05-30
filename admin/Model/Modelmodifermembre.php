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
        $req=$bdd->prepare("SELECT * FROM membre WHERE name LIKE ? or email LIKE ? or confirmed_at LIKE ? ");
        $searchbar='%'.$_POST['search_bar'].'%'; 
        $req->execute(array($searchbar,$searchbar,$searchbar));
        $membres=$req->fetchAll();
    }else{
        $req=$bdd->query("SELECT * FROM membre ");
        $membres=$req->fetchAll();
    }
}

$errors=array();

if(isset($_POST['update_account'])){
    //verification si au moins un champ a été modifier
    if(empty($_POST['name']) && empty($_POST['email'])){
        $errors['empty']="Il faut au moins modifier un champ pour pouvoir continuez";
    }

    //changement du champ nom si il est valide  
    if(!empty($_POST['name']) ){
        if(!preg_match("/^[a-zA-Z]+$/",$_POST['name'])){
            $errors['name']="Veuillez entrez un nom valide";
        }else{
            $name=htmlentities( $_POST['name']);
            $req=$bdd->prepare("UPDATE membre SET name=? WHERE id=?");
            $req->execute([$name,$_GET['id']]);
            $_SESSION['flash']['success']="Votre compte a été modifier avec succes";
            header('location:modifiermembre.php');
            exit();
        }
    }

    //changement de l'email si il est valide
    if(!empty($_POST['email']) ){
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
            $errors['email']="Veuillez entrez une adresse mail valide";
        }else{
            $email=htmlentities($_POST['email']);
            $req= $bdd->prepare('SELECT * FROM membre WHERE email=?');
            $req->execute([$email]);
            $email= $req->fetch();
            if($email){
            $errors['email']="Cette email est déja utilisé par un autre compte ";
            }else{ 
                $email=htmlentities($_POST['email']);
                $req=$bdd->prepare("UPDATE membre SET email=? WHERE id=?");
                $req->execute([$email,$_GET['id']]);
                $_SESSION['flash']['success']="Votre compte a été modifier avec succes";
                header('location:modifiermembre.php'); 
                exit();
            }
        }
    }

}


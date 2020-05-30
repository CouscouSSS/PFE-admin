<?php

include "../connexion.inc.php";
session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}

$errors=array();

if(isset($_POST['add_admin'])){
    if(empty($_POST['name'])){
        $errors['name']="Veuillez entrez un prenom valide ou bien remplire ce champ.";
    }

    if(empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $errors['email']="Veuillez entrez un email valide ou bien remplire ce champ";
    }else{
        $req= $bdd->prepare('SELECT id FROM membre WHERE email=?');
        $req->execute([$_POST['email']]);
        $email= $req->fetch();
        if($email){
          $errors['email']="Cette email a déja été utilisé pour crée un autre compte";
        }
    }

    $ok_admin=array('admin_cours','admin_membre');

    if(empty($_POST['role']) || !in_array($_POST['role'],$ok_admin)){
        $errors['role']="Le role que vous avez rentré n'est pas valide";
    }

    if(empty($_POST['password']) || !preg_match("/^.{6,}$/",$_POST['password'])){
        $errors['password']="Veuillez entrez un mot de passe de plus de 6 caractere ou remplire ce champ";
    }
  
    if(empty($_POST['password_confirm']) || ($_POST['password'] != $_POST['password_confirm']) ){
        $errors['password_confirm']="Les mots de passe ne sont pas identique ou le champ est vide";
    }

    if(empty($errors)){
        $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
        $req=$bdd->prepare("INSERT INTO membre(name,email,password,confirmation_token,confirmed_at,role) VALUES(?,?,?,?,NOW(),?)");
        $req->execute([$_POST['name'],$_POST['email'],$password,NULL,$_POST['role']]);
        $_SESSION['flash']['success']="Votre administrateur a été ajouté avec succées";
        header('location:ajouteradmin.php');
        exit();
    }



}



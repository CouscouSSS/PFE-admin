<?php 

include "../connexion.inc.php";
session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}

$errors=array();

if(isset($_POST['add_account'])){

    if(empty($_POST['name']) || !preg_match("/^[a-zA-Z]+$/",$_POST['name'])){
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

    if(empty($_POST['password']) || !preg_match("/^.{6,}$/",$_POST['password'])){
        $errors['password']="Veuillez entrez un mot de passe de plus de 6 caractere ou remplire ce champ";
    }
  
    if(empty($_POST['password_confirm']) || ($_POST['password'] != $_POST['password_confirm']) ){
        $errors['password_confirm']="Les mots de passe ne sont pas identique ou le champ est vide";
    }

    if(empty($errors)){
        //hashage du mot de passe de l'utilisateur
        $password=password_hash($_POST['password'],PASSWORD_BCRYPT);

        $req= $bdd->prepare("INSERT INTO membre SET name=?,email=?,password=?,role=?");
        $req->execute([$_POST['name'],$_POST['email'],$password,'user']);
            
        $req=$bdd->prepare('UPDATE membre set confirmation_token=NULL,confirmed_at = NOW() WHERE id = ?');
        $user_id=$bdd->lastInsertId();
        $req->execute([$user_id]);
 
        $_SESSION['flash']['success']="Votre utilisateur a été ajouté avec succées";
        header('Location:listemembre.php');
        exit();
    }
}



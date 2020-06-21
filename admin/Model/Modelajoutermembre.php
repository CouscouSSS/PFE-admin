<?php 

function str_random($lenght){

    $alphabet="0123456789azertyuiopqsdfghjklmwxvbnAZERTYUIOPQSDFGHJKLMWXCVBN";

    return substr(str_shuffle(str_repeat($alphabet,$lenght)),0,$lenght); 
}

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

    if(empty($_POST['date'])){
        $errors['date']="Veuillez entrez une date de naissance valide ou bien remplire ce champ";
    }

    if(empty($_POST['tel']) || !preg_match("/^(06).+$/",$_POST['tel']) || strlen($_POST['tel'])!=10 ){
        $errors['tel']="Veuillez entrez un numero de telephone marocain valide ou bien remplire ce champ";
    }else{
        $req=$bdd->prepare('SELECT id FROM membre WHERE phone=?');
        $req->execute([$_POST['tel']]);
        $ok=$req->rowCount();
        if($ok){
            $errors['tel']="Ce numero de telphone est déja utilisé pour un autre compte";
        }
    }

    $sexualite_ok=array('homme','femme');
    if(empty($_POST['gender']) || !in_array($_POST['gender'],$sexualite_ok)){
        $errors['gender']="Veuillez entrez une sexualité valide ou bien remplire ce champ";
    }
 
    if(empty($errors)){
        $password_user=str_random(12);

        $to=$_POST['email'];
        $subject="Identifant de votre compte";
        $message="Bonjour Monsieur : ".$_POST['name']."Voici le mot de passe de votre compte : ".$password_user;
                        
        mail($to,$subject,$message);

        $password=password_hash($password_user,PASSWORD_BCRYPT);

        $req= $bdd->prepare("INSERT INTO membre SET name=?,email=?,dateofbirth=?,phone=?,sexe=?,password=?,role=?");
        $req->execute([$_POST['name'],$_POST['email'],$_POST['date'],$_POST['tel'],$_POST['gender'],$password,'user']);
            
        $req=$bdd->prepare('UPDATE membre set confirmation_token=NULL,confirmed_at = NOW() WHERE id = ?');
        $user_id=$bdd->lastInsertId();
        $req->execute([$user_id]);
 
        $_SESSION['flash']['success']="Votre utilisateur a été ajouté avec succées";
        header('Location:listemembre.php');
        exit();
    }
}



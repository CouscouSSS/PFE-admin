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
        $req=$bdd->prepare("SELECT * FROM membre WHERE name LIKE ? OR email LIKE ? OR dateofbirth LIKE ? OR sexe LIKE ? or phone LIKE ? or confirmed_at LIKE ? ");
        $searchbar='%'.$_POST['search_bar'].'%'; 
        $req->execute(array($searchbar,$searchbar,$searchbar,$searchbar,$searchbar,$searchbar));
        $membres=$req->fetchAll();
    }else{
        $req=$bdd->query("SELECT * FROM membre ");
        $membres=$req->fetchAll();
    }
}

$errors=array();



if(isset($_POST['update_account'])){

    $req=$bdd->prepare("SELECT name,email,dateofbirth,phone,sexe FROM membre WHERE id=?");
    $req->execute([$_GET['id']]);
    $membre=$req->fetch();

    if($_POST['name']==$membre['name'] && $_POST['email']==$membre['email'] && $_POST['date']==$membre['dateofbirth'] && $_POST['tel']==$membre['phone'] && $_POST['gender']==$membre['sexe'] ){
        $errors['nochange']="Il faut au moins modifier un champ pour pouvoir modifier les information d'un etudiant";
    }
   
    // if(empty($_POST['name']) && empty($_POST['email']) && empty($_POST['date']) && empty($_POST['tel']) && empty($_POST['gender']) && empty($errors['nochange'])){
    //     $errors['empty']="Il faut aut moins remplire un champ pour pouvoir modifier les informations";
    // }

    //changement du champ nom si il est valide 
    if(!empty($_POST['name'])){
        if($_POST['name']!=$membre['name']){
            if(!preg_match("/^[a-zA-Z]+$/",$_POST['name'])){
                $errors['name']="Veuillez entrez un nom valide";
            }else{
                $name=htmlentities( $_POST['name']);
                $req=$bdd->prepare("UPDATE membre SET name=? WHERE id=?");
                $req->execute([$name,$_GET['id']]);
                $_SESSION['flash']['success']="Votre compte a été modifier avec succes";
                header('location:modifiermembre.php');
            }
        }
    }

    //changement de l'email d'un etudiant
    if(!empty($_POST['email'])){
        if($_POST['email']!=$membre['email']){
            if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                $errors['email']="Veuillez entrez une adresse mail valide";
            }
            else{
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
                }
            }
        }
    }

    //changement de la date de naissance
    if(!empty($_POST['date'])){    
        if($_POST['date']!=$membre['dateofbirth']){
            $date=htmlentities($_POST['date']);
            $req=$bdd->prepare("UPDATE membre SET dateofbirth=? WHERE id=?");
            $req->execute([$date,$_GET['id']]);
            $_SESSION['flash']['success']="Votre compte a été modifier avec succes";
            header('location:modifiermembre.php'); 
        }
    }

    //changement du numero de telephone de l'etudiant
    if(!empty($_POST['tel'])){
        if($_POST['tel']!=$membre['phone']){
            if(!preg_match("/^(06).+$/",$_POST['tel']) || strlen($_POST['tel'])!=10 ){
                $errors['tel']="Veuillez entrez un numero de telephone marocain valide (commencant par 06 et contient 10 chiffre)";
            }else{
                $req=$bdd->prepare("SELECT * FROM membre WHERE phone=?");
                $req->execute([$_POST['tel']]);
                $ok=$req->rowCount();
                if(!$ok){
                    $tel=htmlentities($_POST['tel']);
                    $req=$bdd->prepare('UPDATE membre SET phone=? WHERE id=?');
                    $req->execute([$tel,$_GET['id']]);
                    $_SESSION['flash']['success']="Votre compte a été modifier avec succes";
                    header('location:modifiermembre.php');
                }
                else{
                    $errors['tel']="Ce numero de telephone apartient un autre etudiant";
                }
                
            }
        }
    }

    //changement de la sexualité d'un etudiant en cas d'erreurs
    if(!empty($_POST['gender'])){
        if($_POST['gender']!=$membre['sexe']){
            $gender_ok=array('homme','femme');
            if(!in_array($_POST['gender'],$gender_ok)){
                $errors['gender']="Veuillez entrez une sexualité valide homme ou femme (en miniscule)";    
            }
            else{
                $gender=htmlentities($_POST['gender']);
                $req=$bdd->prepare('UPDATE membre SET sexe=? WHERE id=?');
                $req->execute([$gender,$_GET['id']]);
                $_SESSION['flash']['success']="Votre compte a été modifier avec succes";
                header('location:modifiermembre.php');    
            }
        }
    }



}


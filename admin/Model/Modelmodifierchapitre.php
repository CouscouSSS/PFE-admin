<?php



include "../connexion.inc.php";
session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}

$req=$bdd->query("SELECT * FROM chapitre");
$chapitres=$req->fetchAll();

$req=$bdd->query("SELECT * FROM cours");
$courses=$req->fetchAll();

if(isset($_POST['submit'])){
    if(!empty($_POST['search_bar'])){
        $searchbar='%'.$_POST['search_bar'].'%'; 

        $req=$bdd->prepare("SELECT * FROM chapitre WHERE id_cours=(SELECT id FROM cours WHERE titre LIKE ?) OR titre LIKE ? OR contenue LIKE ? ");
        $req->execute([$searchbar,$searchbar,$searchbar]);
        $chapitres=$req->fetchAll();

        $req=$bdd->query("SELECT * FROM cours");
        $courses=$req->fetchAll();
    }else{

        $req=$bdd->query("SELECT * FROM chapitre");
        $chapitres=$req->fetchAll();

        $req=$bdd->query("SELECT * FROM cours");
        $courses=$req->fetchAll();
    }

}


if(isset($_POST['update_chapitre'])){
    $errors=array();
    if(empty($_POST['titre']) && empty($_POST['contenue'])){
        $errors['empty']="Pour modifier un chapitre il faut au moins remplire un champ";
    }
    else{
        if(!empty($_POST['titre'])){
            $req=$bdd->prepare("SELECT * FROM chapitre WHERE titre=?");
            $req->execute([$_POST['titre']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['titre']="Ce titre existe deja pour un autre chapitre vous ne pouvez pas l'utiliser";
            }else{
                $req=$bdd->prepare("UPDATE chapitre SET titre=? WHERE id=?");
                $req->execute([$_POST['titre'],$_GET['id']]);
                $_SESSION['flash']['success']="Votre chapitre a été modifier avec succes";
                header('location:modifierchapitre.php');
                exit();
            }
        }

        if(!empty($_POST['contenue'])){
            $req=$bdd->prepare("SELECT * FROM chapitre WHERE contenue=?");
            $req->execute([$_POST['contenue']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['contenue']="Ce contenue est le meme qu'un autre chapitre vous ne pouvez pas l'utiliser";
            }else{
                $req=$bdd->prepare("UPDATE chapitre SET contenue=? WHERE id=?");
                $req->execute([$_POST['contenue'],$_GET['id']]);
                $_SESSION['flash']['success']="Le contenue de votre chapitre a été modifier avec success";
                header('location:modifierchapitre.php');
                exit();
            }
        }

    }
}



<?php 

include "../connexion.inc.php";

session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}

//recuperation de toute les sections
$req=$bdd->prepare("SELECT * FROM section");
$req->execute();
$sections=$req->fetchAll();


$errors=array();

//titre ktaba ou chiffre 
//sous titre ktaba ou chiffre 
//image link

if(isset($_POST['add_course'])){
    if(!empty($_POST['img']) && !filter_var($_POST['img'], FILTER_VALIDATE_URL)){
        $errors['img']="Veuillez saisir un lien (URL) renvoyant a l'image que vous avez choisi";  
    }
    elseif($_POST['section']!='Section' && !empty($_POST['titre'])){
        if(empty($_POST['sous_titre']) && empty($_POST['img']) ){
            $req=$bdd->prepare("SELECT * from cours WHERE titre=?");
            $req->execute([$_POST['titre']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['titre']="Le titre que vous avez choisi existe déja pour un autre cours";
            }
            else{
               $req=$bdd->prepare("INSERT INTO cours(titre,id_section) VALUES(?,?)");
               $req->execute([$_POST['titre'],$_POST['section']]);
               $_SESSION['flash']['success']="Votre cours a été ajouté avec success";
               header('location:ajoutercours.php');
               exit(); 
            }
        }

        elseif(!empty($_POST['sous_titre']) && empty($_POST['img'])){
            $req=$bdd->prepare("SELECT * from cours WHERE sous_titre=?");
            $req->execute([$_POST['sous_titre']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['sous_titre']="Le titre que vous avez choisi existe déja pour un autre cours";
            }
            else{
                $req=$bdd->prepare("INSERT INTO cours(titre,id_section,sous_titre) VALUES(?,?,?)");
                $req->execute([$_POST['titre'],$_POST['section'],$_POST['sous_titre']]);
                $_SESSION['flash']['success']="Votre cours a été ajouté avec success";
                header('location:ajoutercours.php');
                exit(); 
             }
        }

        elseif(empty($_POST['sous_titre']) && !empty($_POST['img'])){
            $req=$bdd->prepare("SELECT * from cours WHERE img=?");
            $req->execute([$_POST['img']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['img']="Le titre que vous avez choisi existe déja pour un autre cours";
            }
            else{
                $req=$bdd->prepare("INSERT INTO cours(titre,id_section,img) VALUES(?,?,?)");
                $req->execute([$_POST['titre'],$_POST['section'],$_POST['img']]);
                $_SESSION['flash']['success']="Votre cours a été ajouté avec success";
                header('location:ajoutercours.php');
                exit(); 
             }
        }

        else{
            $req=$bdd->prepare("SELECT * from cours WHERE img=? or sous_titre=?");
            $req->execute([$_POST['img'],$_POST['sous_titre']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['both']="Le titre que vous avez choisi existe déja pour un autre cours";
            }
            else{
                $req=$bdd->prepare("INSERT INTO cours(titre,id_section,img,sous_titre) VALUES(?,?,?,?)");
                $req->execute([$_POST['titre'],$_POST['section'],$_POST['img'],$_POST['sous_titre']]);
                $_SESSION['flash']['success']="Votre cours a été ajouté avec success";
                header('location:ajoutercours.php');
                exit(); 
             }

        }

    }
    else{
        $errors['empty']="Vous devez au moins ecrire un titre et choisir la section pour pouvoir ajouter un cours";
    }
}




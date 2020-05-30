<?php

    include "../connexion.inc.php";

    session_start();

    if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

        $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
        header('location: ../index.php');
    
    }

    $req=$bdd->query("SELECT * FROM cours");
    $courses=$req->fetchAll();

    $req=$bdd->query("SELECT * FROM section ");
    $sections=$req->fetchAll();

    if(isset($_POST['submit'])){
        if(!empty($_POST['search_bar'])){
            $searchbar='%'.$_POST['search_bar'].'%'; 

            $req=$bdd->prepare("SELECT * FROM cours WHERE id_section=(SELECT id FROM section WHERE nom LIKE ?) OR titre LIKE ? OR sous_titre LIKE ?");
            $req->execute([$searchbar,$searchbar,$searchbar]);
            $courses=$req->fetchAll();

            $req=$bdd->query("SELECT * FROM section ");
            $sections=$req->fetchAll();
        }else{

            $req=$bdd->query("SELECT * FROM cours");
            $courses=$req->fetchAll();

            $req=$bdd->query("SELECT * FROM section ");
            $sections=$req->fetchAll();
        }

    }

    
    if(isset($_POST['update_course'])){
        $errors=array();
        
        if(empty($_POST['titre']) && empty($_POST['sous_titre']) && empty($_POST['img']) ){
            $errors['empty']="Il faut au moins modifier un seul champ pour pouvoir modifer un cours";
        }

        if(!empty($_POST['titre'])){
            $req=$bdd->prepare("SELECT * FROM cours WHERE titre=?");
            $req->execute([$_POST['titre']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['titre']="Ce titre de cours existe déja vous ne pouvez pas l'utiliser";
            }else{
                $id=htmlentities($_GET['id']); 
                $req=$bdd->prepare("UPDATE cours SET titre=? WHERE id=?");
                $req->execute([$_POST['titre'],$id]);
                $_SESSION['flash']['success']="Le cours a été modifier avec succes";
                header('location: modifiercours.php');
                exit();
            }
        }

        if(!empty($_POST['sous_titre'])){
            $req=$bdd->prepare("SELECT * FROM cours WHERE sous_titre=?");
            $req->execute([$_POST['sous_titre']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['titre']="Ce sous-titre de cours existe déja vous ne pouvez pas l'utiliser";
            }else{
                $id=htmlentities($_GET['id']); 
                $req=$bdd->prepare("UPDATE cours SET sous_titre=? WHERE id=?");
                $req->execute([$_POST['sous_titre'],$id]);
                $_SESSION['flash']['success']="Le cours a été modifier avec succes";
                header('location: modifiercours.php');
                exit();
            }
        }

        if(!empty($_POST['img'])){
            $req=$bdd->prepare("SELECT * FROM cours WHERE img=?");
            $req->execute([$_POST['img']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['sous_titre']="Cette image apartient a un autre cours vous ne pouvez pas l'utiliser";
            }else{
                $id=htmlentities($_GET['id']); 
                $req=$bdd->prepare("UPDATE cours SET img=? WHERE id=?");
                $req->execute([$_POST['img'],$id]);
                $_SESSION['flash']['success']="Le cours a été modifier avec succes";
                header('location: modifiercours.php');
                exit();
            }
        }

    }

    if(isset($_POST['update_soustitre'])){
        $id=htmlentities($_GET['id']); 
        $req=$bdd->prepare("UPDATE cours SET sous_titre=? WHERE id=?");
        $req->execute(['',$id]);
        $_SESSION['flash']['success']="Le cours a été modifier avec succes";
        header('location: modifiercours.php');
        exit();
    }

    if(isset($_POST['update_img'])){
        $id=htmlentities($_GET['id']); 
        $req=$bdd->prepare("UPDATE cours SET img=? WHERE id=?");
        $req->execute(['',$id]);
        $_SESSION['flash']['success']="Le cours a été modifier avec succes";
        header('location: modifiercours.php');
        exit();
    }



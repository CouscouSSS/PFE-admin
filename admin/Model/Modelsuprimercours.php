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

            $req=$bdd->prepare("SELECT * FROM cours WHERE id_section=(SELECT id FROM section WHERE nom LIKE ?) OR titre LIKE ?");
            $req->execute([$searchbar,$searchbar]);
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


    if(isset($_GET['id'])){
        $req=$bdd->prepare("SELECT id FROM test WHERE id_cours=?");
        $req->execute([$_GET['id']]);
        $test_id=$req->fetch();
        
        if(!empty($test_id)){
            $req=$bdd->prepare("DELETE FROM question WHERE id_test=?");
            $req->execute([$test_id['id']]);
            
            $req=$bdd->prepare("DELETE FROM resultat WHERE num=?");
            $req->execute([$test_id['id']]);

            $req=$bdd->prepare("DELETE FROM test WHERE id=?");
            $req->execute([$test_id['id']]);
            
            $req=$bdd->prepare("DELETE FROM chapitre WHERE id_cours=?");
            $req->execute([$_GET['id']]);

            $req=$bdd->prepare("DELETE FROM cours WHERE id=?");
            $req->execute([$_GET['id']]);

            $_SESSION['flash']['success']="Votre cours a été supprimer avec succes ";
            header('location:suprimercours.php');
            exit();

        }else{
            $req=$bdd->prepare("DELETE FROM chapitre WHERE id_cours=?");
            $req->execute([$_GET['id']]);

            $req=$bdd->prepare("DELETE FROM cours WHERE id=?");
            $req->execute([$_GET['id']]);
            
            $_SESSION['flash']['success']="Votre cours a été supprimer avec succes ";
            header('location:suprimercours.php');
            exit();
        }

    }



<?php 

include "../connexion.inc.php";

session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');
    exit();
}

$req=$bdd->query("SELECT * FROM test");
$tests=$req->fetchAll();


//search bar
if(isset($_POST['submit'])){
    if(!empty($_POST['search_bar'])){
        $searchbar='%'.$_POST['search_bar'].'%'; 

        $req=$bdd->prepare("SELECT * FROM test WHERE id_cours=(SELECT id FROM cours WHERE titre LIKE ?) OR titre LIKE ?");
        $req->execute([$searchbar,$searchbar]);
        $tests=$req->fetchAll();

    }else{

        $req=$bdd->query("SELECT * FROM test");
        $tests=$req->fetchAll();
        
    }

}

if(isset($_GET['id_exo'])){

    $req=$bdd->prepare("SELECT * FROM question WHERE id_test=?");
    $req->execute([$_GET['id_exo']]);
    $questions=$req->fetchAll();
    $_SESSION['id_exo']=$_GET['id_exo'];

}

if(isset($_GET['section'],$_GET['id']) && $_GET['section']==="editq"){

    if(isset($_POST['update_question'])){
        $erros=array();
        if(empty($_POST['question']) && empty($_POST['choix1']) && empty($_POST['choix2']) && empty($_POST['reponse'])){
            $errors['empty']="Il faut au moins entrez une information pour pouvoir modifier une question";
        }
        
        if(!empty($_POST['question'])){
            $req=$bdd->prepare("SELECT * FROM question where question=?"); 
            $req->execute([$_POST['question']]);
            $ok=$req->rowCount();
            if($ok){
                $errors['question']="Cette question existe déja vous ne pouvez pas l'utiliser";
            }else{
                if(!empty($_POST['reponse'])){
                    if($_POST['reponse']!=1 && $_POST['reponse']!=2){
                        $errors['reponse']="Pour la réponse vous ne pouvez entrez que 1 ou bien 2 (le numero du bon choix)";
                    }else{
                        $req=$bdd->prepare("UPDATE question SET question=?,answer=? WHERE id=?");
                        $req->execute(array($_POST['question'],$_POST['reponse'],$_GET['id']));
                        $_SESSION['flash']['success']="Votre question a été modifier avec succés";
                        header("location:modifierexercice.php?section=edit&id_exo=".$_SESSION['id_exo']);
                        unset($_SESSION['id_exo']);
                        exit();
                    }
                }else{
                $req=$bdd->prepare("UPDATE question SET question=? WHERE id=?");
                $req->execute(array($_POST['question'],$_GET['id']));
                $_SESSION['flash']['success']="Votre question a été modifier avec succés";
                header("location:modifierexercice.php?section=edit&id_exo=".$_SESSION['id_exo']);
                unset($_SESSION['id_exo']);
                exit();
                }
            }
        }

        if(!empty($_POST['choix1']) && !empty($_POST['choix2']) &&  !empty($_POST['choix3']) && !empty($_POST['choix2']) ){

            if(empty($_POST['reponse'])){
                $errors['reponse']="Quand vous modifier une question il faut réentrez la valeur de la bonne reponse";
            }
            else{

                if($_POST['reponse']!=1 && $_POST['reponse']!=2 && $_POST['reponse']!=3 && $_POST['reponse']!=4 ){
                    $errors['reponse']="Pour la réponse vous ne pouvez entrez que 1,2,3 ou bien 4 (le numero du bon choix)";
                }else{
                    $req=$bdd->prepare("UPDATE question SET choix1=?,choix2=?,choix3=?,choix4=?,answer=? WHERE id=?");
                    $req->execute(array($_POST['choix1'],$_POST['choix2'],$_POST['choix3'],$_POST['choix4'],$_POST['reponse'],$_GET['id']));
                    $_SESSION['flash']['success']="Votre question a été modifier avec succés";
                    header("location:modifierexercice.php?section=edit&id_exo=".$_SESSION['id_exo']);
                    unset($_SESSION['id_exo']);
                    exit();
                }  
            }

        }

        if(!empty($_POST['choix1'])){

            if(empty($_POST['reponse'])){
                $errors['reponse']="Quand vous modifier une question il faut réentrez la valeur de la bonne reponse";
            }
            else{

                if($_POST['reponse']!=1 && $_POST['reponse']!=2 && $_POST['reponse']!=3 && $_POST['reponse']!=4){
                    $errors['reponse']="Pour la réponse vous ne pouvez entrez que 1,2,3 ou bien 4 (le numero du bon choix)";
                }else{
                    $req=$bdd->prepare("UPDATE question SET choix1=?,answer=? WHERE id=?");
                    $req->execute(array($_POST['choix1'],$_POST['reponse'],$_GET['id']));
                    $_SESSION['flash']['success']="Votre question a été modifier avec succés";
                    header("location:modifierexercice.php?section=edit&id_exo=".$_SESSION['id_exo']);
                    unset($_SESSION['id_exo']);
                    exit();
                }  
            }

        }

        if(!empty($_POST['choix2'])){

            if(empty($_POST['reponse'])){
                $errors['reponse']="Quand vous modifier une question il faut réentrez la valeur de la bonne reponse";
            }
            else{

                if($_POST['reponse']!=1 && $_POST['reponse']!=2 && $_POST['reponse']!=3 && $_POST['reponse']!=4 ){
                    $errors['reponse']="Pour la réponse vous ne pouvez entrez que 1,2,3 ou bien 4 (le numero du bon choix)";
                }else{
                    $req=$bdd->prepare("UPDATE question SET choix2=?,answer=? WHERE id=?");
                    $req->execute(array($_POST['choix2'],$_POST['reponse'],$_GET['id']));
                    $_SESSION['flash']['success']="Votre question a été modifier avec succés";
                    header("location:modifierexercice.php?section=edit&id_exo=".$_SESSION['id_exo']);
                    unset($_SESSION['id_exo']);
                    exit();
                }  
            }

        }

        if(!empty($_POST['choix3'])){
            if(empty($_POST['reponse'])){
                $errors['reponse']="Quand vous modifier une question il faut réentrez la valeur de la bonne reponse";
            }
            else{
                if($_POST['reponse']!=1 && $_POST['reponse']!=2 && $_POST['reponse']!=3 && $_POST['reponse']!=4 ){
                    $errors['reponse']="Pour la réponse vous ne pouvez entrez que 1,2,3 ou bien 4 (le numero du bon choix)";
                }else{
                    
                    $req=$bdd->prepare("UPDATE question SET choix3=?,answer=? WHERE id=?");
                    $req->execute(array($_POST['choix3'],$_POST['reponse'],$_GET['id']));
                    $_SESSION['flash']['success']="Votre question a été modifier avec succés";
                    header("location:modifierexercice.php?section=edit&id_exo=".$_SESSION['id_exo']);
                    unset($_SESSION['id_exo']);
                    exit();
                }  
            }

        }

        if(!empty($_POST['choix4'])){

            if(empty($_POST['reponse'])){
                $errors['reponse']="Quand vous modifier une question il faut réentrez la valeur de la bonne reponse";
            }
            else{

                if($_POST['reponse']!=1 && $_POST['reponse']!=2 && $_POST['reponse']!=3 && $_POST['reponse']!=4 ){
                    $errors['reponse']="Pour la réponse vous ne pouvez entrez que 1,2,3 ou bien 4 (le numero du bon choix)";
                }else{
                    $req=$bdd->prepare("UPDATE question SET choix4=?,answer=? WHERE id=?");
                    $req->execute(array($_POST['choix4'],$_POST['reponse'],$_GET['id']));
                    $_SESSION['flash']['success']="Votre question a été modifier avec succés";
                    header("location:modifierexercice.php?section=edit&id_exo=".$_SESSION['id_exo']);
                    unset($_SESSION['id_exo']);
                    exit();
                }  
            }

        }

        if(!empty($_POST['reponse'])){
            if($_POST['reponse']!=1 && $_POST['reponse']!=2 && $_POST['reponse']!=3 && $_POST['reponse']!=4 ){
                $errors['reponse']="Pour la réponse vous ne pouvez entrez que 1,2,3 ou bien 4 (le numero du bon choix)";
            }else{
                $req=$bdd->prepare("UPDATE question SET answer=? WHERE id=?");
                $req->execute(array($_POST['reponse'],$_GET['id']));
                $_SESSION['flash']['success']="Votre question a été modifier avec succés";
                header("location:modifierexercice.php?section=edit&id_exo=".$_SESSION['id_exo']);
                unset($_SESSION['id_exo']);
                exit();
            }
        }

    }

}





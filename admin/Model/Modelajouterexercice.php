<?php 

include "../connexion.inc.php";
session_start();

if($_SESSION['role']!='admin' && $_SESSION['role']!='admin_cours' && $_SESSION['role']!='admin_membre' ){

    $_SESSION['flash']['danger']="Vous n'avez pas l'accés a cette page (ADMIN ONLY)";
    header('location: ../index.php');

}



$req=$bdd->query("SELECT * FROM cours");
$courses = $req->fetchAll();

if(isset($_POST['add_quizz'])){

    $errors=array();

    //choix du cours pour y ajouter le test par l'administrateur
    if(isset($_POST['cours']) && $_POST['cours']=="Cours"){
        $errors['cours']="Veuillez choisir un cours pour pouvoir y ajouter un exercice.";
    }else{
        //si le cours possede déja un test refus de l'ajout
        $req=$bdd->prepare("SELECT * FROM test WHERE id_cours=?");
        $req->execute([$_POST['cours']]);
        $ok=$req->rowCount();
        if($ok){
            $errors['cours']="Un exercice existe deja pour ce cours vous ne pouvez pas ajouter un autre QCM.";
        }
    }

    //verification de l'ajout du titre du test par l'administrateur
    if(empty($_POST['titre'])){
        $errors['titre']="Veuillez saisir le titre de l'exercice pour pouvoir l'ajouté.";
    }else{
        //si un test existe avec le meme titre refus du titre
        $req=$bdd->prepare("SELECT * FROM test WHERE titre=?");
        $req->execute([$_POST['titre']]);
        $ok=$req->rowCount();
        if($ok){
            $errors['titre']="Ce titre d'exercice existe déja vous ne pouvez pas l'utiliser";
        }
    }

    //verification de l'ajout de tout les question
    for($i=1;$i<6;$i++){
        if(empty($_POST['q'.$i]) || empty($_POST['c1q'.$i]) || empty($_POST['c1q'.$i]) || empty($_POST['r'.$i])){
            $errors['question']="Verifié que vous avez bien saisi tout les champ des 5 question.";
            break;
        }

        if($_POST['r'.$i]!=1 && $_POST['r'.$i]!=2){
            $errors['reponse']="Vous ne pouvez rentré que le numero du bon choix dans la réponse (1 pour le choix numero1 et 2 pour le choix numero 2)";
            break;
        }
    }

    //aucune erreur ajout du test + question
    if(empty($errors)){
        $req=$bdd->prepare("INSERT INTO test(id_cours,titre) VALUES(?,?)");
        $req->execute([$_POST['cours'],$_POST['titre']]);
        $test_id=$bdd->lastInsertId();
        for($i=1;$i<6;$i++){
            $req=$bdd->prepare("INSERT INTO question(id_test,question,choix1,choix2,answer) VALUES(?,?,?,?,?)");
            $req->execute(array($test_id,$_POST['q'.$i],$_POST['c1q'.$i],$_POST['c2q'.$i],$_POST['r'.$i]));
        }
        $_SESSION['flash']['success']="Votre exercice a été ajouté avec succes";
        header('Location:ajouterexercice.php');
        exit();
    }


}

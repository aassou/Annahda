<?php
    //classes loading begin
    function classLoad ($myClass) {
        if(file_exists('../model/'.$myClass.'.php')){
            include('../model/'.$myClass.'.php');
        }
        elseif(file_exists('../controller/'.$myClass.'.php')){
            include('../controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('../config.php');  
    //classes loading end
    session_start();
    
    //post input processing
    $idProjet = $_POST['idProjet'];
    if( !empty($_POST['nomProjet'])){
        $nomProjet = htmlentities($_POST['nomProjet']);    
        $adresse = htmlentities($_POST['adresse']);
        $superficie = htmlentities($_POST['superficie']);
        $description = htmlentities($_POST['description']);
        $budget = htmlentities($_POST['budget']);
        $description = htmlentities($_POST['description']);
        
        $projet = new Projet(array('id' => $idProjet, 'nom' => $nomProjet, 'adresse' => $adresse,'superficie' => $superficie, 
        'description' => $description, 'budget' => $budget));
        $projetManager = new ProjetManager($pdo);
        $projetManager->update($projet);
        $_SESSION['projet-update-success']="<strong>Opération valide : </strong>Votre projet '".$nomProjet."' est modifié avec succès.";
		$redirectLink = "Location:../projet-update.php?idProjet=".$idProjet;
		if( isset($_GET['p']) and $_GET['p']==99 ){
			$redirectLink = "Location:../projet-search.php?idProjet=".$idProjet;	
		}
        header($redirectLink);
    }
    else{
        $_SESSION['projet-update-error'] = "<strong>Erreur Modification Projet : </strong>Vous devez remplir au moins le champ 'Nom du projet'.";
        $redirectLink = "Location:../projet-update.php?idProjet=".$idProjet;
		if( isset($_GET['p']) and $_GET['p']==99 ){
			$redirectLink = "Location:../projet-search.php?idProjet=".$idProjet;	
		}
        header($redirectLink);
    }
    
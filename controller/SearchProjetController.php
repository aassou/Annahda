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
    if(!empty($_POST['nomProjet'])){
		$recherche = htmlentities($_POST['nomProjet']);
		$projetManager = new ProjetManager($pdo);
		$idProjet = $projetManager->getProjetBySearch($recherche);
		if($idProjet!=0){
			header('Location:../projet-search.php?idProjet='.$idProjet);
			exit;	
		}
		else{
			$_SESSION['projet-search-error'] = 
	        "<strong>Erreur Recherche Projet</strong> : Il n'existe pas un projet avec ce nom.";
			header('Location:../recherches.php#projetTab');	
			exit;
		}
		
    }
    else{
        $_SESSION['projet-search-error'] = 
        "<strong>Erreur Recherche Projet</strong> : Vous devez tapez un Nom de projet.";
		header('Location:../recherches.php#projetTab');
		exit;
    }
    
    
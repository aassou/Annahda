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
    if( !empty($_POST['nomProjet']) ){
    	$nomProjet = htmlentities($_POST['nomProjet']);
    	$projetManager = new ProjetManager($pdo);
    	if($projetManager->exists($nomProjet)>0){
    		$_SESSION['projet-add-error'] = "<strong>Erreur Ajout Projet : </strong>Un projet existe déjà avec ce nom : ".$nomProjet.".";
			header('Location:../projet-add.php');
			exit;			
    	}
		else{    
	        $adresse = htmlentities($_POST['adresse']);
	        $superficie = htmlentities($_POST['superficie']);
	        $budget = htmlentities($_POST['budget']);
	        $description = htmlentities($_POST['description']);
			//create object
	        $projet = new Projet(array('nom' => $nomProjet, 'adresse' => $adresse,'superficie' => $superficie, 
	        'description' =>$description, 'budget' => $budget));
			//add it to db
	        $projetManager->add($projet);
	        $_SESSION['projet-add-success']="<strong>Opération valide : </strong>Le projet '".strtoupper($nomProjet)."' est ajouté avec succès !";	
		}  
    }
    else{
        $_SESSION['projet-add-error'] = "<strong>Erreur Ajout Projet : </strong>Le champ 'Nom du projet' est obligatoire.";
    }
	header('Location:../projet-add.php');
    
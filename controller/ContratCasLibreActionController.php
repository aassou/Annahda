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
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";

    //Component Class Manager

    $contratCasLibreManager = new ContratCasLibreManager($pdo);
	//Action Add Processing Begin
    	if($action == "add"){
        if( !empty($_POST['date']) ){
			$date = htmlentities($_POST['date']);
			$montant = htmlentities($_POST['montant']);
			$observation = htmlentities($_POST['observation']);
			$codeContrat = htmlentities($_POST['codeContrat']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $contratCasLibre = new ContratCasLibre(array(
				'date' => $date,
				'montant' => $montant,
				'observation' => $observation,
				'codeContrat' => $codeContrat,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $contratCasLibreManager->add($contratCasLibre);
            $actionMessage = "Opération Valide : ContratCasLibre Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout contratCasLibre : Vous devez remplir le champ 'date'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idContratCasLibre = htmlentities($_POST['idContratCasLibre']);
        if(!empty($_POST['date'])){
			$date = htmlentities($_POST['date']);
			$montant = htmlentities($_POST['montant']);
			$observation = htmlentities($_POST['observation']);
			$codeContrat = htmlentities($_POST['codeContrat']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            			$contratCasLibre = new ContratCasLibre(array(
				'id' => $idContratCasLibre,
				'date' => $date,
				'montant' => $montant,
				'observation' => $observation,
				'codeContrat' => $codeContrat,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $contratCasLibreManager->update($contratCasLibre);
            $actionMessage = "Opération Valide : ContratCasLibre Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification ContratCasLibre : Vous devez remplir le champ 'date'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idContratCasLibre = htmlentities($_POST['idContratCasLibre']);
        $contratCasLibreManager->delete($idContratCasLibre);
        $actionMessage = "Opération Valide : ContratCasLibre supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['contratCasLibre-action-message'] = $actionMessage;
    $_SESSION['contratCasLibre-type-message'] = $typeMessage;
    header('Location:../file-name-please.php');


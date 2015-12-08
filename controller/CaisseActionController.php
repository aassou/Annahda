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

    $caisseManager = new CaisseManager($pdo);
	//Action Add Processing Begin
    	if($action == "add"){
        if( !empty($_POST['type']) ){
			$type = htmlentities($_POST['type']);
			$dateOperation = htmlentities($_POST['dateOperation']);
			$montant = htmlentities($_POST['montant']);
			$designation = htmlentities($_POST['designation']);
			$destination = htmlentities($_POST['destination']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $caisse = new Caisse(array(
				'type' => $type,
				'dateOperation' => $dateOperation,
				'montant' => $montant,
				'designation' => $designation,
				'destination' => $destination,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $caisseManager->add($caisse);
            $actionMessage = "Opération Valide : Caisse Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout caisse : Vous devez remplir le champ 'type'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idCaisse = htmlentities($_POST['idCaisse']);
        if(!empty($_POST['type'])){
			$type = htmlentities($_POST['type']);
			$dateOperation = htmlentities($_POST['dateOperation']);
			$montant = htmlentities($_POST['montant']);
			$designation = htmlentities($_POST['designation']);
			$destination = htmlentities($_POST['destination']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            			$caisse = new Caisse(array(
				'id' => $idCaisse,
				'type' => $type,
				'dateOperation' => $dateOperation,
				'montant' => $montant,
				'designation' => $designation,
				'destination' => $destination,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $caisseManager->update($caisse);
            $actionMessage = "Opération Valide : Caisse Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Caisse : Vous devez remplir le champ 'type'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idCaisse = htmlentities($_POST['idCaisse']);
        $caisseManager->delete($idCaisse);
        $actionMessage = "Opération Valide : Caisse supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['caisse-action-message'] = $actionMessage;
    $_SESSION['caisse-type-message'] = $typeMessage;
    header('Location:../caisse.php');


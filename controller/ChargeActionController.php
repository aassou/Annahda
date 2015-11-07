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

    $chargeManager = new ChargeManager($pdo);
	//Action Add Processing Begin
	$idProjet = htmlentities($_POST['idProjet']);
    	if($action == "add"){
        if( !empty($_POST['type']) ){
			$type = htmlentities($_POST['type']);
			$dateOperation = htmlentities($_POST['dateOperation']);
			$montant = htmlentities($_POST['montant']);
			$societe = htmlentities($_POST['societe']);
			$designation = htmlentities($_POST['designation']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $charge = new Charge(array(
				'type' => $type,
				'dateOperation' => $dateOperation,
				'montant' => $montant,
				'societe' => $societe,
				'designation' => $designation,
				'idProjet' => $idProjet,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $chargeManager->add($charge);
            $actionMessage = "Opération Valide : Charge Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout charge : Vous devez remplir le champ 'type'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idCharge = htmlentities($_POST['idCharge']);
        if(!empty($_POST['type'])){
			$type = htmlentities($_POST['type']);
			$dateOperation = htmlentities($_POST['dateOperation']);
			$montant = htmlentities($_POST['montant']);
			$societe = htmlentities($_POST['societe']);
			$designation = htmlentities($_POST['designation']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
			$charge = new Charge(array(
				'id' => $idCharge,
				'type' => $type,
				'dateOperation' => $dateOperation,
				'montant' => $montant,
				'societe' => $societe,
				'designation' => $designation,
				'updated' => $updated,
				'updatedBy' => $updatedBy
			));
            $chargeManager->update($charge);
            $actionMessage = "Opération Valide : Charge Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Charge : Vous devez remplir le champ 'type'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idCharge = htmlentities($_POST['idCharge']);
        $chargeManager->delete($idCharge);
        $actionMessage = "Opération Valide : Charge supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['charge-action-message'] = $actionMessage;
    $_SESSION['charge-type-message'] = $typeMessage;
    header('Location:../projet-charges.php?idProjet='.$idProjet);


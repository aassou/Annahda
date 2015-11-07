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

    $CompteBancaireManager = new CompteBancaireManager($pdo);
	//Action Add Processing Begin
    	if($action == "add"){
        if( !empty($_POST['numero']) ){
			$numero = htmlentities($_POST['numero']);
			$dateCreation = htmlentities($_POST['dateCreation']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $CompteBancaire = new CompteBancaire(array(
				'numero' => $numero,
				'dateCreation' => $dateCreation,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $CompteBancaireManager->add($CompteBancaire);
            $actionMessage = "Opération Valide : CompteBancaire Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout CompteBancaire : Vous devez remplir le champ <strong>Numero Compte Bancaire</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idCompteBancaire = htmlentities($_POST['idCompteBancaire']);
        if(!empty($_POST['numero'])){
			$numero = htmlentities($_POST['numero']);
			$dateCreation = htmlentities($_POST['dateCreation']);
			$CompteBancaire = new CompteBancaire(array(
				'id' => $idCompteBancaire,
				'numero' => $numero,
				'dateCreation' => $dateCreation,
			));
            $CompteBancaireManager->update($CompteBancaire);
            $actionMessage = "Opération Valide : CompteBancaire Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification CompteBancaire : Vous devez remplir le champ <strong>Numero Compte Bancaire</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idCompteBancaire = htmlentities($_POST['idCompteBancaire']);
        $CompteBancaireManager->delete($idCompteBancaire);
        $actionMessage = "Opération Valide : CompteBancaire supprimée avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['CompteBancaire-action-message'] = $actionMessage;
    $_SESSION['CompteBancaire-type-message'] = $typeMessage;
    header('Location:../compte-bancaire.php');


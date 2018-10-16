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
    include('../config/config.php');
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";

    //Component Class Manager

    $typeChargeManager = new TypeChargeSyndiqueManager($pdo);
	//Action Add Processing Begin
	$idProjet = htmlentities($_POST['idProjet']);
    if ( $action == "add" ) {
        if( !empty($_POST['nom']) ){
            $nom = htmlentities($_POST['nom']);
            if ( !$typeChargeManager->exists($nom) ){
                $createdBy = $_SESSION['userMerlaTrav']->login();
                $created = date('Y-m-d h:i:s');
                //create object
                $typeCharge = new TypeChargeSyndique(array(
                    'nom' => $nom,
                    'created' => $created,
                    'createdBy' => $createdBy
                ));
                //add it to db
                $typeChargeManager->add($typeCharge);
                $actionMessage = "Opération Valide : Type Charge Ajouté(e) avec succès.";  
                $typeMessage = "success";   
            }
            else{
                $actionMessage = "Erreur Ajout Type Charge : Un type de charge existe déjà avec ce nom <strong>".$nom."</strong>.";
                $typeMessage = "error";
            }
        }
        else{
            $actionMessage = "Erreur Ajout Type Charge : Vous devez remplir le champ <strong>Nom Charge</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idTypeCharge = htmlentities($_POST['idTypeCharge']);
        if(!empty($_POST['nom'])){
			$nom = htmlentities($_POST['nom']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $typeCharge = new TypeChargeSyndique(array(
				'id' => $idTypeCharge,
				'nom' => $nom,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $typeChargeManager->update($typeCharge);
            $actionMessage = "Opération Valide : TypeCharge Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification TypeCharge : Vous devez remplir le champ <strong>Nom Charge</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idTypeCharge = htmlentities($_POST['idTypeCharge']);
        $typeChargeManager->delete($idTypeCharge);
        $actionMessage = "Opération Valide : TypeCharge supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['typeCharge-action-message'] = $actionMessage;
    $_SESSION['typeCharge-type-message'] = $typeMessage;
    $redirectLink = "Location:../view/syndique.php?idProjet=".$idProjet."#sample_1";
    if( isset($_POST['source']) and $_POST['source'] == "type-charges" ) {
        $redirectLink = "Location:../view/type-charges-syndique.php";
    }
    header($redirectLink);
    
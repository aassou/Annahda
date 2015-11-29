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
    //link redirection
    $redirectLink = "";
    //Component Class Manager

    $reglementPrevuManager = new ReglementPrevuManager($pdo);
	//Action Add Processing Begin
    	if($action == "add"){
        if( !empty($_POST['datePrevu']) ){
			$datePrevu = htmlentities($_POST['datePrevu']);
			$codeContrat = htmlentities($_POST['codeContrat']);
			$status = htmlentities($_POST['status']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $reglementPrevu = new ReglementPrevu(array(
				'datePrevu' => $datePrevu,
				'codeContrat' => $codeContrat,
				'status' => $status,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $reglementPrevuManager->add($reglementPrevu);
            $actionMessage = "Opération Valide : ReglementPrevu Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout reglementPrevu : Vous devez remplir le champ 'datePrevu'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idReglementPrevu = htmlentities($_POST['idReglementPrevu']);
        if(!empty($_POST['datePrevu'])){
			$datePrevu = htmlentities($_POST['datePrevu']);
			$codeContrat = htmlentities($_POST['codeContrat']);
			$status = htmlentities($_POST['status']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            			$reglementPrevu = new ReglementPrevu(array(
				'id' => $idReglementPrevu,
				'datePrevu' => $datePrevu,
				'codeContrat' => $codeContrat,
				'status' => $status,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $reglementPrevuManager->update($reglementPrevu);
            $actionMessage = "Opération Valide : ReglementPrevu Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification ReglementPrevu : Vous devez remplir le champ 'datePrevu'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action UpdateStatus Processing Begin
    else if ($action == "updateStatus"){
        $idReglementPrevu = htmlentities($_POST['idReglementPrevu']);
        $status = htmlentities($_POST['status']);
        $reglementPrevuManager->updateStatus($idReglementPrevu, $status);
        $codeContrat = htmlentities($_POST['codeContrat']);
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat.'&idProjet='.$idProjet.'#reglementsPrevus';
    }
    //Action UpdateStatus Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idReglementPrevu = htmlentities($_POST['idReglementPrevu']);
        $reglementPrevuManager->delete($idReglementPrevu);
        $actionMessage = "Opération Valide : ReglementPrevu supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['reglementPrevu-action-message'] = $actionMessage;
    $_SESSION['reglementPrevu-type-message'] = $typeMessage;
    header($redirectLink);


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
    
    //Redirection link
    $redirectLink = "";
    //Component Class Manager
    $contratCasLibreManager = new ContratCasLibreManager($pdo);
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
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
            //add history data to db
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des cas libres (contratcaslibre)",
                'description' => "Ajouter la liste des cas libres au contrat",
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
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
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
			$contratCasLibre = new ContratCasLibre(array(
	            'id' => $idContratCasLibre,
	            'date' => $date,
	            'montant' => $montant,
	            'observation' => $observation,
	            'updated' => $updated,
	            'updatedBy' => $updatedBy
			));
            $contratCasLibreManager->update($contratCasLibre);
            //add history data to db
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des cas libres (contratcaslibre)",
                'description' => "Modifier un cas libre contrat",
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "Opération Valide : ContratCasLibre Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification ContratCasLibre : Vous devez remplir le champ 'date'.";
            $typeMessage = "error";
        }
        $codeContrat = htmlentities($_POST['codeContrat']);
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat.'&idProjet='.$idProjet.'#contratCasLibre';
    }
    //Action Update Processing End
    //Action UpdateStatus Processing Begin
    else if ($action == "updateStatus"){
        $idContratCasLibre = htmlentities($_POST['idContratCasLibre']);
        $status = htmlentities($_POST['status']);
        $contratCasLibreManager->updateStatus($idContratCasLibre, $status);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Modification Status",
            'target' => "Table des cas libres (contratcaslibre)",
            'description' => "Modifier le status d'un cas libre contrat",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $codeContrat = htmlentities($_POST['codeContrat']);
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat.'&idProjet='.$idProjet.'#contratCasLibre';
    }
    //Action UpdateStatus Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idContratCasLibre = htmlentities($_POST['idContratCasLibre']);
        $contratCasLibreManager->delete($idContratCasLibre);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des cas libres (contratcaslibre)",
            'description' => "Supprimer un cas libre contrat",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "Opération Valide : ContratCasLibre supprimé(e) avec succès.";
        $typeMessage = "success";
        $codeContrat = htmlentities($_POST['codeContrat']);
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat.'&idProjet='.$idProjet.'#contratCasLibre';
    }
    //Action Delete Processing End
    $_SESSION['contratCasLibre-action-message'] = $actionMessage;
    $_SESSION['contratCasLibre-type-message'] = $typeMessage;
    header($redirectLink);


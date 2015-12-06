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
    //In this session variable we put all the POST, to get it in the contrats-add file
    //in case of error, and this help the user to do not put again what he filled out.
    $_SESSION['operation-data-form'] = $_POST;
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //process begins
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
    $operationManager = new OperationManager($pdo);
    if( $action == "add" ) {
        if( !empty($_POST['montant']) and !empty($_POST['numeroOperation']) ) {
            $montant = htmlentities($_POST['montant']);
            $modePaiement = htmlentities($_POST['modePaiement']);
            $numeroOperation = htmlentities($_POST['numeroOperation']);
            $dateOperation = htmlentities($_POST['dateOperation']);
            $dateReglement = htmlentities($_POST['dateReglement']);
            $compteBancaire = htmlentities($_POST['compteBancaire']);
            $observation = htmlentities($_POST['observation']);
            $idContrat = htmlentities($_POST['idContrat']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $operation = 
            new Operation(array('date' => $dateOperation, 'dateReglement' => $dateReglement, 
            'montant' => $montant, 'compteBancaire' => $compteBancaire, 'observation' => $observation, 
            'modePaiement'=>$modePaiement, 'idContrat' => $idContrat, 'numeroCheque' => $numeroOperation,   
            'createdBy' => $createdBy, 'created' => $created));
            $operationManager->add($operation);
            //add History data
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des paiements clients ",
                'description' => "Ajouter un paiement client",
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Réglement Ajouté avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Réglement Client</strong> : Vous devez remplir les champs <strong>Montant</strong> et <strong>Numéro Opération</strong>.";
            $typeMessage = "error";
        }
    }
    else if($action == "update"){
        if( !empty($_POST['montant']) and !empty($_POST['numeroOperation']) ) {
            $idOperation = htmlentities($_POST['idOperation']);
            $dateOperation = htmlentities($_POST['dateOperation']);
            $dateReglement = htmlentities($_POST['dateReglement']);
            $compteBancaire = htmlentities($_POST['compteBancaire']);
            $observation = htmlentities($_POST['observation']);
            $montant = htmlentities($_POST['montant']);
            $modePaiement = htmlentities($_POST['modePaiement']);
            $numeroOperation = htmlentities($_POST['numeroOperation']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $operation = 
            new Operation(array('id' => $idOperation, 'date' => $dateOperation,
            'dateReglement' => $dateReglement, 'compteBancaire' => $compteBancaire, 
            'observation' => $observation, 'montant' => $montant, 'numeroCheque' => $numeroOperation, 
            'modePaiement' => $modePaiement, 'updatedBy' => $updatedBy, 'updated' => $updated));
            $operationManager->update($operation);
            //add History data
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des paiements clients",
                'description' => "Modifier un paiement client",
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Réglement Client Modifié avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Réglement Client</strong> : Vous devez remplir les champs <strong>Montant</strong> et <strong>Numéro Opération</strong>.";
            $typeMessage = "error";
        }
    }
    else if($action=="delete"){
        $idOperation = $_POST['idOperation'];
        $operationManager->delete($idOperation);
        //add History data
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des paiements clients",
            'description' => "Supprimmer un paiement client",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $actionMessage = "<strong>Opération Valide</strong> : Réglement Client Supprimé avec succès.";
        $typeMessage = "success";
    }
    
    //define the redirection url based on the source page
    if ( isset($_POST['source']) and $_POST['source'] == "contrat" ) {
        $codeContrat = htmlentities($_POST['codeContrat']);
        $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat."#detailsReglements";   
    }
    else if ( isset($_POST['source']) and $_POST['source'] == "contrats-list" ) {
        $idProjet = htmlentities($_POST['idProjet']);
        $redirectLink = "Location:../contrats-list.php?idProjet=".$idProjet;
    }
    else if ( isset($_POST['source']) and $_POST['source'] == "clients-search" ) {
    	$redirectLink = "Location:../clients-search.php";
    }
    $_SESSION['operation-action-message'] = $actionMessage;
    $_SESSION['operation-type-message'] = $typeMessage;
    header($redirectLink);
    
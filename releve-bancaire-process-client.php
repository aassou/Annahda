<?php
require('config.php');
require('model/ReleveBancaireManager.php');
require('model/OperationManager.php');
require('model/Operation.php');
session_start();
$releveBancaireManager = new ReleveBancaireManager($pdo);
$_SESSION['testajax'] = $_POST;
$idReleveBancaire = $_POST['idReleveBancaire'];
//This variable projetContrat defines the actions choosed by the user : Ignorer || a Project
$projetContrat = htmlentities($_POST['projet-contrat']);
$montant = htmlentities($_POST['montant']);
$dateOperation = htmlentities($_POST['dateOperation']);
$dateReglement = htmlentities($_POST['dateReglement']);
$dateOperation = DateTime::createFromFormat('d/m/Y', trim($dateOperation));
$dateReglement = DateTime::createFromFormat('d/m/Y', trim($dateReglement));
$dateOperation = $dateOperation->format('Y-m-d'); 
$dateReglement = $dateReglement->format('Y-m-d'); 
//$designation = htmlentities($_POST['designation']);
//var_dump($_POST);
if ( $projetContrat == "Ignorer" ) {
    $releveBancaireManager->delete($idReleveBancaire);
    $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire traité avec succès.";
    $typeMessage = "success";
}
else{
    $operationManager = new OperationManager($pdo);
    //$reference = 'Q'.date('Ymd-his');
    $reference = htmlentities($_POST['reference']);
    $modePaiement = htmlentities($_POST['mode-paiement']);
    $numeroOperation = htmlentities($_POST['reference']);
    $compteBancaire = htmlentities($_POST['compte-bancaire']);
    $status = 1;
    //$observation ="Ce réglement client fait référence à la ligne : ".$idReleveBancaire." du relevé bancaire du compte bancaire : ".$compteBancaire;
    $observation = htmlentities($_POST['observation']);
    $idContrat = htmlentities($_POST['contrat-client']);
    $updatedBy = "admin";
    $updated = date('Y-m-d h:i:s');
    //echo $_POST['idOperation'];
    if ( !empty($_POST['operationValue']) ) {
        $idOperation = htmlentities($_POST['operationValue']);
        $operation = 
        new Operation(array('id' => $idOperation, 'date' => $dateOperation, 'dateReglement' => $dateReglement, 
        'status' => $status, 'montant' => $montant, 'compteBancaire' => $compteBancaire, 
        'observation' => $observation, 'reference' => $reference, 'modePaiement'=>$modePaiement, 
        'numeroCheque' => $numeroOperation, 'updatedBy' => $updatedBy, 'updated' => $updated));
        //print_r($operation);
        //$operationManager->add($operation);
        $operationManager->updateByReleveActionController($operation);
        $releveBancaireManager->hide($idReleveBancaire);
        $actionMessage = "<strong>Opération Valide</strong> : Relevé Bancaire traité avec succès.";
        $typeMessage = "success";
        echo "Opération Valide";
    }
    else {
        $actionMessage = "<strong>Erreur Opération</strong> : Vous devez choisir l'opération à mettre à jours.";
        $typeMessage = "error";
        echo "Opération echouée";
    }
}

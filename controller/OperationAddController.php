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
    $idContrat = htmlentities($_POST['idContrat']);
	$idProjet = htmlentities($_POST['idProjet']);
    if( !empty($_POST['dateOperation']) && !empty($_POST['montant']) ){    
        $dateOperation = htmlentities($_POST['dateOperation']);    
        $montant = htmlentities($_POST['montant']);
		$modePaiement = htmlentities($_POST['modePaiement']);
		$numeroCheque = 0;
		if( isset($_POST['numeroCheque']) ){
			$numeroCheque = htmlentities($_POST['numeroCheque']);
		}
        //create a new Operation object
        $operation = new Operation(array('date' => $dateOperation, 'montant' => $montant,
        'modePaiement'=>$modePaiement, 'idContrat' => $idContrat, 'numeroCheque' => $numeroCheque));
        $operationManager = new OperationManager($pdo);
        $operationManager->add($operation);
        $_SESSION['operation-add-success']="<strong>Opération valide</strong> : L'opération de paiement est ajoutée avec succès.";
		$_SESSION['print-quittance'] = "print-quittance";
		$redirectLink = 'Location:../operations.php?idContrat='.$idContrat.'&idProjet='.$idProjet;
		if( isset($_GET['p']) and $_GET['p']==99 ){
			$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet;
		}
		else if( isset($_GET['p']) and $_GET['p']==999 ){
			$redirectLink = 'Location:../clients-search.php';
		}
        header($redirectLink);
    }
    else{
        $_SESSION['operation-add-error'] = "<strong>Erreur ajout opération</strong> : Vous devez remplir les champs 'Date opération' et 'Montant'.";
        $redirectLink = 'Location:../operations.php?idContrat='.$idContrat.'&idProjet='.$idProjet;
		if( isset($_GET['p']) and $_GET['p']==99 ){
			$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet;
		}
		if( isset($_GET['p']) and $_GET['p']==999 ){
			$redirectLink = 'Location:../clients-search.php';
		}
        header($redirectLink);
    }
    
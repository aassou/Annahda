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
	$idProjet = htmlentities($_POST['idProjet']);
	$idFournisseur = htmlentities($_POST['idFournisseur']);
    if( !empty($_POST['montant']) && !empty($_POST['idFournisseur']) ){    
        $dateReglement = htmlentities($_POST['dateReglement']);    
        $montant = htmlentities($_POST['montant']);
		$modePaiement = htmlentities($_POST['modePaiement']);
		$numeroCheque = 0;
		if( isset($_POST['numeroCheque']) ){
			$numeroCheque = $_POST['numeroCheque'];
		}
        //create a new Operation object
        $reglementFournisseur = new ReglementFournisseur(array('dateReglement' => $dateReglement, 
        'montant' => $montant,'idProjet' => $idProjet, 'idFournisseur' => $idFournisseur, 
        'modePaiement' => $modePaiement, 'numeroCheque' => $numeroCheque));
        $reglementFournisseurManager = new ReglementFournisseurManager($pdo);
        $reglementFournisseurManager->add($reglementFournisseur);
        $_SESSION['reglement-add-success']="<strong>Opération valide</strong> : Le réglement du fournisseur est réalisé avec succès.";
		$redirectLink = 'Location:../fournisseurs-reglements.php?idFournisseur='.$idFournisseur;
		if( isset($_GET['p']) and $_GET['p']==99 ){
			$redirectLink = 'Location:../livraisons.php';
		} 
        header($redirectLink);
    }
    else{
        $_SESSION['reglement-add-error'] = "<strong>Erreur Ajout Réglement Fournisseur</strong> : Vous devez remplir le champ 'Montant'.";
        $redirectLink = 'Location:../fournisseurs-reglements.php?idFournisseur='.$idFournisseur;
		if( isset($_GET['p']) and $_GET['p']==99 ){
			$redirectLink = 'Location:../livraisons.php';
		} 
        header($redirectLink);
    }
    
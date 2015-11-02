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
	$idFournisseur = $_POST['idFournisseur'];
    if( !empty($_POST['montant']) ){
        $idReglement = htmlentities($_POST['idReglement']);
        $dateReglement = htmlentities($_POST['dateReglement']);    
        $montant = htmlentities($_POST['montant']);
		$idProjet = $_POST['idProjet'];
		$modePaiement = $_POST['modePaiement'];
		$numeroCheque = "0";
		if(isset($_POST['numeroCheque'])){
			$numeroCheque = $_POST['numeroCheque'];
		}
        //create a new Operation object
        $reglementFournisseur = new ReglementFournisseur(array('dateReglement' => $dateReglement, 
        'montant' => $montant, 'idProjet'=> $idProjet, 'modePaiement' => $modePaiement
        , 'numeroCheque' => $numeroCheque,'id' => $idReglement));
        $reglementFournisseurManager = new ReglementFournisseurManager($pdo);
        $reglementFournisseurManager->update($reglementFournisseur);
        $_SESSION['reglement-update-success']="<strong>Opération valide</strong> : Le réglement du fournisseur est modifié avec succès.";
        header('Location:../fournisseurs-reglements.php?idFournisseur='.$idFournisseur.'#listFournisseurs');
    }
    else{
        $_SESSION['reglement-update-error'] = "<strong>Erreur Modification Réglement Fournisseur</strong> : Vous devez remplir les champs 'Date réglement' et 'Montant'.";
        header('Location:../fournisseurs-reglements.php?idFournisseur='.$idFournisseur.'#listFournisseurs');
    }
    
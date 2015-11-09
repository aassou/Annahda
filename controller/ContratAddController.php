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
    $message = "";
    $messageType = "";
    $idProjet = $_POST['idProjet'];
	$codeClient = $_POST['codeClient'];
    if( !empty($_POST['idProjet']) and !empty($_POST['codeClient'])){	
    	if( !empty($_POST['typeBien']) ){
    		if( !empty($_POST['prixNegocie']) ){
    			$prixNegocie = htmlentities($_POST['prixNegocie']);
    		}
			else{
			    $message = "<strong>Erreur Création Contrat : </strong>Vous devez remplir le <strong>&lt;Prix négocié&gt;</strong>.";
			    $_SESSION['contrat-add-error'] = $message;	
			    header('Location:../contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient);
		        exit;
			}
			$numero = htmlentities($_POST['numero']);
    		$typeBien = htmlentities($_POST['typeBien']);
			$dateCreation = htmlentities($_POST['dateCreation']);
			$idBien = htmlentities($_POST['bien']);
			$avance = htmlentities($_POST['avance']);
			$modePaiement = htmlentities($_POST['modePaiement']);
			$dureePaiement = htmlentities($_POST['dureePaiement']);
			$nombreMois = htmlentities($_POST['nombreMois']);
			$echeance = htmlentities($_POST['echeance']);
			$note = htmlentities($_POST['note']);
			$idClient = htmlentities($_POST['idClient']);
			$codeContrat = uniqid().date('YmdHis');
            $created = date('Y-m-d h:i:s');
            $createdBy = $_SESSION['userMerlaTrav']->login();
			$numeroCheque = '0';
			if( isset($_POST['numeroCheque']) ){
				$numeroCheque = htmlentities($_POST['numeroCheque']);
			}
			$contratManager = new ContratManager($pdo);
			$contrat = 
			new Contrat(array('numero' => $numero, 'dateCreation' => $dateCreation, 'prixVente' => $prixNegocie, 
			'avance' => $avance, 'modePaiement' => $modePaiement, 'dureePaiement' => $dureePaiement, 
			'nombreMois' => $nombreMois, 'echeance' => $echeance, 'note' => $note, 'idClient' => $idClient, 
			'idProjet' => $idProjet, 'idBien' => $idBien, 'typeBien' => $typeBien, 'code' => $codeContrat, 
			'numeroCheque' => $numeroCheque, 'created' => $created, 'createdBy' => $createdBy));
			$contratManager->add($contrat);
			if($typeBien=="appartement"){
				$appartementManager = new AppartementManager($pdo);
				$appartementManager->changeStatus($idBien, "Vendu");
			}
			else if($typeBien=="localCommercial"){
				$locauxManager = new LocauxManager($pdo);
				$locauxManager->changeStatus($idBien, "Vendu");
			}
			//add note client into db and show it in the dashboard
			$notesClientManager = new NotesClientManager($pdo);
			$notesClient = new NotesClient(array('note' => $note, 'created' => date('Y-m-d'), 
			'idProjet' => $idProjet, 'codeContrat' => $codeContrat));
			$notesClientManager->add($notesClient);
			header('Location:../contrat.php?codeContrat='.$codeContrat);
    	}
		else{
			$_SESSION['contrat-add-error'] = "<strong>Erreur Création Contrat : </strong>Vous devez choisir un 'Type de bien'.";	
			header('Location:../contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient);
			exit;
		}
    }
    else{
        $_SESSION['contrat-add-error'] = "<strong>Erreur Création Contrat : </strong>Vous devez remplir le champ <strong>Nom</strong>.";
		header('Location:../contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient);
    }
	
    
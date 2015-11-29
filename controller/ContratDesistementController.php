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
    $idProjet = $_POST['idProjet'];
	$idContrat  = $_POST['idContrat'];
	//create classes managers
	$locauxManager = new LocauxManager($pdo);
	$contratManager = new ContratManager($pdo);
	$appartementManager = new AppartementManager($pdo);
	//create classes
	$contrat = $contratManager->getContratById($idContrat);
	//change status of the old contrat Bien from reservé to non reservé
	if( $contrat->typeBien()=="appartement" ){
		$appartementManager->changeStatus($contrat->idBien(), "Disponible");
	}
	else if( $contrat->typeBien()=="localCommercial" ){
		$locauxManager->changeStatus($contrat->idBien(), "Disponible");
	}
	$contratManager->desisterContrat($idContrat);
	$_SESSION['contrat-desister-success'] = "<strong>Opération valide : </strong>Le contrat est désisté avec succès.";
	$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet;
	if(isset($_GET['p']) and $_GET['p']==99 ){
		$redirectLink = 'Location:../clients-search.php';
	}
	header($redirectLink);
	

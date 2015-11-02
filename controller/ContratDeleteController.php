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
	$idContrat = $_POST['idContrat'];   
    $contratManager = new ContratManager($pdo);
	$contrat = $contratManager->getContratById($idContrat);
	$contratManager->delete($idContrat);
	if($contrat->typeBien()=="appartement"){
		$appartementManager = new AppartementManager($pdo);
		$appartementManager->changeStatus($contrat->idBien(), "Non");
	}
	else if($contrat->typeBien()=="localCommercial"){
		$locauxManager = new LocauxManager($pdo);
		$locauxManager->changeStatus($contrat->idBien(), "Non");
	}
	$_SESSION['contrat-delete-success'] = "<strong>Opération valide : </strong>Contrat supprimé avec succès.";
	$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet;
	if(isset($_GET['p']) and $_GET['p']==99){
		$redirectLink = 'Location:../clients-search.php';	
	}
	header($redirectLink);
    
    
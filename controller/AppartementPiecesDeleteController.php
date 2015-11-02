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
	$idAppartement = $_POST['idAppartement'];
	$idPieceAppartement = $_POST['idPieceAppartement'];   
    $piecesAppartementManager = new PiecesAppartementManager($pdo);
	$piecesAppartementManager->delete($idPieceAppartement);
	//delete file from the disk
	$_SESSION['pieces-delete-success'] = "<strong>Opération valide : </strong>Pièce supprimé avec succès.";
	$redirect = 'Location:../pieces-appartement.php?idProjet='.$idProjet.'&idAppartement='.$idAppartement;
	if($_GET['p']==2){
		$redirect = 'Location:../appartement-detail.php?idAppartement='.$idAppartement.'&idProjet='.$idProjet;	
	}
	header($redirect);
    
    
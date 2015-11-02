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
	$redirect = 'Location:../appartements.php?idProjet='.$idProjet;
	if($_GET['p']==2){
		$redirect = 'Location:../appartement-detail.php?idAppartement='.$idAppartement.'&idProjet='.$idProjet;	
	}
    if( !empty($_POST['code'])){
        $code = htmlentities($_POST['code']);    
        $facade = htmlentities($_POST['facade']);
        $superficie = htmlentities($_POST['superficie']);
        $prix = 0.0;
		$niveau = htmlentities($_POST['niveau']);
		$nombrePiece = htmlentities($_POST['nombrePiece']);
		$status = htmlentities($_POST['status']);
		$cave = htmlentities($_POST['cave']);
		$par = "";
		if( isset($_POST['par']) ){
			$par = $_POST['par'];
		}
        /*if(filter_var($_POST['superficie'], FILTER_VALIDATE_FLOAT)==true){
            $superficie = floatval(htmlentities($_POST['superficie']));
        }
        else {
            $_SESSION['appartement-update-error']="<strong>Erreur Modification Appartement</strong> : La valeur du champ 'Superficie' est incorrecte !";
            header('Location:../appartements.php?idProjet='.$idProjet);
            exit;
        }*/
        if(filter_var($_POST['prix'], FILTER_VALIDATE_FLOAT)==true){
            $prix = floatval(htmlentities($_POST['prix']));
        }
        else {
            $_SESSION['appartement-update-error']="<strong>Erreur Modification Appartement</strong> : La valeur du champ 'Prix' est incorrecte !";
            header($redirect);
            exit;
        }
        
        $appartement = new Appartement(array('id' => $idAppartement, 'nom' => $code, 'prix' => $prix,
        'superficie' => $superficie, 'facade' =>$facade, 'status' => $status, 'cave' => $cave, 
        'niveau' => $niveau, 'nombrePiece' => $nombrePiece, 'par' => $par));
        $appartementManager = new AppartementManager($pdo);
        $appartementManager->update($appartement);
        $_SESSION['appartement-update-success']="<strong>Opération valide : </strong>L' Appartement est modifié avec succès !";
    }
    else{
        $_SESSION['appartement-update-error'] = "<strong>Erreur Modification Appartement : </strong>Vous devez remplir au moins le champ 'Code'.";
    }
	header($redirect);
    
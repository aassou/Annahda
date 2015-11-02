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
    $appartementManager = new AppartementManager($pdo);
	$appartementManager->delete($idAppartement);
	$_SESSION['appartement-delete-success'] = "<strong>Opération valide : </strong>Appartement supprimé avec succès.";
	header('Location:../appartements.php?idProjet='.$idProjet);
    
    
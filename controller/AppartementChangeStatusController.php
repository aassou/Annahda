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
	$status = $_POST['status'];
	$appartementManager = new AppartementManager($pdo);
    $appartementManager->changeStatus($idAppartement, $status);
    $_SESSION['appartement-changed-status'] = "<strong>Opération valide : </strong>Status de l'appartement est changé avec succès !";
	header('Location:../appartements.php?idProjet='.$idProjet);
    
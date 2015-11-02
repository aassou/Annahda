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
	$idOperation = $_POST['idOperation'];
    $operationManager = new OperationManager($pdo);
	$operationManager->delete($idOperation);
	$_SESSION['operation-delete-success'] = "<strong>Opération valide : </strong>Opération supprimée avec succès.";
	header('Location:../operations.php?idContrat='.$idContrat.'&idProjet='.$idProjet);
    
    
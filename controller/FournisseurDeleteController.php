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
    $fournisseurManager = new FournisseurManager($pdo);
	$fournisseurManager->delete($idFournisseur);
	$_SESSION['fournisseur-delete-success'] = "<strong>Opération valide : </strong>Fournisseur supprimé avec succès.";
	header('Location:../fournisseurs.php#listFournisseurs');
    
    
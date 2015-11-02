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
	$idEntree = $_POST['idEntree'];
    $caisseEntreesManager = new CaisseEntreesManager($pdo);
	$caisseEntreesManager->delete($idEntree);
	$_SESSION['entrees-delete-success'] = "<strong>Opération valide : </strong>Entrée de caisse supprimée avec succès.";
	header('Location:../caisse-entrees.php');
    
    
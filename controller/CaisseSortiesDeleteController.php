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
	$idSortie = $_POST['idSortie'];
    $caisseSortiesManager = new CaisseSortiesManager($pdo);
	$caisseSortiesManager->delete($idSortie);
	$_SESSION['sorties-delete-success'] = "<strong>Opération valide : </strong>Sortie de caisse supprimée avec succès.";
	header('Location:../caisse-sorties.php');
    
    
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
	$codeLivraison = $_POST['codeLivraison'];
	$id = $_POST['idLivraisonDetail'];   
    $livraisonDetailManager = new LivraisonDetailManager($pdo);
	$livraisonDetailManager->delete($id);
	$_SESSION['livraison-detail-delete-success'] = "<strong>Opération valide : </strong>Article supprimé avec succès.";
	$redirectLink = 'Location:../livraisons-details.php?codeLivraison='.$codeLivraison;
	header($redirectLink);
    
    
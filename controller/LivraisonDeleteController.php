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
	$idLivraison = $_POST['idLivraison'];   
    $livraisonManager = new LivraisonManager($pdo);
	$livraisonManager->delete($idLivraison);
	$_SESSION['livraison-delete-success'] = "<strong>Opération valide : </strong>Livraison supprimée avec succès.";
	$redirectLink = 'Location:../livraisons-list.php?idProjet='.$idProjet;
	if( isset($_GET['p']) and $_GET['p']==1 ){
		$redirectLink = 'Location:../livraisons.php';
	} 
	header($redirectLink);
    
    
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
	$idFournisseur = "";
	$idProjet = "";
	$p = "";
	$params = "";
    if(isset($_GET['idFournisseur']) and isset($_GET['idProjet']) and isset($_GET['p'])){
    	$params = "?idFournisseur=".$_GET['idFournisseur']."&idProjet=".$_GET['idProjet']."&p=".$_GET['p'];
    }
	else if( isset($_GET['idFournisseur']) and isset($_GET['p']) ){
		$params = "?idFournisseur=".$_GET['idFournisseur']."&p=".$_GET['p'];
	}
	else if(isset($_GET['p'])){
		$params = "?p=".$_GET['p'];
	}
    //post input processing
	$idProjet = $_POST['idProjet'];
	$idLivraison = $_POST['idLivraison'];   
    $livraisonManager = new LivraisonManager($pdo);
	$livraisonDetailManager = new LivraisonDetailManager($pdo);
	foreach($_POST['deleteFournisseurList'] as $livraison){
		$livraisonDetailManager->deleteLivraison($livraison);
		$livraisonManager->delete($livraison);	
	}
	$_SESSION['livraison-list-delete-success'] = "<strong>Opération valide : </strong>Liste des Livraisons supprimée avec succès.";
	$redirectLink = 'Location:../livraisons2'.$params;
	header($redirectLink);
    
    
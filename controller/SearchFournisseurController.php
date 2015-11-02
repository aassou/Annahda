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
    if(!empty($_POST['searchFournisseur'])){
		$recherche = htmlentities($_POST['searchFournisseur']);
		$fournisseurManager = new FournisseurManager($pdo);
		$_SESSION['searchFournisseurResult'] = $fournisseurManager->getFournisseurBySearch($recherche);
		header('Location:../fournisseurs-search.php');
    }
    else{
        $_SESSION['fournisseur-search-error'] = 
        "<strong>Erreur Recherche Fournisseur</strong> : Vous devez tapez un Nom de fournisseur.";
		header('Location:../fournisseurs-search.php');
    }
    
    
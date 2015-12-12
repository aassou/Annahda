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
    if( !empty($_POST['montant'])){
        $montant = htmlentities($_POST['montant']);    
        $designation = htmlentities($_POST['designation']);
		$destination = htmlentities($_POST['destination']);
		$dateOperation = htmlentities($_POST['dateOperation']);
		$utilisateur = htmlentities($_POST['utilisateur']);
        
        $caisseSorties = new CaisseSorties(array('montant' => $montant, 'designation' => $designation,
        'dateOperation' => $dateOperation, 'destination' => $destination,'utilisateur' => $utilisateur));
        $caisseSortiesManager = new CaisseSortiesManager($pdo);
        $caisseSortiesManager->add($caisseSorties);
        $_SESSION['sorties-add-success']="<strong>Opération valide : </strong>Le montant est tiré de la caisse avec succès.";
    }
    else{
        $_SESSION['sorties-add-error'] = "<strong>Erreur Ajout Sorties : </strong>Vous devez remplir au moins le champ 'Montant'.";
    }
	header('Location:../caisse.php');
    
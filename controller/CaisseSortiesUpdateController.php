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
    if( !empty($_POST['montant'])){
        $montant = htmlentities($_POST['montant']);    
        $designation = htmlentities($_POST['designation']);
		$destination = htmlentities($_POST['destination']);
		$dateOperation = htmlentities($_POST['dateOperation']);
		$utilisateur = htmlentities($_POST['user']);
        
        $caisseSorties = new CaisseSorties(array('id' => $idSortie, 'montant' => $montant, 'designation' => $designation,
        'destination' => $destination, 'dateOperation' => $dateOperation, 'utilisateur' =>$utilisateur));
        $caisseSortiesManager = new CaisseSortiesManager($pdo);
        $caisseSortiesManager->update($caisseSorties);
        $_SESSION['sorties-update-success']="<strong>Opération valide : </strong>La sortie est modifiée avec succès.";
    }
    else{
        $_SESSION['sorties-update-error'] = "<strong>Erreur Modification Sorties : </strong>Vous devez remplir au moins le champ 'Montant'.";
    }
	header('Location:../caisse-sorties.php');
    
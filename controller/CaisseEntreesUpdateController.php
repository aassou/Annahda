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
    if( !empty($_POST['montant'])){
        $montant = htmlentities($_POST['montant']);    
        $designation = htmlentities($_POST['designation']);
		$dateOperation = htmlentities($_POST['dateOperation']);
		$utilisateur = htmlentities($_POST['user']);
        
        $caisseEntrees = new CaisseEntrees(array('id' => $idEntree, 'montant' => $montant, 'designation' => $designation,
        'dateOperation' => $dateOperation, 'utilisateur' =>$utilisateur));
        $caisseEntreesManager = new CaisseEntreesManager($pdo);
        $caisseEntreesManager->update($caisseEntrees);
        $_SESSION['entrees-update-success']="<strong>Opération valide : </strong>L'entrée est modifiée avec succès.";
    }
    else{
        $_SESSION['entrees-update-error'] = "<strong>Erreur Modification Entrées : </strong>Vous devez remplir au moins le champ 'Montant'.";
    }
	header('Location:../caisse-entrees.php');
    
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
		$dateOperation = htmlentities($_POST['dateOperation']);
		$utilisateur = htmlentities($_POST['utilisateur']);
        
        $caisseEntrees = new CaisseEntrees(array('montant' => $montant, 'designation' => $designation,
        'dateOperation' => $dateOperation, 'utilisateur' =>$utilisateur));
        $caisseEntreesManager = new CaisseEntreesManager($pdo);
        $caisseEntreesManager->add($caisseEntrees);
        $_SESSION['entrees-add-success']="<strong>Opération valide : </strong>Le montant est ajouté à la caisse avec succès.";
    }
    else{
        $_SESSION['entrees-add-error'] = "<strong>Erreur Ajout Entrées : </strong>Vous devez remplir au moins le champ 'Montant'.";
    }
	header('Location:../caisse.php');
    
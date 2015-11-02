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
    $idContrat = $_POST['id_contrat'];
    if( !empty($_POST['dateCreation']) && !empty($_POST['prixVente']) && !empty($_POST['avance']) ){
        $dateCreation = htmlentities($_POST['dateCreation']);    
        $prixVente = htmlentities($_POST['prixVente']);
        $avance = htmlentities($_POST['avance']);
        $dateEcheance = htmlentities($_POST['dateEcheance']);
        $nb = htmlentities($_POST['nb']);
        //update a Contract object
        $contract = new Contrat(array('id' => $idContrat, 'dateCreation' => $dateCreation, 
        'prixVente' => $prixVente, 'avance' => $avance, 'dateEcheanceMois' => $dateEcheance, 'nb' => $nb ));
        $contratsManager = new ContratManager($pdo);
        $contratsManager->update($contract);
        $_SESSION['success']['contract-update']='Les données du contrat sont modifié avec succès !';
        $contrat = $contratsManager->getContratById($idContrat);
        header('Location:../contract-list.php?id='.$contrat->idClient());
    }
    else{
        $_SESSION['error']['contract-update'] = "Vous devez remplir au moins les champs 'Date du contrat', 'Avance' et 'Prix de vente' !";
        header('Location:../update-contract.php?id='.$idContrat);
    }
    
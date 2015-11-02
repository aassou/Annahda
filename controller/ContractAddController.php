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
    $idClient = htmlentities($_POST['client']);
    if( !empty($_POST['projet']) && !empty($_POST['bien']) && !empty($_POST['nom']) ){    
        $nom = htmlentities($_POST['nom']);    
        $projet = htmlentities($_POST['projet']);
        $bien = htmlentities($_POST['bien']);
        $dateCreation = htmlentities($_POST['dateCreation']);
        $prixVente = htmlentities($_POST['prixVente']);
        $avance = htmlentities($_POST['avance']);
        $dateEcheance = htmlentities($_POST['dateEcheance']);
        $nb = htmlentities($_POST['nb']);
        $idClient = htmlentities($_POST['client']);
        //create a new Client object
        $contrat = new Contrat(array('dateCreation' => $dateCreation, 'prixVente' => $prixVente, 'avance' => $avance,'dateEcheanceMois' => $dateEcheance, 
        'nb' => $nb , 'idClient' =>$idClient, 'idProjet' => $projet, 'idBien' => $bien));
        $contratManager = new ContratManager($pdo);
        $contratManager->add($contrat);
        //update property state (reserve=yes)
        $bienManager = new BienManager($pdo);
        $bien = $bienManager->updateReserve('oui', $bien);
        $_SESSION['success']['contrat']='Le contrat est ajouté avec succès !';
        header('Location:../contract-list.php?id='.$idClient);
    }
    else{
        $_SESSION['error']['client'] = "Vous devez remplir au moins le champs 'Nom du client', 'Projet' et le 'Bien' !";
        header('Location:../new-contract.php?id='.$idClient);
    }
    
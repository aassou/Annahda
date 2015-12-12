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
    $codeContrat = $_POST['codeContrat'];
    if( !empty($_POST['nom'])){
        $id = $_POST['idClient'];
        $nom = htmlentities($_POST['nom']);    
        $adresse = htmlentities($_POST['adresse']);
        $telephone1 = htmlentities($_POST['telephone1']);
        $telephone2 = htmlentities($_POST['telephone2']);
        $cin = htmlentities($_POST['cin']);
        $email = htmlentities($_POST['email']);
        //update a Client object
        $client = new Client(array('id' => $id, 'nom' => $nom, 'adresse' => $adresse,'telephone1' => $telephone1, 
        'telephone2' => $telephone2, 'cin' => $cin, 'email' => $email));
        $clientManager = new ClientManager($pdo);
        $clientManager->update($client);
        $_SESSION['client-update-success']="<strong>Opération valide</strong> : Informations du client '".$nom."' sont modifiées avec succès.";
        header('Location:../contrat.php?codeContrat='.$codeContrat);
    }
    else{
        $_SESSION['client-update-error'] = "<strong>Erreur Modification Client</strong> : Vous devez remplir au moins le champs 'Nom du client'.";
        header('Location:../contrat.php?codeContrat='.$codeContrat);
    }
    
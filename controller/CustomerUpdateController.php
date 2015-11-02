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
    if( !empty($_POST['nom'])){
        $id = $_POST['id_client'];
        $nom = htmlentities($_POST['nom']);    
        $adresse = htmlentities($_POST['adresse']);
        $telephone1 = htmlentities($_POST['telephone1']);
        $telephone2 = htmlentities($_POST['telephone2']);
        $cin = htmlentities($_POST['cin']);
        $email = htmlentities($_POST['email']);
        $facebook = htmlentities($_POST['facebook']);
        $created = htmlentities($_POST['created']);
        //update a Client object
        $client = new Client(array('id' => $id, 'nom' => $nom, 'adresse' => $adresse,'telephone1' => $telephone1, 
        'telephone2' => $telephone2, 'cin' => $cin, 'email' => $email, 'facebook' => $facebook, 'created' => $created));
        $clientManager = new ClientManager($pdo);
        $clientManager->update($client);
        $_SESSION['success']['client-update']='Les données du client "<strong>'.$nom.'</strong>" sont modifié avec succès !';
        header('Location:../update-customer.php?id='.$id);
    }
    else{
        $_SESSION['error']['project-update'] = "Vous devez remplir au moins le champs 'Nom du client' !";
        header('Location:../update-customer.php?id='.$id);
    }
    
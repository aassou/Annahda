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
        $id = $_POST['idFournisseur'];
        $nom = htmlentities($_POST['nom']);    
        $adresse = htmlentities($_POST['adresse']);
        $telephone1 = htmlentities($_POST['telephone1']);
        $telephone2 = htmlentities($_POST['telephone2']);
        $email = htmlentities($_POST['email']);
        $fax = htmlentities($_POST['fax']);
        //update a Founisseur object
        $fournisseur = new Fournisseur(array('id' => $id, 'nom' => $nom, 'adresse' => $adresse,'telephone1' => $telephone1, 
        'telephone2' => $telephone2, 'email' => $email, 'fax' => $fax));
        $fournisseurManager = new FournisseurManager($pdo);
        $fournisseurManager->update($fournisseur);
        $_SESSION['fournisseur-update-success']='<strong>Opération valide</strong> : Les données du fournisseur '.$nom.' sont modifiées avec succès.';
        header('Location:../fournisseurs.php#listFournisseurs');
    }
    else{
        $_SESSION['fournisseur-update-error'] = "<strong>Erreur Modification Fournisseur</strong> : Vous devez remplir au moins le champs 'Nom du fournisseur'.";
        header('Location:../fournisseurs.php');
    }
    
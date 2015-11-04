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
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $projetManager = new ProjetManager($pdo);
    
    if($action == "add"){
        if( !empty($_POST['nom']) ){
            $nom = htmlentities($_POST['nom']);
            $budget = htmlentities($_POST['budget']);
            $superficie = htmlentities($_POST['superficie']);
            $adresse = htmlentities($_POST['adresse']);
            $description = htmlentities($_POST['description']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $projet = 
            new Projet(array('nom' => $nom, 'superficie' => $superficie, 'budget' => $budget, 
            'adresse' => $adresse, 'description' => $description,
            'createdBy' => $createdBy, 'created' => $created));
            //add it to db
            $projetManager->add($projet);
            $actionMessage = "Opération Valide : Projet Ajouté avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout Projet : Vous devez remplir le champ <strong>Nom</strong>.";
            $typeMessage = "error";
        }
    }
    else if($action == "update"){
        $idProjet = htmlentities($_POST['idProjet']);
        if(!empty($_POST['nom'])){
            $nom = htmlentities($_POST['nom']);
            $budget = htmlentities($_POST['budget']);
            $superficie = htmlentities($_POST['superficie']);
            $adresse = htmlentities($_POST['adresse']);
            $description = htmlentities($_POST['description']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $projet = 
            new Projet(array('id' => $idProjet, 'nom' => $nom, 'budget' => $budget, 
            'superficie' => $superficie, 'adresse' => $adresse, 'description' => $description, 
            'updatedBy' => $updatedBy, 'updated' => $updated));
            $projetManager->update($projet);
            $actionMessage = "Opération Valide : Projet Modifié avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Projet : Vous devez remplir le champ <strong>Nom</strong>.";
            $typeMessage = "error";
        }
    }
    
    $_SESSION['projet-action-message'] = $actionMessage;
    $_SESSION['projet-type-message'] = $typeMessage;
    header('Location:../projets.php');
    
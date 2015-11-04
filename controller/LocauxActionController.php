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
    $locauxManager = new LocauxManager($pdo);
    $idProjet = htmlentities($_POST['idProjet']);
    
    if($action == "add"){
        if( !empty($_POST['code']) ){
            $code = htmlentities($_POST['code']);
            $prix = htmlentities($_POST['prix']);
            $superficie = htmlentities($_POST['superficie']);
            $facade = htmlentities($_POST['facade']);
            $mezzanine = htmlentities($_POST['mezzanine']);
            $status = htmlentities($_POST['status']);
            $par = htmlentities($_POST['par']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $locaux = 
            new Locaux(array('nom' => $code, 'prix' => $prix, 'superficie' => $superficie, 
            'facade' => $facade, 'mezzanine' => $mezzanine, 'idProjet' => $idProjet, 
            'status' => $status, 'par' => $par, 'createdBy' => $createdBy, 'created' => $created));
            //add it to db
            $locauxManager->add($locaux);
            $actionMessage = "Opération Valide : Local Commercial Ajouté avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout Local Commercial : Vous devez remplir le champ <strong>Nom</strong>.";
            $typeMessage = "error";
        }
    }
    else if($action == "update"){
        if(!empty($_POST['code'])){
            $id = htmlentities($_POST['idLocaux']);
            $code = htmlentities($_POST['code']);
            $prix = htmlentities($_POST['prix']);
            $superficie = htmlentities($_POST['superficie']);
            $facade = htmlentities($_POST['facade']);
            $mezzanine = htmlentities($_POST['mezzanine']);
            $status = htmlentities($_POST['status']);
            $par = htmlentities($_POST['par']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $locaux = 
            new Locaux(array('id' => $id, 'nom' => $code, 'prix' => $prix, 'superficie' => $superficie,
            'facade' => $facade, 'mezzanine' => $mezzanine, 'status' => $status, 'par' => $par, 
            'updatedBy' => $updatedBy, 'updated' => $updated));
            $locauxManager->update($locaux);
            $actionMessage = "Opération Valide : Local Commercial Modifié avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Local Commercial : Vous devez remplir le champ <strong>Code</strong>.";
            $typeMessage = "error";
        }
    }
    else if($action=="updateStatus"){
        $idLocaux = $_POST['idLocaux'];
        $status = htmlentities($_POST['status']);
        $locauxManager->changeStatus($idLocaux, $status);
        $actionMessage = "Opération Valide : Local Commercial Status Modifié avec succès.";
        $typeMessage = "success";
    }
    else if($action=="updateClient"){
        $idLocaux = $_POST['idLocaux'];
        $par = htmlentities($_POST['par']);
        $locauxManager->updatePar($par, $idLocaux);
        $actionMessage = "Opération Valide : Local Commercial Réservation Modifiée avec succès.";
        $typeMessage = "success";
    }
    else if($action=="delete"){
        $idLocaux = $_POST['idLocaux'];
        $locauxManager->delete($idLocaux);
        $actionMessage = "Opération Valide : Local Commercial Supprimé avec succès.";
        $typeMessage = "success";
    }
    
    $_SESSION['locaux-action-message'] = $actionMessage;
    $_SESSION['locaux-type-message'] = $typeMessage;
    header('Location:../locaux.php?idProjet='.$idProjet);
    
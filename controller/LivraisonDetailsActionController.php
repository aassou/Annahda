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
    //In this session variable we put all the POST, to get it in the contrats-add file
    //in case of error, and this help the user to do not put again what he filled out.
    $_SESSION['livraison-detail-data-form'] = $_POST;
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //process begins
    $livraisonDetailManager = new LivraisonDetailManager($pdo);
    $codeLivraison = htmlentities($_POST['codeLivraison']);
    if($action == "add"){
        if( !empty($_POST['prixUnitaire']) and !empty($_POST['quantite']) ){
            $designation = htmlentities($_POST['designation']);
            $quantite = htmlentities($_POST['quantite']);
            $prixUnitaire = htmlentities($_POST['prixUnitaire']);
            $idLivraison = htmlentities($_POST['idLivraison']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $livraisonDetail = 
            new LivraisonDetail(array('prixUnitaire' => $prixUnitaire, 'quantite' => $quantite,
            'designation' => $designation, 'idLivraison' => $idLivraison, 'createdBy' => $createdBy, 'created' => $created));
            //add it to db
            $livraisonDetailManager->add($livraisonDetail);
            $actionMessage = "<strong>Opération Valide</strong> : Article Ajouté avec succès.";  
            $typeMessage = "success";
            $redirectLink = "Location:../livraisons-details.php?codeLivraison=".$codeLivraison;
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Article</strong> : Vous devez remplir les champs <strong>Prix unitaire</strong> et <strong>Quantité</strong>.";
            $typeMessage = "error";
            $redirectLink = "Location:../livraisons-details.php?codeLivraison=".$codeLivraison;
        }
    }
    else if($action == "update"){
        if( !empty($_POST['prixUnitaire']) and !empty($_POST['quantite']) ){
            $idLivraisonDetail = htmlentities($_POST['idLivraisonDetail']);
            $designation = htmlentities($_POST['designation']);
            $quantite = htmlentities($_POST['quantite']);
            $prixUnitaire = htmlentities($_POST['prixUnitaire']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $livraisonDetail = 
            new LivraisonDetail(array('id' => $idLivraisonDetail, 'designation' => $designation,
            'prixUnitaire' => $prixUnitaire, 'quantite' => $quantite, 'updatedBy' => $updatedBy,
            'updated' => $updated));
            $livraisonDetailManager->update($livraisonDetail);
            $actionMessage = "<strong>Opération Valide</strong> : Article Modifié avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Article</strong> : Vous devez remplir les champs <strong>Prix unitaire</strong> et <strong>Quantité</strong>.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../livraisons-details.php?codeLivraison=".$codeLivraison;
    }
    else if($action=="delete"){
        $idLivraisonDetail = htmlentities($_POST['idLivraisonDetail']);
        $livraisonDetailManager->delete($idLivraisonDetail);
        $actionMessage = "<strong>Opération Valide</strong> : Article Supprimé avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../livraisons-details.php?codeLivraison=".$codeLivraison;
    }
    
    $_SESSION['livraison-detail-action-message'] = $actionMessage;
    $_SESSION['livraison-detail-type-message'] = $typeMessage;
    header($redirectLink);
    
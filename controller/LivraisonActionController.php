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
    $_SESSION['livraison-data-form'] = $_POST;
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //process begins
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
    $livraisonManager = new LivraisonManager($pdo);
    $idFournisseur = htmlentities($_POST['idFournisseur']);
    if($action == "add"){
        if( !empty($_POST['libelle']) ){
            $idProjet = htmlentities($_POST['idProjet']);
            $libelle = htmlentities($_POST['libelle']);
            $type = htmlentities($_POST['type']);
            $dateLivraison = htmlentities($_POST['dateLivraison']);
            $codeLivraison = uniqid().date('YmdHis');
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $livraison = 
            new Livraison(array('dateLivraison' => $dateLivraison, 'libelle' => $libelle, 'type' => $type,
            'idProjet' => $idProjet, 'idFournisseur' => $idFournisseur, 'code' => $codeLivraison,
            'createdBy' => $createdBy, 'created' => $created));
            //add it to db
            $livraisonManager->add($livraison);
            //add history data to db
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des livraisons",
                'description' => "Ajouter une livraison",
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Livraison Ajoutée avec succès.";  
            $typeMessage = "success";
            $redirectLink = "Location:../livraisons-details.php?codeLivraison=".$codeLivraison;
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Livraison</strong> : Vous devez remplir le champ <strong>N° BL</strong>.";
            $typeMessage = "error";
            $redirectLink = "Location:../livraisons-fournisseur.php?idFournisseur=".$idFournisseur;
        }
    }
    else if($action == "update"){
        if(!empty($_POST['libelle'])){
            $idProjet = htmlentities($_POST['idProjet']);
            $id = htmlentities($_POST['idLivraison']);
            $idFournisseur = htmlentities($_POST['idFournisseur']);
            $dateLivraison = htmlentities($_POST['dateLivraison']);
            $libelle = htmlentities($_POST['libelle']);
            $type = htmlentities($_POST['type']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $livraison = 
            new Livraison(array('id' => $id, 'dateLivraison' => $dateLivraison, 'libelle' => $libelle,
            'type' => $type, 'idProjet' => $idProjet, 'idFournisseur' => $idFournisseur, 
            'updatedBy' => $updatedBy, 'updated' => $updated));
            $livraisonManager->update($livraison);
            //add history data to db
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des livraisons",
                'description' => "Modifier une livraison",
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "<strong>Opération Valide</strong> : Livraison Modifiée avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Livraison</strong> : Vous devez remplir le champ <strong>N° BL</strong>.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../livraisons-fournisseur.php?idFournisseur=".$idFournisseur;
        //this case treat the updated request comming from livraisons-details.php page,
        //not livraisons-fournisseur.php page
        if( isset($_POST['source']) and $_POST['source']=="details-livraison" ){
            $codeLivraison = $_POST['codeLivraison'];
            $redirectLink = "Location:../livraisons-details.php?codeLivraison=".$codeLivraison;
        }
    }
    else if($action=="delete"){
        $livraisonDetailManager = new LivraisonDetailManager($pdo);
        $idLivraison = $_POST['idLivraison'];
        $livraisonManager->delete($idLivraison);
        //add history data to db
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des livraisons, Table détails livraisons",
            'description' => "Supprimer une livraison ainsi que ses détails",
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        //After we delete our Livraison record from the database, we should remove all LivraisonDetails
        //records that corresponds to the idLivraison
        $livraisonDetailManager->deleteLivraison($idLivraison);
        $actionMessage = "<strong>Opération Valide</strong> : Livraison Supprimée avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../livraisons-fournisseur.php?idFournisseur=".$idFournisseur;
    }
    
    $_SESSION['livraison-action-message'] = $actionMessage;
    $_SESSION['livraison-type-message'] = $typeMessage;
    header($redirectLink);
    
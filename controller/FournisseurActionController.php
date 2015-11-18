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
    $_SESSION['fournisseur-data-form'] = $_POST;
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //process begins
    $fournisseurManager = new fournisseurManager($pdo);
    $idFournisseur = htmlentities($_POST['idFournisseur']);
    if( $action == "add" ) {
        if( !empty($_POST['nom']) ) {
            $nom = htmlentities($_POST['nom']);    
            if( $fournisseurManager->exists($nom) ) {
                $actionMessage = "<strong>Erreur Ajout Fournisseur : </strong>Un fournisseur existe déjà avec ce nom : <strong>".$nom."</strong>.";
                $typeMessage = "error";
            }
            else{
                $adresse = htmlentities($_POST['adresse']);
                $telephone1 = htmlentities($_POST['telephone1']);
                $telephone2 = htmlentities($_POST['telephone2']);
                $fax = htmlentities($_POST['fax']);
                $email = htmlentities($_POST['email']);
                $codeFournisseur = uniqid().date('YmdHis');
                $createdBy = $_SESSION['userMerlaTrav']->login();
                $created = date('Y-m-d h:i:s');
                $fournisseur = 
                new fournisseur(array('code' => $codeFournisseur, 'nom' => $nom, 'adresse' => $adresse, 
                'telephone1' => $telephone1, 'telephone2' => $telephone2, 'fax' => $fax, 'email' => $email,   
                'createdBy' => $createdBy, 'created' => $created));
                $fournisseurManager->add($fournisseur);
                $actionMessage = "<strong>Opération Valide</strong> : Fournisseur Ajouté avec succès.";
                $typeMessage = "success";
            }   
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Fournisseur</strong> : Vous devez remplir le champ <strong>Nom</strong>.";
            $typeMessage = "error";
        }
        //in this line we specify the response url basing on the source of our request
        $redirectLink = "Location:../fournisseurs.php";
        if( isset($_POST['source']) and $_POST['source']=='livraisons-group' ) {
            $redirectLink = "Location:../livraisons-group.php";   
        }
    }
    else if($action == "update"){
        $idFournisseur = htmlentities($_POST['idFournisseur']);
        if( !empty($_POST['nom']) ) {
            $nom = htmlentities($_POST['nom']);    
            if( $fournisseurManager->exists($nom) ){
                $actionMessage = "<strong>Erreur Modification Fournisseur : </strong>Un fournisseur existe déjà avec ce nom : <strong>".$nom."</strong>.";
                $typeMessage = "error";
            }
            else{
                $adresse = htmlentities($_POST['adresse']);
                $telephone1 = htmlentities($_POST['telephone1']);
                $telephone2 = htmlentities($_POST['telephone2']);
                $fax = htmlentities($_POST['fax']);
                $email = htmlentities($_POST['email']);
                $updatedBy = $_SESSION['userMerlaTrav']->login();
                $updated = date('Y-m-d h:i:s');
                $fournisseur = 
                new fournisseur(array('id' => $idFournisseur, 'nom' => $nom, 'adresse' => $adresse, 
                'telephone1' => $telephone1, 'telephone2' => $telephone2, 'fax' => $fax, 'email' => $email,   
                'updatedBy' => $updatedBy, 'updated' => $updated));
                $fournisseurManager->update($fournisseur);
                $actionMessage = "<strong>Opération Valide</strong> : Fournisseur Modifié avec succès.";
                $typeMessage = "success";
            }   
        }
        else{
            $actionMessage = "<strong>Erreur Modification Fournisseur</strong> : Vous devez remplir le champ <strong>Nom</strong>.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../fournisseurs.php";
    }
    else if($action=="delete"){
        $idfournisseur = $_POST['idfournisseur'];
        $fournisseurManager->delete($idfournisseur);
        $actionMessage = "<strong>Opération Valide</strong> : fournisseur Supprimée avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../fournisseurs.php";
    }
    
    $_SESSION['fournisseur-action-message'] = $actionMessage;
    $_SESSION['fournisseur-type-message'] = $typeMessage;
    header($redirectLink);
    
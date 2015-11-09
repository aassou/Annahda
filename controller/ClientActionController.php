<?php
/**
 * This is a Model class for the customer component
 * Created By : AASSOU Abdelilah
 * Date       : 03/11/2015
 * Github     : @aassou
 * email      : aassou.abdelilah@gmail.com
 * Description: This controller is used to create a new customer if it doesn't exist, or get it from 
 *              the database if exists. If all goes nomrmal, this controller sends the customer 
 *              informations to the contract property url to finish the process.
 */
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
    //the action input precise which action the controller is going to prossed, 
    //add action, update action or delete action
    $action = htmlentities($_POST['action']);
    $idProjet = htmlentities($_POST['idProjet']);
    //This var contains result message of CRUD action and the redirection url link
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //class manager
    $clientManager = new ClientManager($pdo);
    //process starts
    //Case 1 : CRUD Add Action 
    if($action == "add"){
        $codeClient = "";
        $client = "";
        //if the client exists in the database, and we get its information from the clients-add.php file
        //we just are going to send its informations to the next url : contrats-add.php 
        if( !empty($_POST['idClient']) ){
            $idClient = htmlentities($_POST['idClient']);
            $client = $clientManager->getClientById($idClient);
            $codeClient = $client->code();
            $actionMessage = "<strong>Opération Valide : </strong>Client Récuperé avec succès.";
            $typeMessage = "info";
            $redirectLink = 'Location:../contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient;
        }
        //if we don't get any customer information from the clients-add.php page, 
        //then there is one of two cases to treat
        else if( empty($_POST['idClient']) ){
            //Case 1 :  if we tray to force the creation of an existing customer
            //we get an error message indicating that we do have a customer with that name 
            if( !empty($_POST['nom'])){
                $nom = htmlentities($_POST['nom']);
                if( $clientManager->exists($nom) ){
                    $actionMessage = "<strong>Erreur Création Client : </strong>Un client existe déjà avec ce nom : <strong>&lt;".$nom."&gt;</strong>.";
                    $typeMessage = "error";
                    $redirectLink = 'Location:../clients-add.php?idProjet='.$idProjet;
                }
                //Case 2 :  The customer doesn't exist, so we add to our database, 
                //and the send its generated code to the contrats-add.php url   
                else{
                    //input posts processing
                    $cin = htmlentities($_POST['cin']);
                    $adresse = htmlentities($_POST['adresse']);
                    $telephone1 = htmlentities($_POST['telephone1']);
                    $telephone2 = htmlentities($_POST['telephone2']);
                    $email = htmlentities($_POST['email']);
                    $codeClient = uniqid().date('YmdHis');
                    $created = date('Y-m-d h:i:s');
                    $createdBy =  $_SESSION['userMerlaTrav']->login();
                    //object creation
                    $client = 
                    new Client(array('nom' => $nom, 'cin' => $cin, 'adresse' => $adresse,
                    'telephone1' => $telephone1, 'telephone2' =>$telephone2, 'email' => $email, 
                    'code' => $codeClient, 'created' => $created, 'createdBy' => $createdBy));
                    //push object to db
                    $clientManager->add($client);
                    //result processes   
                    $actionMessage = "<strong>Opération Valide : </strong>Client Ajouté(e) avec succès.";
                    $typeMessage = "success";
                    $redirectLink = 'Location:../contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient;
                }
            }
            //This is a simple form validation, the field Nom should not be empty
            else{
                $actionMessage = "<strong>Erreur Création Client : </strong>Vous devez remplir au moins le champ <strong>&lt;Nom&gt;</strong>.";
                $typeMessage = "error";
                $redirectLink = 'Location:../clients-add.php?idProjet='.$idProjet;
            }   
        }
    }
    else if($action == "update"){
        if(!empty($_POST['nom'])){
            $id = htmlentities($_POST['idClient']);
            $nom = htmlentities($_POST['nom']);
            $cin = htmlentities($_POST['cin']);
            $adresse = htmlentities($_POST['adresse']);
            $telephone1 = htmlentities($_POST['telephone1']);
            $telephone2 = htmlentities($_POST['telephone2']);
            $email = htmlentities($_POST['email']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $codeContrat = htmlentities($_POST['codeContrat']);
            //This input is used to specify the redirect link. Because you can launch the update of a client
            //from one of these 2 url : contrat.php or client-list.php, so you have to specify based on the
            //source input to which one of them you'll be redirected.
            $source = htmlentities($_POST['source']);
            $client = 
            new Client(array('id' => $id, 'nom' => $nom, 'cin' => $cin, 
            'adresse' => $adresse, 'telephone1' => $telephone1, 'telephone2' => $telephone2, 
            'email' => $email, 'updatedBy' => $updatedBy, 'updated' => $updated));
            $clientManager->update($client);
            $actionMessage = "<strong>Opération Valide : </strong>Client Modifié(e) avec succès.";
            $typeMessage = "success";
            if( $source == "contrat" ){
                $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat;
            }
            else if( $source="clients.php" ){
                $redirectLink = "Location:../clients.php?idProjet=".$idProjet;   
            }
        }
        else{
            $actionMessage = "<strong>Erreur Modification Client : </strong>Vous devez remplir le champ <strong>&lt;Nom&gt;</strong>.";
            $typeMessage = "error";
            if( $source == "contrat" ){
                $redirectLink = "Location:../contrat.php?codeContrat=".$codeClient;
            }
            else if( $source="clients" ){
                $redirectLink = "Location:../clients.php?idProjet=".$idProjet;   
            }
        }
    }
    else if($action=="delete"){
        $idClient = $_POST['idClient'];
        $clientManager->delete($idClient);
        $actionMessage = "<strong>Opération Valide : </strong>Client Supprimé(e) avec succès.";
        $typeMessage = "success";
        $redirectLink = "";
    }
    
    $_SESSION['client-action-message'] = $actionMessage;
    $_SESSION['client-type-message'] = $typeMessage;
    header($redirectLink);
    
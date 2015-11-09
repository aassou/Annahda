<?php
/**
 * This is a Model class for the Contract Component
 * 
 * Created By : AASSOU Abdelilah
 * Date       : 03/11/2015
 * Github     : aassou
 * Twitter    : @a_aassou
 * email      : aassou.abdelilah@gmail.com
 * Description: This controller is used to create a new contract based on the customer data
 *              received form the clients-add.php url.
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
    $contratManager = new ContratManager($pdo);
    //process starts
    //Case 1 : CRUD Add Action 
    if($action == "add"){
        $codeClient = $_POST['codeClient'];
        //post input validation
        if( !empty($_POST['typeBien']) ){
            if( !empty($_POST['prixNegocie']) ){
                $prixNegocie = htmlentities($_POST['prixNegocie']);
                $numero = htmlentities($_POST['numero']);
                $typeBien = htmlentities($_POST['typeBien']);
                $idBien = htmlentities($_POST['bien']);
                $dateCreation = htmlentities($_POST['dateCreation']);
                $avance = htmlentities($_POST['avance']);
                $modePaiement = htmlentities($_POST['modePaiement']);
                $dureePaiement = htmlentities($_POST['dureePaiement']);
                $nombreMois = htmlentities($_POST['nombreMois']);
                $echeance = htmlentities($_POST['echeance']);
                $note = htmlentities($_POST['note']);
                $idClient = htmlentities($_POST['idClient']);
                $codeContrat = uniqid().date('YmdHis');
                $created = date('Y-m-d h:i:s');
                $createdBy = $_SESSION['userMerlaTrav']->login();
                $numeroCheque = '0';
                if( isset($_POST['numeroCheque']) ){
                    $numeroCheque = htmlentities($_POST['numeroCheque']);
                }
                //create the contract object
                $contrat = 
                new Contrat(array('numero' => $numero, 'dateCreation' => $dateCreation, 'prixVente' => $prixNegocie, 
                'avance' => $avance, 'modePaiement' => $modePaiement, 'dureePaiement' => $dureePaiement, 
                'nombreMois' => $nombreMois, 'echeance' => $echeance, 'note' => $note, 'idClient' => $idClient, 
                'idProjet' => $idProjet, 'idBien' => $idBien, 'typeBien' => $typeBien, 'code' => $codeContrat, 
                'numeroCheque' => $numeroCheque, 'created' => $created, 'createdBy' => $createdBy));
                //adding the contract object to our database
                $contratManager->add($contrat);
                //in the next if elseif statement, we test the type of property to change its status from
                if($typeBien=="appartement"){
                    $appartementManager = new AppartementManager($pdo);
                    $appartementManager->changeStatus($idBien, "Vendu");
                }
                else if($typeBien=="localCommercial"){
                    $locauxManager = new LocauxManager($pdo);
                    $locauxManager->changeStatus($idBien, "Vendu");
                }
                //add contract note into db and show it in the dashboard
                $notesClientManager = new NotesClientManager($pdo);
                $notesClient = new NotesClient(array('note' => $note, 'created' => date('Y-m-d'), 
                'idProjet' => $idProjet, 'codeContrat' => $codeContrat));
                $notesClientManager->add($notesClient);
                $actionMessage = "<strong>Opération valide : </strong>Contrat Client ajouté(e) avec succès.";
                $typeMessage = "success";
                $redirectLink = 'Location:../contrat.php?codeContrat='.$codeContrat."&idProjet=".$idProjet;
            }
            else{
                $actionMessage = "<strong>Erreur Création Contrat : </strong>Vous devez remplir le champ <strong>&lt;Prix négocié&gt;</strong>.";
                $typeMessage = "error";
                $redirectLink = 'Location:../contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient;
            }
        }
        else{
            $actionMessage = "<strong>Erreur Création Contrat : </strong>Vous devez choisir un <strong>&lt;Type de bien&gt;</strong.";
            $typeMessage = "error";    
            $redirectLink = 'Location:../contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient;
        }
    }
    else if($action == "update"){
        $idContrat = htmlentities($_POST['idContrat']);
        $codeContrat = htmlentities($_POST['codeContrat']);
        if(!empty($_POST['prixVente'])){
            $prixVente = htmlentities($_POST['prixVente']);
            $numero = htmlentities($_POST['numero']);
            $numeroCheque = htmlentities($_POST['numeroCheque']);
            $dateCreation = htmlentities($_POST['dateCreation']);
            $avance = htmlentities($_POST['avance']);
            $modePaiement = htmlentities($_POST['modePaiement']);
            $dureePaiement = htmlentities($_POST['dureePaiement']);
            $nombreMois = htmlentities($_POST['nombreMois']);
            $echeance = htmlentities($_POST['echeance']);
            $note = htmlentities($_POST['note']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            //create classes managers
            $locauxManager = new LocauxManager($pdo);
            $contratManager = new ContratManager($pdo);
            $appartementManager = new AppartementManager($pdo);
            //create classes
            //this contrat object is used to test the type of a property based of 
            //the id of the current contrat objet
            $contrat = $contratManager->getContratById($idContrat);
            $newContrat = 
            new Contrat(array('id' => $idContrat, 'numero' => $numero, 'dateCreation' => $dateCreation, 
            'prixVente' => $prixVente, 'avance' => $avance, 'modePaiement' => $modePaiement, 
            'nombreMois' => $nombreMois, 'dureePaiement' => $dureePaiement,'echeance' => $echeance, 
            'numeroCheque' => $numeroCheque, 'note' => $note, 'updated' => $updated, 'updatedBy' => $updatedBy));
            //begin processing
            $contratManager->update($newContrat);
            //update client's note
            $notesClientManager = new NotesClientManager($pdo);
            $notesClient = new NotesClient(array('note' => $note, 'created' => date('Y-m-d'), 
            'idProjet' => $contrat->idProjet(), 'codeContrat' => $contrat->code()));
            $notesClientManager->add($notesClient);
            //test if the typeBien radio box is checked
            //if yes then we use our contrat object mentioned earlier
            if( isset($_POST['typeBien']) ){
                $typeBien = $_POST['typeBien'];
                $idBien = $_POST['bien'];
                //change status of the old contrat Bien from Réservé to Disponible
                if( $contrat->typeBien()=="appartement" ){
                    $appartementManager->changeStatus($contrat->idBien(), "Disponible");
                }
                else if( $contrat->typeBien()=="localCommercial" ){
                    $locauxManager->changeStatus($contrat->idBien(), "Disponible");
                }
                //change status of the new contrat Bien from Disponible to Réservé
                if( $typeBien=="appartement" ){
                    $contratManager->changerBien($idContrat, $idBien, $typeBien);
                    $appartementManager->changeStatus($idBien, "Vendu");
                }
                else if( $typeBien=="localCommercial" ){
                    $contratManager->changerBien($idContrat, $idBien, $typeBien);
                    $locauxManager->changeStatus($idBien, "Vendu");
                }
            }
            $actionMessage = "<strong>Opération Valide : </strong>Contrat modifié(e) avec succès.";
            $typeMessage = "success";
            $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat;
        }
        else{
            $actionMessage = "<strong>Erreur Modification Client : </strong>Vous devez remplir le champ <strong>&lt;Prix de vente&gt;</strong>.";
            $typeMessage = "error";
            $redirectLink = "Location:../contrat.php?codeContrat=".$codeContrat;
        }
    }
    else if($action=="delete"){
        $idContrat = $_POST['idContrat'];
        $contratManager->delete($idContrat);
        //after the delete of our contract, we should change the property status to "Disponible"
        $actionMessage = "<strong>Opération Valide : </strong>Contrat Supprimé(e) avec succès.";
        $typeMessage = "success";
        $redirectLink = "";
    }
    
    $_SESSION['contrat-action-message'] = $actionMessage;
    $_SESSION['contrat-type-message'] = $typeMessage;
    header($redirectLink);
    
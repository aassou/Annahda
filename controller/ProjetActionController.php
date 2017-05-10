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
    $typeMessage   = "";
    $redirectLink  = "";
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
    $projetManager  = new ProjetManager($pdo);
    
    if($action == "add"){
        if( !empty($_POST['nom']) && !empty($_POST['adresse']) 
        && !empty($_POST['nomArabe']) && !empty($_POST['adresseArabe'])){
            $nom = htmlentities($_POST['nom']);
            $nomArabe = htmlentities($_POST['nomArabe']);
            $titre = htmlentities($_POST['titre']);
            $budget = htmlentities($_POST['budget']);
            $superficie = htmlentities($_POST['superficie']);
            $adresse = htmlentities($_POST['adresse']);
            $adresseArabe = htmlentities($_POST['adresseArabe']); 
            $description = htmlentities($_POST['description']);
            $numeroLot = htmlentities($_POST['numeroLot']);
            $numeroAutorisation = htmlentities($_POST['numeroAutorisation']);
            $nombreEtages = htmlentities($_POST['nombreEtages']);
            $sousSol = htmlentities($_POST['sousSol']);
            $rezDeChausser = htmlentities($_POST['rezDeChausser']);
            $mezzanin = htmlentities($_POST['mezzanin']);
            $cageEscalier = htmlentities($_POST['cageEscalier']);
            $terrase = htmlentities($_POST['terrase']);
            $superficieEtages = htmlentities($_POST['superficieEtages']);
            $delai = htmlentities($_POST['delai']);
            $prixParMetreTTC = htmlentities($_POST['prixParMetreTTC']);
            $prixParMetreHT = htmlentities($_POST['prixParMetreHT']);
            $TVA = htmlentities($_POST['TVA']);
            $architecte = htmlentities($_POST['architecte']);
            $bet = htmlentities($_POST['bet']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $projet = 
            new Projet(array('nom' => $nom, 'nomArabe' => $nomArabe, 'titre' => $titre, 'superficie' => $superficie, 
            'budget' => $budget, 'numeroLot' => $numeroLot, 'numeroAutorisation' => $numeroAutorisation,
            'nombreEtages' => $nombreEtages, 'sousSol' => $sousSol, 'rezDeChausser' => $rezDeChausser,
            'mezzanin' => $mezzanin, 'cageEscalier' => $cageEscalier, 'terrase' => $terrase,
            'superficieEtages' => $superficieEtages, 'delai' => $delai, 'prixParMetreTTC' => $prixParMetreTTC,
            'prixParMetreHT' => $prixParMetreHT, 'TVA' => $TVA, 'architecte' => $architecte, 'bet' => $bet,
            'adresse' => $adresse, 'adresseArabe' => $adresseArabe, 'description' => $description,
            'createdBy' => $createdBy, 'created' => $created));
            //add it to db
            $projetManager->add($projet);
            //add History data
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des projets",
                'description' => "Ajout du projet : ".$nom,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "Opération Valide : Projet Ajouté avec succès.";  
            $typeMessage = "success";
            $redirectLink = "Location:../projets.php";
        }
        else{
            $actionMessage = "Erreur Ajout Projet : Vous devez remplir tous les champs obligatoires *";
            $typeMessage = "error";
            $redirectLink = "Location:../projet-add.php";
        }
    }
    else if($action == "update"){
        $idProjet = htmlentities($_POST['idProjet']);
        if( !empty($_POST['nom']) && !empty($_POST['adresse']) 
        && !empty($_POST['nomArabe']) && !empty($_POST['adresseArabe'])){
            $nom = htmlentities($_POST['nom']);
            $nomArabe = htmlentities($_POST['nomArabe']);
            $titre = htmlentities($_POST['titre']);
            $budget = htmlentities($_POST['budget']);
            $superficie = htmlentities($_POST['superficie']);
            $adresse = htmlentities($_POST['adresse']);
            $adresseArabe = htmlentities($_POST['adresseArabe']);
            $description = htmlentities($_POST['description']);
            $numeroLot = htmlentities($_POST['numeroLot']);
            $numeroAutorisation = htmlentities($_POST['numeroAutorisation']);
            $nombreEtages = htmlentities($_POST['nombreEtages']);
            $sousSol = htmlentities($_POST['sousSol']);
            $rezDeChausser = htmlentities($_POST['rezDeChausser']);
            $mezzanin = htmlentities($_POST['mezzanin']);
            $cageEscalier = htmlentities($_POST['cageEscalier']);
            $terrase = htmlentities($_POST['terrase']);
            $superficieEtages = htmlentities($_POST['superficieEtages']);
            $delai = htmlentities($_POST['delai']);
            $prixParMetreTTC = htmlentities($_POST['prixParMetreTTC']);
            $prixParMetreHT = htmlentities($_POST['prixParMetreHT']);
            $TVA = htmlentities($_POST['TVA']);
            $architecte = htmlentities($_POST['architecte']);
            $bet = htmlentities($_POST['bet']);
            $updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $projet = 
            new Projet(array('id' => $idProjet, 'nom' => $nom, 'nomArabe' => $nomArabe, 'titre' => $titre, 
            'budget' => $budget,  'numeroLot' => $numeroLot, 'numeroAutorisation' => $numeroAutorisation,
            'nombreEtages' => $nombreEtages, 'sousSol' => $sousSol, 'rezDeChausser' => $rezDeChausser,
            'mezzanin' => $mezzanin, 'cageEscalier' => $cageEscalier, 'terrase' => $terrase,
            'superficieEtages' => $superficieEtages, 'delai' => $delai, 'prixParMetreTTC' => $prixParMetreTTC,
            'prixParMetreHT' => $prixParMetreHT, 'TVA' => $TVA, 'architecte' => $architecte, 'bet' => $bet,
            'superficie' => $superficie, 'adresse' => $adresse, 'adresseArabe' => $adresseArabe, 
            'description' => $description, 'updatedBy' => $updatedBy, 'updated' => $updated));
            $projetManager->update($projet);
            //add History data
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des projets",
                'description' => "Modification du projet : ".$nom,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
            $actionMessage = "Opération Valide : Projet Modifié avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Projet : Vous devez remplir le champ <strong>Nom</strong>.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../projet-update.php?idProjet=$idProjet";
    }
    
    $_SESSION['projet-action-message'] = $actionMessage;
    $_SESSION['projet-type-message'] = $typeMessage;
    header($redirectLink);
    
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
    if( !empty($_POST['id_projet']) and !empty($_POST['numero_bien'])){
        $idProjet = htmlentities($_POST['id_projet']);    
        $numeroBien = htmlentities($_POST['numero_bien']);
        $etage = htmlentities($_POST['etage']);
        $superficie = htmlentities($_POST['superficie']);
        $facade = htmlentities($_POST['facade']);
        $reserve = "non";
        
        $bien = new Bien(array('numero' => $numeroBien, 'etage' => $etage,'superficie' => $superficie, 
        'facade' =>$facade, 'reserve' => $reserve, 'idProjet' => $idProjet));
        $bienManager = new BienManager($pdo);
        $bienManager->add($bien);
        $_SESSION['success']['bien']='Votre bien est ajouté avec succès !';
        header('Location:../project-propety-list.php?id='.$idProjet);
    }
    else{
        $_SESSION['error']['bien'] = "Vous devez remplir au moins le champ 'Numéro du bien' !";
        
        header('Location:../new-property.php');
    }
    
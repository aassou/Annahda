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
    if( !empty($_POST['numero'])){
        $id = $_POST['id_bien'];
        $idProjet = $_POST['id_projet'];
        $numero = htmlentities($_POST['numero']);
        $etage = htmlentities($_POST['etage']);    
        $superficie = htmlentities($_POST['superficie']);
        $facade = htmlentities($_POST['facade']);
        $reserve = htmlentities($_POST['reserve']);
        if(filter_var($_POST['superficie'], FILTER_VALIDATE_FLOAT)==true){
            $superficie = htmlentities($_POST['superficie']);
        }
        else {
            $_SESSION['error']['bien-update']="La valeur du champs <strong>'Superficie'</strong> est incorrecte !";
            header('Location:../update-property.php');
            exit;
        }
        
        $bien = new Bien(array('id' => $id, 'numero' => $numero, 'etage' => $etage,'superficie' => $superficie, 
        'facade' => $facade, 'reserve' => $reserve, 'idProjet' => $idProjet));
        $biensManager = new BienManager($pdo);
        $biensManager->update($bien);
        $_SESSION['success']['bien-update']='Votre bien est modifié avec succès !';
        header('Location:../update-property.php?id='.$id);
    }
    else{
        $_SESSION['error']['bien-update'] = "Vous devez remplir au moins le champs 'Numéro du bien' !";
        header('Location:../update-property.php?id='.$_SESSION['idBien']);
    }
    
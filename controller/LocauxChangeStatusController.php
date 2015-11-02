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
    $idProjet = $_POST['idProjet'];
	$idLocaux = $_POST['idLocaux'];
	$status = $_POST['status'];
	$locauxManager = new LocauxManager($pdo);
    $locauxManager->changeStatus($idLocaux, $status);
    $_SESSION['locaux-changed-status'] = "<strong>Opération valide : </strong>Status du local commercial est changé avec succès !";
	header('Location:../locaux.php?idProjet='.$idProjet);
    
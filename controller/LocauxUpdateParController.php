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
	$par = htmlentities($_POST['par']);
	$locauxManager = new LocauxManager($pdo);
    $locauxManager->updatePar($par, $idLocaux);
	header('Location:../locaux.php?idProjet='.$idProjet);
    
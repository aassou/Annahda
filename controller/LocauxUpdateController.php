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
	$redirect = 'Location:../locaux.php?idProjet='.$idProjet;
	if( $_GET['p']==2 ){
		$redirect = "Location:../locaux-detail.php?idLocaux=".$idLocaux."&idProjet=".$idProjet;	
	}
    if( !empty($_POST['code'])){
        $code = htmlentities($_POST['code']);    
        $facade = htmlentities($_POST['facade']);
        $superficie = 0;
        $prix = 0;
		$status = htmlentities($_POST['status']);
		$mezzanine = htmlentities($_POST['mezzanine']);
        if(filter_var($_POST['superficie'], FILTER_VALIDATE_FLOAT)==true){
            $superficie = htmlentities($_POST['superficie']);
        }
        else {
            $_SESSION['locaux-update-error']="<strong>Erreur modification Local</strong> : La valeur du champ 'Superficie' est incorrecte !";
            header($redirect);
            exit;
        }
        if(filter_var($_POST['prix'], FILTER_VALIDATE_FLOAT)==true){
            $prix = htmlentities($_POST['prix']);
        }
        else {
            $_SESSION['locaux-update-error']="<strong>Erreur Modification Local</strong> : La valeur du champ 'Prix' est incorrecte !";
            header($redirect);
            exit;
        }
        
        $locaux = new Locaux(array('id' => $idLocaux, 'nom' => $code, 'prix' => $prix,'superficie' => $superficie, 
        'facade' =>$facade, 'status' => $status, 'mezzanine' => $mezzanine));
        $locauxManager = new LocauxManager($pdo);
        $locauxManager->update($locaux);
        $_SESSION['locaux-update-success']="<strong>Opération valide : </strong>Le local commercial est modifié avec succès !";
    }
    else{
        $_SESSION['locaux-update-error'] = "<strong>Erreur Modification Local commercial : </strong>Vous devez remplir au moins le champ 'Code'.";
    }
	header($redirect);
    
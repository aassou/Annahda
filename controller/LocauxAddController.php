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
    $locauxManager = new LocauxManager($pdo);
    $idProjet = $_POST['idProjet'];
    if( !empty($_POST['code'])){
        $nom = htmlentities($_POST['code']);    
		if($locauxManager->exists($nom)>0){
	    	$_SESSION['locaux-add-error'] = "<strong>Erreur Ajout Appartement : </strong>Un appartement existe déjà avec ce code '<strong>".$nom."</strong>'.";
			header('Location:../locaux.php?idProjet='.$idProjet.'#tab_1');
			exit;			
	    }
		else{
			$facade = htmlentities($_POST['facade']);
			$status = htmlentities($_POST['status']);
			$mezzanine = htmlentities($_POST['mezzanine']);
	        $prix = 0;
	        $superficie = htmlentities($_POST['superficie']);
	        if(filter_var($_POST['prix'], FILTER_VALIDATE_FLOAT)==true){
	            $prix = htmlentities($_POST['prix']);
	        }
	        else {
	            $_SESSION['locaux-add-error']="<strong>Erreur Ajout Local commercial</strong> : La valeur du champ 'Prix' est incorrecte !";
	            header('Location:../locaux.php?idProjet='.$idProjet.'#tab_1');
	            exit;
	        }
	        $par = "Aucun";
			if( isset($_POST['par']) ){
				$par = $_POST['par'];	
			}
	        $locaux = new Locaux(array('nom' => $nom, 'prix' => $prix,'superficie' => $superficie, 
	        'facade' =>$facade, 'status' => $status, 'mezzanine' => $mezzanine,'idProjet' => $idProjet, 'par' => $par));
	        $locauxManager->add($locaux);
	        $_SESSION['locaux-add-success']="<strong>Opération valide : </strong>Le Local commercial est ajouté avec succès !";	
		}
    }
    else{
        $_SESSION['locaux-add-error'] = "<strong>Erreur Ajout Local commercial : </strong>Vous devez remplir au moins le champ 'Code'.";
    }
	header('Location:../locaux.php?idProjet='.$idProjet.'#tab_1');
    
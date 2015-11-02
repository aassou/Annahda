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
	$appartementManager = new AppartementManager($pdo);
    if( !empty($_POST['code']) ){
        $nom = htmlentities($_POST['code']);
		    if($appartementManager->exists($nom)>0){
		    	$_SESSION['appartement-add-error'] = "<strong>Erreur Ajout Appartement : </strong>Un appartement existe déjà avec ce code '".$nom."'.";
				header('Location:../appartements.php?idProjet='.$idProjet.'#tab_1');
				exit;			
		    }
			else{
				$facade = htmlentities($_POST['facade']);
				$status = htmlentities($_POST['status']);
				$cave = htmlentities($_POST['cave']);
				$niveau = htmlentities($_POST['niveau']);
				$nombrePiece = htmlentities($_POST['nombrePiece']);
		        $superficie = htmlentities($_POST['superficie']);
				$prix = htmlentities($_POST['prix']);
				$par = "Aucun";
				if( isset($_POST['par']) ){
					$par = $_POST['par'];	
				}
				//add object
		        $appartement = new Appartement(array('nom' => $nom, 'prix' => $prix,'superficie' => $superficie, 
		        'facade' =>$facade, 'status' => $status, 'cave' => $cave, 'niveau' => $niveau, 
		        'nombrePiece' => $nombrePiece,'idProjet' => $idProjet, 'par' => $par));
		        //add the object to db
		        $appartementManager->add($appartement);
		        $_SESSION['appartement-add-success'] = "<strong>Opération valide : </strong>L' Appartement est ajoutée avec succès !";	
			}
    }
    else{
        $_SESSION['appartement-add-error'] = "<strong>Erreur Ajout Appartement : </strong>Vous devez remplir au moins le champ 'Code'.";
    }
	header('Location:../appartements.php?idProjet='.$idProjet.'#tab_1');
    
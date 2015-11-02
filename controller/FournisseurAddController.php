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
	$codeFournisseur = "";
	$fournisseur = "";
	$fournisseurManager = new FournisseurManager($pdo);
	//test if fournisseur row exist in the db if yes we load 
	if( !empty($_POST['idFournisseur']) ){
		$idFournisseur = $_POST['idFournisseur'];
		$fournisseur = $fournisseurManager->getFournisseurById($idFournisseur);
		$codeFournisseur = $fournisseur->code();
	}
	//else we create a new fournisseur
	else if( empty($_POST['idFournisseur']) ){
		if( !empty($_POST['nom']) ){    
	        $nom = htmlentities($_POST['nom']);    
			if( $fournisseurManager->exists($nom) ){
				$_SESSION['fournisseur-add-error'] = "<strong>Erreur Ajout Fournisseur : </strong>Un fournisseur existe déjà avec ce nom : ".$nom.".";
		        $redirectLink = 'Location:../fournisseurs.php#tab_1';
				if(isset($_GET['p']) and $_GET['p']==1){
					$redirectLink = 'Location:../livraisons.php';
				}
		        header($redirectLink);
				exit;	
			}
			else{
				$adresse = htmlentities($_POST['adresse']);
		        $telephone1 = htmlentities($_POST['telephone1']);
		        $telephone2 = htmlentities($_POST['telephone2']);
		        $email = htmlentities($_POST['email']);
		        $fax = htmlentities($_POST['fax']);
		        $created = date("Y-m-d");
				$codeFournisseur = uniqid().date('YmdHis');
		        //create a new Fournisseur object
		        $fournisseur = new Fournisseur(array('nom' => $nom, 'adresse' => $adresse,'telephone1' => $telephone1, 
		        'telephone2' =>$telephone2, 'email' => $email, 'fax' => $fax, 'dateCreation' => $created, 'code' => $codeFournisseur));
		        $fournisseurManager = new FournisseurManager($pdo);
		        $fournisseurManager->add($fournisseur);
				$_SESSION['fournisseur-add-success'] = "<strong>Opération valide : </strong>Le fournisseur '".$nom."' est ajouté avec succès";	
			}
	    }
	    else{
	        $_SESSION['fournisseur-add-error'] = "<strong>Erreur Ajout Fournisseur : </strong>Vous devez remplir au moins le champ 'Nom'.";
	        $redirectLink = 'Location:../fournisseurs.php#tab_1';
			if(isset($_GET['p']) and $_GET['p']==1){
				$redirectLink = 'Location:../livraisons.php';
			}
	        header($redirectLink);
			exit;
	    }	
	}
	$redirectLink = 'Location:../fournisseurs.php#tab_1';
	if(isset($_GET['p']) and $_GET['p']==1){
		$redirectLink = 'Location:../livraisons.php';
	}
	header($redirectLink);
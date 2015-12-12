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
    $idProjet = htmlentities($_POST['idProjet']);
	$idFournisseur = htmlentities($_POST['idFournisseur']);
	if( !empty($_POST['idProjet']) and !empty($_POST['idFournisseur']) ){
		if( !empty($_POST['dateLivraison']) ){
	        $dateLivraison = htmlentities($_POST['dateLivraison']);
			$libelle = htmlentities($_POST['libelle']);
			$codeLivraison = uniqid().date('YmdHis');
	        //CREATE NEW Livraison object
	        $livraison = new Livraison(array('dateLivraison' => $dateLivraison, 'libelle' => $libelle, 
	        'quantite' => $quantite, 'idFournisseur' => $idFournisseur, 'idProjet' => $idProjet, 
	        'code' => $codeLivraison));
	        $livraisonManager = new LivraisonManager($pdo);
	        $livraisonManager->add($livraison);
	        $_SESSION['livraison-add-success']='<strong>Opération valide</strong> : La livraison est ajouté avec succès !';
			$_SESSION['livraison-detail-fill']='<strong>Détails livraisons</strong> : Ajoutez la liste des articles à votre livraison !';
	        $redirectLink = 'Location:../livraisons-details.php?codeLivraison='.$codeLivraison;
	        header($redirectLink);
    	}
	    else{
	    	$_SESSION['livraison-add-error'] = "<strong>Erreur Ajout Livraison</strong> : Vous devez remplir au moins les champs 'Libelle', 'Prix unitaire' et 'Quantité'.";
	        $redirectLink = 'Location:../livraison-add.php?idProjet='.$idProjet.'&idFournisseur='.$idFournisseur;
			if( isset($_GET['p']) and $_GET['p']==99 ){
				$redirectLink = 'Location:../livraisons2.php';
			}
	        header($redirectLink);
			exit;
    	}	
	}
	else{
		header('Location:../projet-list');
	}
    
    
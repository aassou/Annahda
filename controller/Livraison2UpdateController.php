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
    $idLivraison = $_POST['idLivraison'];
	$codeLivraison = $_POST['codeLivraison'];
    if( !empty($_POST['dateLivraison'])){
        $libelle = htmlentities($_POST['libelle']);    
        $dateLivraison = htmlentities($_POST['dateLivraison']);
        //CREATE NEW Livraison object
        $livraison = new Livraison(array('id' => $idLivraison, 
        'libelle' => $libelle, 'dateLivraison' => $dateLivraison));
        $livraisonManager = new LivraisonManager($pdo);
        $livraisonManager->update($livraison);
        $_SESSION['livraison--detail-update-success']='<strong>Opération valide</strong> : Les informations de la livraison sont modifiées avec succès.';
		$redirectLink = 'Location:../livraison.php?codeLivraison='.$codeLivraison;
		if( isset($_GET['p']) and $_GET['p']==99 ){
			$redirectLink = "Location:../livraisons2.php";
		}
        header($redirectLink);
    }
    else{
        $_SESSION['livraison-detail-update-error'] = "<strong>Erreur Modification Livraison</strong> : Vous devez remplir au moins les champs 'Libelle', 'Prix unitaire' et 'Quantité'.";
		$redirectLink = 'Location:../livraison.php?codeLivraison='.$codeLivraison;
        if( isset($_GET['p']) and $_GET['p']==99 ){
			$redirectLink = "Location:../livraisons2.php";
		}
        header($redirectLink);
    }
    
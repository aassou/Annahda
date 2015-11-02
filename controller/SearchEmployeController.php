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
    if(!empty($_POST['searchOption']) and !empty($_POST['search'])){
		$testRadio = 0;	    
		if(isset($_POST['searchOption'])){
			if($_POST['searchOption']=="searchByName"){
				$testRadio = 1;	
			}
			else if($_POST['searchOption']=="searchByCIN"){
				$testRadio = 2;	
			}
		}
		$recherche = htmlentities($_POST['search']);
		$employeManager = new EmployeProjetManager($pdo);
		$_SESSION['searchEmployeProjetResult'] = $employeManager->getEmployeProjetBySearch($recherche, $testRadio);
		header('Location:../employes-projet-search.php');
    }
    else{
        $_SESSION['employe-search-error'] = 
        "<strong>Erreur Recherche Employé</strong> : Vous devez séléctionner un choix 'Nom' ou 'CIN' 
        et 'Tapez votre recherche'";
		header('Location:../employes-projet-search.php');
    }
    
    
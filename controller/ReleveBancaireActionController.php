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
    include('../lib/image-processing.php');
    /****** Include the EXCEL Reader Factory ***********/
    //error_reporting(0);
    set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
    include ('Classes/PHPExcel/IOFactory.php');
    //classes loading end
    session_start();
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    //Component Class Manager
    $releveBancaireManager = new ReleveBancaireManager($pdo);
    $redirectLink = "";
	//Action Add Processing Begin
    if($action == "add"){
        $invalid = 0;
        if ( isset($_POST) && !empty($_FILES['excelupload']['name']) ) {
            //print_r($_FILES['excelupload']);
            $namearr = explode(".",$_FILES['excelupload']['name']);
            if ( end($namearr) != 'xls' && end($namearr) != 'xlsx' && end($namearr) != 'asp' && end($namearr) != 'aspx') {
                //echo '<p> Invalid File </p>';
                $invalid = 1;
                $actionMessage = "<strong>Erreur Ajout Releve Bancaire</strong> : Le type de fichier est incorrecte.";
                $typeMessage = "error";
            }
            if ( $invalid != 1 ) {
                $target_dir = "../uploads/";
                $target_file = $target_dir . basename($_FILES["excelupload"]["name"]);
                $response = move_uploaded_file($_FILES['excelupload']['tmp_name'],$target_file); // Upload the file to the current folder
                if ( $response ) {
                    try {
                        $objPHPExcel = PHPExcel_IOFactory::load($target_file);
                    } 
                    catch(Exception $e) {
                        die('Error : Unable to load the file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
                    }
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                    //print_r($allDataInSheet);
                    $arrayCount = count($allDataInSheet); // Total Number of rows in the uploaded EXCEL file
                    //echo $arrayCount;
                    $string = "INSERT INTO t_relevebancaire (dateOpe, dateVal, libelle, reference, debit, credit, projet) VALUES ";

                    for ( $i=1; $i<=$arrayCount; $i++ ) {
                        //$dateOpe= date('Y-m-d', strtotime(trim($allDataInSheet[$i]["B"])));
                        //$dateOpe = DateTime::createFromFormat('d/m/Y', trim($allDataInSheet[$i]["B"]));
                        //$dateOpe = $dateOpe->format('Y-m-d'); 
                        //$dateVal= date('Y-m-d', strtotime(trim($allDataInSheet[$i]["C"])));
                        //$dateVal = DateTime::createFromFormat('d/m/Y', trim($allDataInSheet[$i]["C"]));
                        //$dateVal = $dateVal->format('Y-m-d');
                        //echo $dateOpe.'&nbsp;&nbsp;';
                        //echo $dateVal.'<br>';
                        //echo $allDataInSheet[$i]["B"].'   ';
                        //echo $allDataInSheet[$i]["C"].'<br>';
                        //$date = DateTime::createFromFormat('d/m/Y', $allDataInSheet[$i]["B"]);
                        //echo $date->format('Y-m-d').'<br>';
                        //echo $date;
                        $dateOpe = trim($allDataInSheet[$i]["B"]);
                        $dateVal = trim($allDataInSheet[$i]["C"]);
                        $libelle = trim($allDataInSheet[$i]["D"]);
                        $reference = trim($allDataInSheet[$i]["E"]);
                        $debit = 0;
                        $credit = 0;
                        $projet = "_";
                        if ( strlen($allDataInSheet[$i]["F"]) > 0 ) {
                            $debit = trim($allDataInSheet[$i]["F"]);    
                        }
                        if ( strlen($allDataInSheet[$i]["G"]) > 0 ) {
                            $credit = trim($allDataInSheet[$i]["G"]);    
                        }
                        if ( strlen($allDataInSheet[$i]["H"]) > 0 ) {
                            $projet = trim($allDataInSheet[$i]["H"]);    
                        }
                        $string .= "( '".$dateOpe."' , '".$dateVal."' , '".$libelle."' , '".$reference."' , ".$debit." , ".$credit." , '".$projet."'),";
                    }
                    $string = substr($string,0,-1);
                    //print_r(utf8_decode($string));
                    //echo $string;
                    //mysql_query($string); // Insert all the data into one query
                    $pdo->query($string);
                    $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire Ajouté(e) avec succès.";  
                    $typeMessage = "success";
                }
            }// End Invalid Condition
        }         
        else{
            $actionMessage = "<strong>Erreur Ajout Releve Bancaire</strong> : Vous devez choisir un fichier.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idReleveBancaire = htmlentities($_POST['idReleveBancaire']);
        if(!empty($_POST['dateOpe'])){
			$dateOpe = htmlentities($_POST['dateOpe']);
			$dateVal = htmlentities($_POST['dateVal']);
			$libelle = htmlentities($_POST['libelle']);
			$reference = htmlentities($_POST['reference']);
			$debit = htmlentities($_POST['debit']);
			$credit = htmlentities($_POST['credit']);
			$projet = htmlentities($_POST['projet']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $releveBancaire = new ReleveBancaire(array(
				'id' => $idReleveBancaire,
				'dateOpe' => $dateOpe,
				'dateVal' => $dateVal,
				'libelle' => $libelle,
				'reference' => $reference,
				'debit' => $debit,
				'credit' => $credit,
				'projet' => $projet,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $releveBancaireManager->update($releveBancaire);
            $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Releve Bancaire</strong> : Vous devez remplir le champ <strong>Date Opération</strong>.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idReleveBancaire = htmlentities($_POST['idReleveBancaire']);
        $releveBancaireManager->delete($idReleveBancaire);
        $actionMessage = "<strong>Opération Valide</strong> : Releve Bancaire supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['releveBancaire-action-message'] = $actionMessage;
    $_SESSION['releveBancaire-type-message'] = $typeMessage;
    header('Location:../releve-bancaire.php');


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
    //classes loading end
    session_start();
    
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";

    //Component Class Manager

    $taskManager = new TaskManager($pdo);
	//Action Add Processing Begin
    	if($action == "add"){
        if( !empty($_POST['user']) ){
			$user = htmlentities($_POST['user']);
			$content = htmlentities($_POST['content']);
			$status = htmlentities($_POST['status']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $task = new Task(array(
				'user' => $user,
				'content' => $content,
				'status' => 0,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $taskManager->add($task);
            $actionMessage = "Opération Valide : Tâche Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout Tâche : Vous devez remplir le champ 'Description'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idTask = htmlentities($_POST['idTask']);
        if(!empty($_POST['user'])){
			$user = htmlentities($_POST['user']);
			$content = htmlentities($_POST['content']);
			$status = htmlentities($_POST['status']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            			$task = new Task(array(
				'id' => $idTask,
				'user' => $user,
				'content' => $content,
				'status' => $status,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $taskManager->update($task);
            $actionMessage = "Opération Valide : Tâche Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Tâche : Vous devez remplir le champ 'Desription'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action UpdateStatus Processing Begin
    else if($action == "updateStatus"){
        $idTask = htmlentities($_POST['idTask']);
        $status = htmlentities($_POST['status']);
        $updatedBy = $_SESSION['userMerlaTrav']->login();
        $updated = date('Y-m-d h:i:s');
        $task = new Task(array(
            'id' => $idTask,
            'status' => $status,
            'updated' => $updated,
            'updatedBy' => $updatedBy
        ));
        $taskManager->updateStatus($task);
        $actionMessage = "Opération Valide : Tâche Status Modifié(e) avec succès.";
        $typeMessage = "success";
    }
    //Action UpdateStatus Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idTask = htmlentities($_POST['idTask']);
        $taskManager->delete($idTask);
        $actionMessage = "Opération Valide : Tâche Supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    //Action Delete List Of Tasks Processing Begin
    else if($action == "deleteValideTasks"){
        $user = htmlentities($_POST['user']);
        $taskManager->deleteValideTasksByUser($user);
        $actionMessage = "Opération Valide : Tâches Supprimées avec succès.";
        $typeMessage = "success";
    }
    //Action Delete List Of Tasks Processing End
    $_SESSION['task-action-message'] = $actionMessage;
    $_SESSION['task-type-message'] = $typeMessage;
    header('Location:../tasks.php');


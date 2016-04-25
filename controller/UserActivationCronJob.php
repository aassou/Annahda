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
include("../config.php");
//classes loading end
session_start();

$laila = 7;
$tijani = 8;
$aassou = 11;
$userManager = new UserManager($pdo);
$status = $userManager->getStatusById($idUser);
if ( $status == 0 ) {
    $userManager->changeStatus(1, $aassou);
}
else {
    $userManager->changeStatus(0, $aassou);
}
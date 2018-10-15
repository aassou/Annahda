<?php
include('../autoload.php');
session_start();
if( isset($_SESSION['userMerlaTrav']) ){
    $contratManager = new ContratManager($pdo);
    $appatementManager = new AppartementManager($pdo);        
    //objs and vars
    $contratsIdBien = $contratManager->getContratActifIdBien();
    $appartements = $appatementManager->getAppartementsNoStatus();
    $index = 0;
    print_r($contratsIdBien);
    echo "<br>";
    foreach ( $appartements as $appartement ) {
        if ( in_array($appartement->id(), $contratsIdBien) ) {
            echo "Yes<br>";
            $appatementManager->changeStatus($appartement->id(), "Vendu");
            $index++;
        }
        else {
            echo "No<br>";
        }
    }
    echo $index."<br>";
}
    
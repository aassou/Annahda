<?php

try{
    $pdo = new PDO('mysql:host=db;dbname=annahda', 'root', 'test');
    //openssl encryption params
    $password = "iR0nM@N2017!?KOreVoNick";
    $method = "aes128";
    $iv = "69kjg23423L@cEv7";
    //numbers and floats camouflage
    $mutation = 123456789;
}
catch(Exception $e){
    die(sprintf('Can`t connect to database: %s', $e->getMessage()));
}
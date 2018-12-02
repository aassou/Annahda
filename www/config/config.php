<?php

try{
    $pdo = new PDO('mysql:host=db;dbname=db', 'user', 'pass');
    //openssl encryption params
    $password = "";
    $method = "";
    $iv = "";
    //numbers and floats camouflage
    $mutation = 123456;
}
catch(Exception $e){
    die(sprintf('Can`t connect to database: %s', $e->getMessage()));
}

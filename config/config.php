<?php
$pdo = new PDO('mysql:host=stock_db;dbname=stocki', 'root', 'test');
//openssl encryption params
$password = "iR0nM@N2017!?KOreVoNick";
$method = "aes128";
$iv = "69kjg23423L@cEv7";
//numbers and floats camouflage
$mutation = 123456789;
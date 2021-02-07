<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_database = "arms";

$dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_database .';charset=utf8mb4', ''.$db_user .'', ''.$db_pass .'', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

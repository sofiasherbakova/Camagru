<?php
    $host = 'localhost';
    $db   = 'camagru';
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8';
    $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    try {
        session_start();
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $opt);
    }
    catch(PDOException $err){
        die("Unable to connect to the Database :(");
    }

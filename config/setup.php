<?php
    include_once 'db.php';

    try {
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->query("CREATE DATABASE IF NOT EXISTS $DB_NAME");
        $pdo->query("use $DB_NAME");
        echo "Database '$DB_NAME' created successfully.<br>";
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                                    login VARCHAR(255) NOT NULL,
                                                    email VARCHAR(255) NOT NULL,
                                                    password VARCHAR(255) NOT NULL,
                                                    token VARCHAR(255) NOT NULL,
                                                    notification VARCHAR(5) NOT NULL)");


    } catch (PDOException $e) {
        echo $sql.'<br>'.$e->getMessage();
    }

    $dbh = null;
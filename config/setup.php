<?php

include_once 'db.php';

try {
	$pdo->exec("CREATE DATABASE IF NOT EXISTS $database");
	echo "Database '$database' created successfully.<br>";
	$pdo->exec("use $database");
	$pdo->exec("CREATE TABLE IF NOT EXISTS users (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                                  login VARCHAR(255) NOT NULL,
                                                  email VARCHAR(255) NOT NULL,
                                                  password VARCHAR(255) NOT NULL,
                                                  state VARCHAR(255) NOT NULL,
                                                  notific VARCHAR(5) NOT NULL)");
	echo "Table 'users' created successfully.<br>";
	$pdo->exec("CREATE TABLE IF NOT EXISTS snap  (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                                  login VARCHAR(255) NOT NULL,
                                                  img VARCHAR(255) NOT NULL)");
	echo "Table 'snap' created successfully.<br>";
	$pdo->exec("CREATE TABLE IF NOT EXISTS comments  (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                                  login VARCHAR(255) NOT NULL,
                                                  img_id VARCHAR(255) NOT NULL,
                                                  comment VARCHAR (255) NOT NULL)");
	echo "Table 'comments' created successfully.<br>";
	$pdo->exec("CREATE TABLE IF NOT EXISTS likes  (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                                  login VARCHAR(255) NOT NULL,
                                                  img_id VARCHAR(255) NOT NULL)");
	echo "Table 'likes' created successfully.<br>";
} catch (PDOException $e) {
	echo $sql.'<br>'.$e->getMessage();
}
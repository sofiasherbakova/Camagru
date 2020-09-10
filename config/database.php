<?php
  $DB_NAME = 'Camagru';
  $DB_DSN = 'mysql:host=127.0.0.1;';
  $DB_USER = 'ffood';
  $DB_PASSWORD = '1234';
  try {
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->query("use $DB_NAME");
  } catch (PDOException $e) {
    echo $sql.'<br>'.$e->getMessage();
}
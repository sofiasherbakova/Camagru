<?php
    if (!isset($_SESSION))
        session_start();
    include_once '../config/database.php';
    if (!$_SESSION['Username'] || empty($_SESSION['Username'])) 
    {
        header('Location: index.php?err=You must log in to do this');
        exit();
    }
    try {
      $sth = $dbh->prepare('SELECT COUNT(*) FROM likes WHERE login = :login AND image_id = :image_id');
      $sth->bindParam(':image_id', $_GET['image_id'], PDO::PARAM_INT);
      $sth->bindParam(':login', $_SESSION['Username'], PDO::PARAM_STR);
      $sth->execute();
    } 
    catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit;
    }
    if ($sth->fetchColumn()) 
    {
        try {
          $sth = $dbh->prepare('DELETE FROM likes WHERE login = :login AND image_id = :image_id');
          $sth->bindParam(':image_id', $_GET['image_id'], PDO::PARAM_INT);
          $sth->bindParam(':login', $_SESSION['Username'], PDO::PARAM_STR);
          $sth->execute();
        } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
            exit;
        }
    } 
    else {
        try {
            $sth = $dbh->prepare('INSERT INTO likes (login, image_id) VALUES (:login, :image_id)');
            $sth->bindParam(':image_id', $_GET['image_id'], PDO::PARAM_INT);
            $sth->bindParam(':login', $_SESSION['Username'], PDO::PARAM_STR);
            $sth->execute();
        } catch (PDOException $e) {
            echo 'Error: '.$e->getMessage();
            exit;
        }
    }
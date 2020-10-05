<?php
    if (!isset($_SESSION))
        session_start();
    include_once '../config/database.php';
    $id = intval($_GET['image_id']);
    $pdo = connect_to_database();
    $stmt = $pdo->prepare('SELECT * FROM images WHERE login = :login AND id = :id');
    $stmt->bindParam(':login', $_SESSION['user_login'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $photo = $stmt->fetch();
    if(isset($photo['image']))
    {
        unlink('../' . $photo['image']);
        $stmt = $pdo->prepare('DELETE FROM images WHERE login = :login AND id = :id');
        $stmt->bindParam(':login', $_SESSION['user_login'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ../gallery_page.php?page=1&err=Your photo has been delited\n");
    }
    else 
        header("Location: ../gallery_page.php?page=1&err=You have not rights to do this\n");
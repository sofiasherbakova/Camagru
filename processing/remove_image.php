<?php
    if (!isset($_SESSION))
        session_start();
    include_once '../config/database.php';
    $id = intval($_GET['image_id']);
    $pdo = connect_to_database();
    $stmt = $pdo->prepare('SELECT id FROM users WHERE login = :login');
    $params = [':login' => $_SESSION['user_login']];
    $stmt->execute($params);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    $user_id = $user->id;
    $stmt = $pdo->prepare('SELECT * FROM images WHERE user_id = :user_id AND id = :id');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $photo = $stmt->fetch();
    if(isset($photo['img_path']))
    {
        unlink('../' . $photo['img_path']);
        $stmt = $pdo->prepare('DELETE FROM images WHERE user_id = :user_id AND id = :id');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ../gallery_page.php?page=1&err=Your photo has been delited\n");
    }
    else 
        header("Location: ../gallery_page.php?page=1&err=You have not rights to do this\n");
<?php
    if (!isset($_SESSION))
        session_start();
    include_once '../config/database.php';
    $pdo = connect_to_database();
    $stmt = $pdo->prepare('DELETE FROM comments WHERE login = :login AND id = :comment');
    $stmt->bindParam(':login', $_SESSION['user_login'], PDO::PARAM_STR);
    $stmt->bindParam(':comment', $_GET['image_id'], PDO::PARAM_INT);
    $stmt->execute();

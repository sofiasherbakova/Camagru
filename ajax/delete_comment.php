<?php
    if (!isset($_SESSION))
        session_start();
    include_once '../config/database.php';

    if (isset($_POST['comment_id'])) 
    {
        $pdo = connect_to_database();
        $stmt = $pdo->prepare('SELECT id FROM users WHERE login = :login');
        $params = [':login' => $_SESSION['user_login']];
        $stmt->execute($params);
        $user = $stmt->fetch();

        $stmt = $pdo->prepare('DELETE FROM comments WHERE user_id = :user_id AND id = :comment_id');
        $stmt->bindParam(':user_id', $user['id'], PDO::PARAM_STR);
        $stmt->bindParam(':comment_id', $_POST['comment_id'], PDO::PARAM_INT);
        $stmt->execute();
    }
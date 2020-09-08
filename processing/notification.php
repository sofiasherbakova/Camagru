<?php
    require_once '../config/db.php';
    if (!isset($_SESSION))
        session_start();
    $sql = 'UPDATE users SET notification = NOT notification WHERE login = :login';
    $stmt = $pdo->prepare($sql);
    $params = ['login' => $_SESSION['user_login']];
    $stmt->execute($params);
<?php
    require_once '../config/database.php';
    if (!isset($_SESSION))
        session_start();
    $pdo = connect_to_database();
    $sql = 'UPDATE users SET notification = NOT notification WHERE login = :login';
    $stmt = $pdo->prepare($sql);
    $params = ['login' => $_SESSION['user_login']];
    $stmt->execute($params);
    header("Location: ../profile_page.php");
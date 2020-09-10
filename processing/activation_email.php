<?php
    require_once 'config/database.php';
    $login = $_GET['login'];
    $key = $_GET['key'];
    $sql = 'SELECT token, verified FROM users WHERE login = :login';
    $stmt = $pdo->prepare($sql);
    $params = ['login' => $login];
    $stmt->execute($params);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    if($key == $user->token) {
        $sql = 'UPDATE users SET token="", verified=1 WHERE login = :login';
        $stmt = $pdo->prepare($sql);
        $params = ['login' => $login];
        $stmt->execute($params);
    }
    header('Location: gallery.php');

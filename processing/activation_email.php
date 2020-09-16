<?php
    require_once '../config/database.php';
    if (!isset($_SESSION))
        session_start();
    $login = $_GET['login'];
    $key = $_GET['key'];
    $pdo = connect_to_database();
    $sql = 'SELECT token, verified FROM users WHERE login = :login';
    $stmt = $pdo->prepare($sql);
    $params = ['login' => $login];
    $stmt->execute($params);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    if ($key == $user->token) {
        $sql = 'UPDATE users SET token="", verified=1 WHERE login = :login';
        $stmt = $pdo->prepare($sql);
        $params = ['login' => $login];
        $stmt->execute($params);
        $_SESSION['user_login'] = $login;
        setcookie('login', $login);
        header('Location: ../gallery_page.php'); //добро пожаловать!
    }
    else
        header('Location: ../index.php?err=error!');
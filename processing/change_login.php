<?php
    require_once '../config/db.php';
    if (!isset($_SESSION))
        session_start();
    if (empty($_POST['login'])) {
        header("Location: ../index.php?err=Please, fill the form.\n");
        exit();
    }
    $login = $_POST['login'];
    $oldlogin = $_SESSION['user_login'];

    try {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
        $params = ['login' => $login];
        $stmt->execute($params);
    } 
    catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit;
    }
    if ($stmt->fetchColumn()) {
        header("Location: ../change.php?err=Login is already taken.\n");
        exit();
    }
    $sql = 'UPDATE users SET login = :new_login WHERE login = :old_login';
    $stmt = $pdo->prepare($sql);
    $params = ['new_login' => $login, 'old_login' => $login];
    $stmt->execute($params);

    $_SESSION['user_login'] = $login;
    header("Location: ../index.php?err=Your login has been correctly changed.\n");
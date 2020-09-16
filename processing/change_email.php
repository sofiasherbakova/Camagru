<?php
    require_once '../config/database.php';
    if (!isset($_SESSION))
        session_start();
    if (empty($_POST['email'])) {
        header("Location: ../profile_page.php?err=Please, fill in the blank.\n");
        exit();
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header("Location: ../profile_page.php?err=Invalid email format.\n");
        exit();
    }
    $email = $_POST['email'];
    $login = $_SESSION['user_login'];
    $pdo = connect_to_database();
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
    $params = ['email' => $email];
    $stmt->execute($params);

    if ($stmt->fetchColumn()) {
        header("Location: ../profile_page.php?err=An account with this email already exists.\n");
        exit();
    }
    $sql = 'UPDATE users SET email = :email WHERE login = :login';
    $stmt = $pdo->prepare($sql);
    $params = ['login' => $login, 'email' => $email];
    $stmt->execute($params);

    header("Location: ../profile_page.php?err=Your email has been correctly changed.\n");

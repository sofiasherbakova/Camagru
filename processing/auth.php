<?php
    require_once '../config/db.php';
    if (!isset($_SESSION))
        session_start();
    $title = "";
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);
    if(!empty($login) && !empty($password))
    {
        $sql = 'SELECT login, password FROM users WHERE login = :login';
        $params = [':login' => $login];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if($user && password_verify($password, $user->password)) {
            $_SESSION['user_login'] = $user->login;
            setcookie('login', $login);
            header('Location: ../gallery_page.php');
        }
        else
            echo 'Your login or password are not written correctly.';
    }
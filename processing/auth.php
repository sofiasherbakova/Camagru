<?php
    require_once '../config/database.php';
    if (!isset($_SESSION))
        session_start();
    $title = "";
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);
    if(!empty($login) && !empty($password))
    {
        $pdo = connect_to_database();
        $sql = 'SELECT login, password, verified FROM users WHERE login = :login';
        $params = [':login' => $login];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if ($user && password_verify($password, $user->password)) 
        {
            if (!$user->verified)
            {
                header("Location: ../index.php?err=Please, confirm your account\n");
                exit();
            }
            $_SESSION['user_login'] = $user->login;
            setcookie('login', $login);
            header('Location: ../gallery_page.php');
        }
        else
            header("Location: ../index.php?err=Your login or password are not written correctly\n");
    }
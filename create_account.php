<?php
    require_once 'config/db.php';

    $login = trim($_POST["login"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $password_r = trim($_POST["password_r"]);

    if(empty($login) || empty($email) || empty($password) || empty($password_r))
        echo 'Пожалуйста, заполните все поля';
    else if ($password != $password_r)
        echo 'Пароли не совпадают';
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        echo 'Invalid email format';
    else {
        //проверка логина
        $sql_check = 'SELECT EXISTS(SELECT login FROM users WHERE login = :login)';
        $stmt = $pdo->prepare($sql_check);
        $params = ['login' => $login];
        $stmt->execute($params);
        if($stmt->fetchColumn())
            die('Пользователь с таким логином уже существует');
        $token = md5('Secret_Word_CamaGru' . $login);     //генерирую уникальный токен
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users(login, email, password, token) VALUES(:login, :email, :password, :token)';
        $params = ['login' => $login, 'email' => $email, 'password' => $password, 'token' => $token];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        mail($email, 'Confirm the registration on Camagru', 'http://localhost/activation_email.php?login=$login&key=$token');
        header('Location: login_page.php');
    }




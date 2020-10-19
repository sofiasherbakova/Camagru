<?php
    require_once '../config/database.php';
    if (!isset($_SESSION))
        session_start();
        
    function clean_data($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $value = addslashes($value);
        return ($value);
    }

    $login = clean_data($_POST["login"]);
    $email = clean_data($_POST["email"]);
    $password = clean_data($_POST["password"]);
    $password_r = clean_data($_POST["password_r"]);
    
    if(empty($login) || empty($email) || empty($password) || empty($password_r))
        header("Location: ../reg_page.php?err=Please, fill in the blanks\n");
    else if ($password != $password_r)
        header("Location: ../reg_page.php?err=Passwords are not match\n");
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        header("Location: ../reg_page.php?err=Invalid email format\n");
    else if(!preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $password))
        header("Location: ../reg_page.php?err=Your password is too simple\n");
    else {
        //проверка логина
        $pdo = connect_to_database();
        $sql_check = 'SELECT EXISTS(SELECT login FROM users WHERE login = :login)';
        $stmt = $pdo->prepare($sql_check);
        $params = ['login' => $login];
        $stmt->execute($params);
        if($stmt->fetchColumn())
        {
            header("Location: ../reg_page.php?err=This login is already taken. Please, use different one\n");
            exit();
        }
        //проверка почты
        $sql_check = 'SELECT EXISTS(SELECT email FROM users WHERE email = :email)';
        $stmt = $pdo->prepare($sql_check);
        $params = ['email' => $email];
        $stmt->execute($params);
        if($stmt->fetchColumn())
        {
            header("Location: ../reg_page.php?err=An account with this email already exists\n");
            exit();
        }
        //генерирую уникальный токен
        $token = md5('Secret_Word_CamaGru' . $login);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users(login, email, password, token, notification, verified) VALUES(:login, :email, :password, :token, TRUE, FALSE)';
        $params = ['login' => $login, 'email' => $email, 'password' => $password, 'token' => $token];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $link ="To confirm your account, follow the link http://" .  $_SERVER['HTTP_HOST'] . '/processing/activation_email.php?login=' . $login . '&key=' . $token;
        mail($email, 'Confirm the registration on Camagru', $link);
        header('Location: ../index.php?err=You have successfully registered! To confirm your account, follow the link we sent to your email address');
    }


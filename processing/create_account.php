<?php
    require_once '../config/database.php';
    if (!isset($_SESSION))
        session_start();
    $login = trim($_POST["login"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $password_r = trim($_POST["password_r"]);

    if(empty($login) || empty($email) || empty($password) || empty($password_r))
        echo 'Please, fill in the blanks';
    else if ($password != $password_r)
        echo 'Passwords are not match';
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        echo 'Invalid email format';
    else {
        //проверка логина
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
            header("Location: ../reg_page.php?err=TAn account with this email already exists\n");
            exit();
        }
        //генерирую уникальный токен
        $token = md5('Secret_Word_CamaGru' . $login);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users(login, email, password, token, notification) VALUES(:login, :email, :password, :token, 1)';
        $params = ['login' => $login, 'email' => $email, 'password' => $password, 'token' => $token];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        mail($email, 'Confirm the registration on Camagru', 'http://localhost/activation_email.php?login=$login&key=$token');
        $_SESSION['user_login'] = $login;
        setcookie('login', $user_login);
        header('Location: ../gallery_page.php');
        //добавить аллерт с "добро пожаловать!"
    }


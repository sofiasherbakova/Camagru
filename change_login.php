<?php
    require_once 'config/db.php';

    if(change_login)
    {
        if(!empty($_POST["login"]))
        {
            //проверка существует или нет 
            $sql_check = 'SELECT EXISTS(SELECT login FROM users WHERE login = :login)';
            $stmt = $pdo->prepare($sql_check);
            $params = ['login' => $_POST["login"]];
            $stmt->execute($params);
            if($stmt->fetchColumn())
                die('Пользователь с таким логином уже существует');
            //замена 
            $sql = 'UPDATE users SET login = :new_login WHERE login = :old_login';
            $stmt = $pdo->prepare($sql);
            $params = ['old_login' => $_SESSION["user_login"], 'new_login' => $_POST["login"]];
            $stmt->execute($params);
        }
    }
    
    if(change_email)
    {
        if(!empty($_POST["email"]))
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                echo 'Invalid email format';
            //достаю старую почту
            $sql = 'SELECT email FROM users WHERE login = :login';
            $params = [':login' => $_SESSION['user_login']];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            //проверка существует или нет
            $sql_check = 'SELECT EXISTS(SELECT email FROM users WHERE email = :email)';
            $stmt = $pdo->prepare($sql_check);
            $params = ['email' => $user->email];
            $stmt->execute($params);
            if($stmt->fetchColumn())
                die('Пользователь с такой почтой уже зарегистрирован');
            //замена 
            $sql = 'UPDATE users SET email = :new_email WHERE email = :email';
            $stmt = $pdo->prepare($sql);
            $params = ['email' => $user->email, 'new_email' => $_POST["email"]];
            $stmt->execute($params);
        }
    }

    if(change_password)
    {
        if(!empty($_POST["old_password"] && $_POST["new_password"] && $_POST["repeat_password"]))
        {
            if ($_POST["new_password"] == $_POST["repeat_password"])
            {
            }
            //достаю старую почту
            $sql = 'SELECT email FROM users WHERE login = :login';
            $params = [':login' => $_SESSION['user_login']];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            //проверка существует или нет
            $sql_check = 'SELECT EXISTS(SELECT email FROM users WHERE email = :email)';
            $stmt = $pdo->prepare($sql_check);
            $params = ['email' => $user->email];
            $stmt->execute($params);
            if($stmt->fetchColumn())
                die('Пользователь с такой почтой уже зарегистрирован');
            //замена 
            $sql = 'UPDATE users SET email = :new_email WHERE email = :email';
            $stmt = $pdo->prepare($sql);
            $params = ['email' => $user->email, 'new_email' => $_POST["email"]];
            $stmt->execute($params);
        }
    }
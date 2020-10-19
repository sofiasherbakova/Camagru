<?php
    require_once '../config/database.php';
    if (empty($_POST['new_password']) || empty($_POST['repeat_password'])) 
    {
        header("Location: ../index.php?err=Please, fill in the blanks\n");
        exit();
    }
    function clean_data($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $value = addslashes($value);
        return ($value);
    }
    $hash = $_GET['hash'];
    $new_password = clean_data($_POST['new_password']);
    $repeat_password = clean_data($_POST['repeat_password']);
    if ($new_password != $repeat_password) {
        header("Location: ../index.php?err=Passwords are not match.\n");
        exit();
    }
    $pdo = connect_to_database();
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
    $params = ['login' => $_SESSION['user_login']];
    $stmt->execute($params);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    
    $sql = 'SELECT token FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $params = ['email' => $_GET['email']];
    $stmt->execute($params);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    if ($hash == $user->token) {
        $password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = 'UPDATE users SET token="", password = :new_password WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $params = ['email' => $_GET['email'], 'new_password' => $password];
        $stmt->execute($params);
        header("Location: ../index.php?err=Your password has been correctly changed.\n");
    }
    else
        header('Location: ../index.php?err=error!');

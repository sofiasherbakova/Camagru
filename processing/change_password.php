<?php
    require_once '../config/db.php';
    if (!isset($_SESSION))
        session_start();
    if (empty($_POST['old_password']) || empty($_POST['new_password']) || empty($_POST['repeat_password'])) 
    {
        header("Location: ../profile_page.php?err=Please, fill in the blanks\n");
        exit();
    }
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $repeat_password = $_POST['repeat_password'];
    try {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
        $params = ['login' => $_SESSION['user_login']];
        $stmt->execute($params);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
    } 
    catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        exit;
    }
    if ($new_password != $repeat_password) {
        header("Location: ../profile_page.php?err=Passwords are not match.\n");
        exit();
    }
    if (password_verify($old_password, $user->password)) {
        header("Location: ../profile_page.php?err=Password is not right.\n");
        exit();
    }
    $password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = 'UPDATE users SET password = :new_password WHERE login = :login';
    $stmt = $pdo->prepare($sql);
    $params = ['login' => $_SESSION['user_login'], 'new_password' => $password];
    $stmt->execute($params);

    header("Location: ../profile_page.php?err=Your password has been correctly changed.\n");
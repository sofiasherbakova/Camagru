<?php
    require_once '../config/database.php';
    if (!isset($_SESSION))
        session_start();
    if (empty($_POST['login'])) {
        header("Location: ../profile_page.php?err=Please, fill in the blank\n");
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

    $login = clean_data($_POST['login']);
    $old_login = $_SESSION['user_login'];
    $pdo = connect_to_database();
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
    $params = ['login' => $login];
    $stmt->execute($params);
    
    if ($stmt->fetchColumn()) {
        header("Location: ../profile_page.php?err=This login is already taken. Please, use different one\n");
        exit();
    }
    $sql = 'UPDATE users SET login = :new_login WHERE login = :old_login';
    $stmt = $pdo->prepare($sql);
    $params = ['new_login' => $login, 'old_login' => $old_login];
    $stmt->execute($params);

    $_SESSION['user_login'] = $login;
    header("Location: ../profile_page.php?err=Your login has been correctly changed.\n");
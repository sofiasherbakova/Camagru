<?php
    require_once '../config/database.php';
    if (!isset($_SESSION))
        session_start();
    if (isset($_SESSION['user_name'])) {
        header('Location: index.php');
        exit();
    }
    if (empty($_POST['email'])) {
        header("Location: ../index.php?err=Please, fill in the blank.\n");
        exit();
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?err=Invalid email format.\n");
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

    $email = clean_data($_POST["email"]);
    $pdo = connect_to_database();
    $stmt = $pdo->prepare('SELECT login FROM users WHERE email = :email');
    $params = [':email' => $email];
    $stmt->execute($params);
    if (!$user = $stmt->fetch()) {
        header("Location: ../index.php?err=Email address has not found\n");
        exit();
    }
    $hash = md5(rand(0, 1000));
    $stmt = $pdo->prepare("UPDATE users SET token = :hash WHERE login = :login");
    $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
    $stmt->bindParam(':login', $user['login'], PDO::PARAM_STR);
    $stmt->execute();
    $name = $user['login'];
    $subject = 'Camagru | Forgot password';
    $message = "Username: $name,
    Click on the following link to reactivate your account with a new password.
    http://" .  $_SERVER['HTTP_HOST'] . "/change_password.php?email=$email&hash=$hash";
    $headers = 'From:ffood@student.21-school.ru'."\r\n";
    mail($email, $subject, $message, $headers);
    header("Location: ../index.php?err=To change your password click on the link sent to your email.\n");
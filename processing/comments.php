<?php
    if (!isset($_SESSION))
        session_start();
    if (!$_SESSION['user_login'] || empty($_SESSION['user_login'])) {
        header('Location: index.php?err=You must log in to access this page.');
        exit();
    }
    if (empty($_POST['comment']) || empty($_GET['img_id'])) {
        header("Location: ../gallery_page.php?page=$_GET[page]");
        exit();
    }
    include_once '../config/database.php';
        header("Location: ../gallery_page.php?page=$_GET[page]");    
    $comment = trim($_POST['comment']);
    $comment = stripslashes($comment);
	$comment = strip_tags($comment);
	$comment = htmlspecialchars($comment);
	$comment = addslashes($comment);

    $pdo = connect_to_database();
    $stmt = $pdo->prepare('INSERT INTO comments (login, img_id, comment) VALUES (:login, :img_id, :comment)');
    $stmt->bindParam(':img_id', $_GET['img_id'], PDO::PARAM_INT);
    $stmt->bindParam(':login', $_SESSION['user_login'], PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->execute();
    
    $stmt = $pdo->prepare('SELECT users.mail FROM users INNER JOIN snap ON users.login = snap.login WHERE snap.id = :img_id AND notific = "1"');
    $stmt->bindParam(':img_id', $_GET['img_id'], PDO::PARAM_INT);
    $stmt->execute();

    $mail = $sth->fetchColumn();
    $to = $mail;
    $subject = 'Camagru | New comment';
    $message = "
    A new comment has been posted on your photo by : $_SESSION[user_login]
    Comment : $_POST[comment]"; 
    mail($to, $subject, $message);
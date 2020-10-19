<?php
    if (!isset($_SESSION))
        session_start();
    if (!$_SESSION['user_login'] || empty($_SESSION['user_login'])) {
        header('Location: index.php?err=You must log in to access this page.');
        exit();
    }
    if (empty($_POST['comment']) || empty($_GET['image_id'])) {
        header("Location: ../gallery_page.php?page=$_GET[page]");
        exit();
    }
    include_once '../config/database.php';  
    $comment = trim($_POST['comment']);
    $comment = stripslashes($comment);
	$comment = strip_tags($comment);
	$comment = htmlspecialchars($comment);
	$comment = addslashes($comment);
    $comment = substr($comment, 0, 100);

    $pdo = connect_to_database();
    $stmt = $pdo->prepare('SELECT id FROM users WHERE login = :login');
    $params = [':login' => $_SESSION['user_login']];
    $stmt->execute($params);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    $id = $user->id;
    $stmt = $pdo->prepare('INSERT INTO comments (user_id, img_id, comment) VALUES (:user_id, :img_id, :comment)');
    $stmt->bindParam(':img_id', $_GET['image_id'], PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->execute();
    
    $stmt = $pdo->prepare('SELECT users.email FROM users INNER JOIN images ON users.id = images.user_id WHERE images.id = :img_id AND notification = "1"');
    $stmt->bindParam(':img_id', $_GET['image_id'], PDO::PARAM_INT);
    $stmt->execute();

    $mail = $stmt->fetchColumn();
    $to = $mail;
    $subject = 'Camagru | New comment';
    $message = "A new comment has been posted on your photo by : $_SESSION[user_login]
    Comment : $_POST[comment]"; 
    mail($to, $subject, $message);

    header("Location: ../photo_page.php?image_id=$_GET[image_id]");
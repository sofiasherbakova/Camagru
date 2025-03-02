<?php
    if (!isset($_SESSION))
        session_start();
    include_once '../config/database.php';
    if (!$_SESSION['user_login'] || empty($_SESSION['user_login'])) 
    {
        header("Location: ../index.php?err=You must log in to do this\n");
        exit();
    }

    function getUserId($pdo, $login)
    {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE login = :login');
        $params = [':login' => $login];
        $stmt->execute($params);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        return $user->id;
    }

    function getCountLikes($pdo, $img)
    {
        $stmt = $pdo->prepare('SELECT * FROM likes WHERE img_id = :img_id');
        $stmt->bindParam(':img_id', $img, PDO::PARAM_INT);
        $stmt->execute();
        $likes = $stmt->fetchAll();
        $count = count($likes);
        return $count;
    }

    function isLiked($pdo, $img)
    {
        $id = getUserId($pdo, $_SESSION['user_login']);
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM likes WHERE user_id = :user_id AND img_id = :image_id');
        $stmt->bindParam(':user_id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':image_id', $img, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetchColumn()) 
            return TRUE;
        else 
            return FALSE;
    }

    if (isset($_POST['like']) && $_POST['like'] == 'get') 
    {
        header("Content-Type: application/json; charset=UTF-8");
        $response = new stdClass();
        $pdo = connect_to_database();
        $response->likes = getCountLikes($pdo, $_POST['image_id']);
        if (isLiked($pdo, $_POST['image_id']))
            $response->isLiked = true;
        else
            $response->isLiked = false;

        $json = json_encode($response);
        echo $json;
        return;
    }

    if (isset($_POST['like']) && $_POST['like'] == 'set') {
        header("Content-Type: application/json; charset=UTF-8");
        $response = new stdClass();
        $response->isLiked = false;
        $pdo = connect_to_database();
        $id = getUserId($pdo, $_SESSION['user_login']);
        if (!isLiked($pdo, $_POST['image_id'])) 
        {
            $response->isLiked = true;
            $stmt = $pdo->prepare('INSERT INTO likes (user_id, img_id) VALUES (:user_id, :image_id)');
            $stmt->bindParam(':user_id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':image_id', $_POST['image_id'], PDO::PARAM_INT);
            $stmt->execute();
        } 
        else 
        {
            $response->isLiked = false;
            $stmt = $pdo->prepare('DELETE FROM likes WHERE user_id = :user_id AND img_id = :image_id');
            $stmt->bindParam(':user_id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':image_id', $_POST['image_id'], PDO::PARAM_INT);
            $stmt->execute();
        }
        $response->likes = getCountLikes($pdo, $_POST['image_id']);
        $json = json_encode($response);
        echo $json;
        return;
    }

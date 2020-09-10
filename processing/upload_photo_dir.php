<?php
    if (!isset($_SESSION))
        session_start();
    include_once "../config/database.php";
    $dest_dir = "../uploads";
    $file = explode(".", $_FILES['image']['name']);
    $typefile = "." . $file[count($file) - 1];
    $time = mktime();
    $name = $_SESSION['user_login'] . $time . $typefile;
    $_SESSION['file'] = $name;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], "$dest_dir/$name");
    $image_name = "uploads/" . $name;
    $sql = 'INSERT INTO images(login, image) VALUES(:login, :image)';
    $stmt = $pdo->prepare($sql);
    $params = [':image' => $image_name, ':login' => $_SESSION['user_login']];
    $stmt->execute($params);
    header("Location: ". "../make_photo_page.php?err=Your photo has been uploaded!\n");

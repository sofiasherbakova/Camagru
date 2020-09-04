<?php
    if (!isset($_SESSION))
        session_start();
    if (!isset($_SESSION['user_login']))
    {
        header('Location: index.php');
        //добавить "сначала зарегистрируйтесь"
    }
        $title = "take photo";
    include_once "config/db.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
?>
<main>
    <div class="profile-container">
        <form action="add_photo.php" method="post" enctype="multipart/form-data">
            <input type="file" name="upload_img">
            <input type="submit" name="submit" value="Upload">
        </form>
    </div>
</main>
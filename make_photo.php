<?php
$title = '';
require_once './templates/_head.php';
require_once './templates/_header.php';
require_once 'config/db.php';
?>
<main>
    <div class="profile-container">
        <form action="add_photo_db.php" method="post">
            <input type="file" name="upload_img">
            <input type="submit" name="submit" value="Upload">
        </form>
    </div>
</main>
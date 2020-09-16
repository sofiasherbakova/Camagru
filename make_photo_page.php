<?php
    if (!isset($_SESSION))
        session_start();
    if (!isset($_SESSION['user_login']))
    {
        header('Location: index.php');
        //добавить "сначала зарегистрируйтесь"
    }
        $title = "take photo";
    include_once "config/database.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
?>
<script src="js/camera.js"></script>
    <main>
        <div class="profile-container">
            <form action="processing/upload_photo_dir.php" method="post" enctype="multipart/form-data">
                <input type="file" name="image">
                <input type="submit" name="submit" value="Upload">
            </form>
            <div class="contentarea">
                <div class="camera">
                    <video id="video">Video stream not available.</video>
                    <button id="startbutton">Take photo</button> 
                </div>
                <canvas id="canvas">
                </canvas>
                <div class="output">
                    <img id="photo" alt="The screen capture will appear in this box."> 
                </div>
            </div>
        </div>
    </main>
</body>
</html>
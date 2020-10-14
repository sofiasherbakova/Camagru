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
    
    if (isset($_POST['save']) && $_POST['save']) 
    {
        $pdo = connect_to_database();
        $stmt = $pdo->prepare('SELECT id FROM users WHERE login = :login');
        $params = [':login' => $_SESSION['user_login']];
        $stmt->execute($params);
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        $dest_dir = "../uploads";
        $time = mktime();
        $new_src = "uploads/" . $_SESSION['user_login'] . $time . '.png';
        file_put_contents($new_src, file_get_contents($_POST['src']));

        $sql = 'INSERT INTO images(img_path, user_id) VALUES(:image, :user_id)';
        $st = $pdo->prepare($sql);
        $params = [':image' => $new_src, ':user_id' => $user->id];
        $st->execute($params);
        //header("Location: ". "../make_photo_page.php?err=Your photo has been uploaded!\n");    
    }

    ?>
    <main>
    <div class="container">

        <div class="photo-upload">
            <label class="custom-file-upload">
                <p>Upload</p>
                <input id='file-upload' type="file">
            </label>

            <label class="custom-file-upload">
                <p>Camera</p>
                <input id="startbutton" type="button">
            </label>
        </div>

        <div class="photo-edit__canvas">
            <img id="preview" src="img/no_image.png" alt="preview">
            <img id="origin" src="img/no_image.png">
            <video id="video"></video>
            <canvas id="canvas"></canvas>
            <form><input type='button' id='snapshot' value="snapshot"></form>
        </div>

        <div class="photo-upload photo-upload-second">
            <label class="custom-file-upload">
                <p>Shoot</p>
                <input id='shoot' type="button">
            </label>
            <label id="discard" class="custom-file-upload">
                <p>Clear</p>
            </label>
        </div>

        <div class="photo-stickers">
            <div id="stick" class="photo-carousel">
                <div id="0" class="sticker"> <img class="carousel-item" src="img/School_21_logo-01.svg"></div>
                <div id="1" class="sticker"> <img class="carousel-item" src="img/School_21_logo-05.svg"></div>
                <div id="2" class="sticker"> <img class="carousel-item" src="img/School_21_logo-02.svg"></div>
            </div>
        </div>

        <form method="post" enctype="multipart/form-data">
            <input id="save" name="src" type="hidden" value="img/1.jpg">
            <input id="save_btn" class="button" name="save" type="submit" value="Save" disabled>
        </form>
    </div>
    </main>
    <?php include "./templates/_header.php"; ?>
    <script src="js/camera.js"></script>
</body>
</html>
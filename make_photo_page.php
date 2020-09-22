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
    
    if (isset($_POST['save']) && $_POST['save']) 
    {
        $dest_dir = "../uploads";
        $time = mktime();
        $new_src = "uploads/" . $_SESSION['user_login'] . $time . '.png';
        file_put_contents($new_src, file_get_contents($_POST['src']));

        $pdo = connect_to_database();
        $sql = 'INSERT INTO images(login, image) VALUES(:login, :image)';
        $stmt = $pdo->prepare($sql);
        $params = [':image' => $new_src, ':login' => $_SESSION['user_login']];
        $stmt->execute($params);
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
            <img id="preview" src="img/user.png" alt="preview">
            <img id="origin" src="img/1.jpg">
            <video id="video"></video>
            <canvas id="canvas"></canvas>
            <form><input type='button' id='snapshot' value="snapshot"></form>
        </div>

        <div class="photo-upload">
            <label class="custom-file-upload">
                <p>Shoot</p>
                <input id='shoot' type="button">
            </label>
            <label id="discard" class="custom-file-upload">
                <p>Clear</p>
            </label>
        </div>

        <form method="post" enctype="multipart/form-data">
            <input id="save" name="src" type="hidden" value="img/1.jpg">
            <input id="save_btn" class="btn-blue btn-save" name="save" type="submit" value="Save" disabled>
        </form>
    </div>
    </main>
    <script src="js/camera.js"></script>
</body>
</html>
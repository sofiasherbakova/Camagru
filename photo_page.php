<?php 
    if ($_GET['err'])
        echo "<script>alert(\"" . htmlentities($_GET['err']) . "\");window.location.href = \"gallery_page.php\";</script>";
    if (!isset($_SESSION))
        session_start();
    if (empty($_SESSION['user_login'])) 
        header("Location: ../photo_page.php?err=You must log in to do this\n");
    $title = "Photo";
    include_once "config/database.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
    //добавить условие если не существует фотка, то страница не найдена
?>
    <main>
        <div class="gallery">
            <?php
                $pdo = connect_to_database();
                $sql = 'SELECT * FROM images WHERE id = :id';
                $stmt = $pdo->prepare($sql);
                $params = [':id' => $_GET['image_id']];
                $stmt->execute($params);
                $photo = $stmt->fetch();
            ?>
                <div class="gallery-item">
                    <img class="gallery-image" src="<?php echo $photo['image']; ?>">
                    <div class="gallery-title"><?php echo $photo['login']; ?></div>
                    <input type="image" src="img/like.png" class="icon" id="like">
                    <div id="counter_likes"></div>
                </div> 
        </div>
    </main>
    <script src="js/like.js" type="text/javascript"></script>
</body>
</html>
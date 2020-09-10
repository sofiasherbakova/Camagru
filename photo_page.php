<?php 
    if (!isset($_SESSION))
        session_start();
    $title = "";
    include_once "config/database.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
    //добавить условие если не существует фотка, то страница не найдена
?>
    <main>
        <div class="photo-page">
            <?php
                $sql = 'SELECT * FROM images WHERE id = :id';
                $stmt = $pdo->prepare($sql);
                $params = [':id' => $_GET['image_id']];
                $stmt->execute($params);
                $photo = $stmt->fetch();
            ?>
                <div class="gallery-item">
                    <img class="gallery-image" src="<?php echo $photo['image']; ?>">
                    <div class="gallery-title"><?php echo $photo['login']; ?></div>
                    <img class="icon" src="img/like.png">
                </div> 
        </div>
    </main>
</body>
</html>
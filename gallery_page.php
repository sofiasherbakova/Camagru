<?php 
    if (!isset($_SESSION))
        session_start();
    $title = "";
    include_once "config/db.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
    $sql = 'SELECT * FROM images ORDER BY id DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $photos_array = $stmt->fetchAll();
?>
    <main>
        <div class="gallery">
            <?php 
            foreach ($photos_array as $value)
            {
            ?>
                <div class="gallery-item">
                    <img class="gallery-image" src="<?php echo $value['image']; ?>">
                    <div class="gallery-title"><?php echo $value['login']; ?></div>
                </div> 
            <?php
                }
            ?>
        </div>
    </main>
</body>
</html>

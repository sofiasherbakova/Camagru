<?php 
    if (!isset($_SESSION))
        session_start();
    if (!isset($_GET['page']))
        header("Location: ../gallery_page.php?page=1\n");
    $title = "Gallery";
    include_once "config/database.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
?>
    <main>
        <div class="gallery">
            <?php
                $pdo = connect_to_database();
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $limit = 6;
                $offset = $limit * ($page - 1);
                $sql = 'SELECT * FROM images';
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $pages = ceil($stmt->rowCount() / $limit);
                $sql = 'SELECT * FROM images ORDER BY id DESC LIMIT ' . $offset . ', '. $limit;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $photos_array = $stmt->fetchAll();
                if(!$photos_array)
                    echo "There are no photos yet :(";
                foreach ($photos_array as $value)
                {
            ?>
                <div class="gallery-item">
                    <a href='<?php echo "photo_page.php?image_id=" . $value['id'];?>'>
                        <img class="gallery-image" src="<?php echo $value['img_path']; ?>">
                    </a>
                </div> 
                <?php
            }
            ?>
            </div>
            <?php include "templates/_pagination.php"; ?>
    </main>
</body>
</html>

<?php 
    if (!isset($_SESSION))
        session_start();
    $title = "";
    include_once "config/database.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
?>
    <main>
        <div class="gallery">
            <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $limit = 6;
                $offset = $limit * ($page - 1);
                $sql = 'SELECT * FROM images ORDER BY id DESC LIMIT ' . $offset . ', '. $limit;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $photos_array = $stmt->fetchAll();
                foreach ($photos_array as $value)
                {
            ?>
                <div class="gallery-item">
    
                    <a href='<?php echo "photo_page.php?image_id=" . $value['id'];?>'>
                        <img class="gallery-image" src="<?php echo $value['image']; ?>">
                    </a>
                    <div class="gallery-title"><?php echo $value['login']; ?></div>
                    <img class="icon" src="img/like.png">
                </div> 
            <?php
            }
            $pages = 2;
            for ($i = 1; $i <= $pages; $i++) {
                echo "<a id='paginations' href='gallery_page.php?page=" . $i ."'>" . $i . "</a> ";
                }
            ?>
        </div>
        <select id="page-select">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
    </main>
    <script src="js/main.js" type="text/javascript"></script>
</body>
</html>


<form action="/processing/like.php" method="post">
    <button type="submit" class="button" name="OK">
        <img class="icon" src="img/like.png">
    </button>
</form>
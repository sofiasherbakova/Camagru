<?php 
    if (!isset($_SESSION))
        session_start();
    $title = "";
    include_once "config/db.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
?>
    <main>
        <select id="page-select">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
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

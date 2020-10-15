<?php
    if (!isset($_SESSION))
        session_start();
    if (!isset($_SESSION['user_login']))
        header('Location: index.php');
    if ($_GET['err'])
        echo "<script>alert(\"" . htmlentities($_GET['err']) . "\");window.location.href = \"profile_page.php\";</script>";
    $title = "my profile";
    include_once "config/database.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
?>
<main>
    <div class="profile-container">
        <div class="gallery">
             <?php
                $pdo = connect_to_database();
                $stmt = $pdo->prepare('SELECT id FROM users WHERE login = :login');
                $params = [':login' => $_SESSION['user_login']];
                $stmt->execute($params);
                $user = $stmt->fetch();
                $id = $user['id'];

                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $limit = 6;
                $offset = $limit * ($page - 1);
                $sql = 'SELECT * FROM images';
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $pages = ceil($stmt->rowCount() / $limit);
                $sql = 'SELECT * FROM images WHERE user_id = :id ORDER BY id DESC LIMIT ' . $offset . ', '. $limit;
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $id]);
                $photos_array = $stmt->fetchAll();
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

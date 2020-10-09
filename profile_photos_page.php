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
        <div class="profile-menu">
            <a href="profile_photos_page.php">Photos</a>
            <a href="profile_comments_page.php">Comments</a>
            <a href="profile_page.php">Settings</a>
            <form action="processing/logout.php" method="post">
                <button class="button-profile-menu" type="submit" name="OK">Log out</button>
            </form>
        </div>
        <div class="profile-settings">
            <?php
                $pdo = connect_to_database();
                $stmt = $pdo->prepare('SELECT id FROM users WHERE login = :login');
                $params = [':login' => $_SESSION['user_login']];
                $stmt->execute($params);
                $user = $stmt->fetch();
                $id = $user['id'];
                $sql = 'SELECT img_path, id FROM images WHERE user_id = :id';
                $params = [':id' => $id];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                $photos_array = $stmt->fetchAll();
                foreach ($photos_array as $value)
                {
            ?>
                <div class="">
                    <a href='<?php echo "photo_page.php?image_id=" . $value['id'];?>'>
                        <img class="gallery-image" src="<?php echo $value['img_path']; ?>">
                    </a>
                </div> 
                <?php
            }
            ?>
        </div>
    </div>
</main>
</body>
</html>

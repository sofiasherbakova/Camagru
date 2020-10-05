<?php 
    if (isset($_GET['err']))
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
        <div class="photo-container">
            <?php
                $pdo = connect_to_database();
                $sql = 'SELECT * FROM images WHERE id = :id';
                $stmt = $pdo->prepare($sql);
                $params = [':id' => $_GET['image_id']];
                $stmt->execute($params);
                $photo = $stmt->fetch();
            ?>
                <div class="gallery-item">
                    <form action=<?php echo 'processing/remove_image.php?image_id=' . $_GET['image_id']?> method='post'>
                        <input class='icon' type="image" alt='Delete photo' src="img/cancel.png">
                    </form>
                    <div class=""><?php echo $photo['login']; ?></div>
                    <img class="" src="<?php echo $photo['image']; ?>">
                    <input type="image" src="img/like.png" class="icon" id="like">
                    <span id="counter_likes"></span>
                </div> 
                <div class="comments">
                    <?php
                        $pdo = connect_to_database();
                        $sql = 'SELECT * FROM comments WHERE img_id = :img_id';
                        $stmt = $pdo->prepare($sql);
                        $params = [':img_id' => $_GET['image_id']];
                        $stmt->execute($params);
                        $comments = $stmt->fetchAll();
                        foreach ($comments as $comment)
                        {
                    ?>
                        <div class="one-comment">
                            <span class="user-login"><?php echo $comment['login']; ?></span>
                            <span class=""><?php echo $comment['comment']; ?></span>
                            <form action=<?php echo 'processing/remove_comment.php?image_id=' . $_GET['image_id']?> method='post'>
                                <input class='icon' type="image" alt='Delete photo' src="img/cancel.png">
                            </form>
                        </div>
                    <?php
                        }
                    ?>

                    <form action=<?php echo "processing/comments.php?image_id=". $_GET['image_id']?> method='post'>
                        <input class='' style='width:100%;' type='text' autocomplete='off' placeholder='Enter your comment' name='comment' required>
                        <button class='' type='submit'>Send</button>
                    </form>
            </div>
        </div>
    </main>
    <script src="js/like.js" type="text/javascript"></script>
</body>
</html>
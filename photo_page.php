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
                $st = $pdo->prepare('SELECT login FROM users WHERE id = :id');
                $params = [':id' => $photo['user_id']];
                $st->execute($params);
                $user = $st->fetch();
            ?>
                <div>
                <div class="header-photo">
                        <div class="login-photo"><?php echo $user['login']; ?></div>
                        <form action=<?php echo 'processing/remove_image.php?image_id=' . $_GET['image_id']?> method='post'>
                            <input class='delete-photo' type="image" alt='Delete photo' src="img/delete.png">
                        </form>
                    </div>
                    <div class="photo-image-block"><img class="photo-image" src="<?php echo $photo['img_path']; ?>"></div>
                    <div class="like-block">
                        <input type="image" src="img/like.png" class="like-image" id="like">
                        <div id="counter_likes"></div>
                    </div>
                </div> 
                <div class="right">
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
                            <span class="user-login">
                                <?php
                                    $stmt = $pdo->prepare('SELECT login FROM users WHERE id = :id');
                                    $params = [':id' => $comment['user_id']];
                                    $stmt->execute($params);
                                    $user = $stmt->fetch();
                                    echo $user['login']; 
                                ?>
                            </span>
                            <span class="text-comment"><?php echo $comment['comment']; ?></span>
                            <input class='icon delete' type="image" alt='Delete photo' src="img/delete.png" id="<?php echo $comment['id']?>">
                        </div>
                    <?php
                        }
                    ?>
                </div>
            <form class='comment-form' action=<?php echo "processing/comments.php?image_id=". $_GET['image_id']?> method='post'>
                <input class='comment-input' style='width:100%;' type='text' autocomplete='off' placeholder='Enter your comment' maxlength="100" name='comment' required>
                <button class='comment-button' type='submit'>Send</button>
            </form>
        </div>
    </main>
    <script src="js/like.js" type="text/javascript"></script>
    <script src="js/delete_comment.js" type="text/javascript"></script>
</body>
</html>
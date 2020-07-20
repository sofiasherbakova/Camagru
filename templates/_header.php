<?php require_once 'config/db.php'; ?>
<header>
        <div class="options">
            <div>
                <a href="index.php"><img src="img/logo.png" width="200" alt="logo"></a>
            </div>
            <div>
                <a class="site-navigation-link" title="gallery" href="index.php"><img class="icon" src="img/gallery.png" alt="gallery"></a>
                <a class="site-navigation-link" title="add photo" href="make_photo.php"><img class="icon" src="img/photo.png" alt="make photo"></a>
                <?php if (isset($_SESSION['user_login'])) {?>
                    <a class="site-navigation-link" title="my profile" href="profile.php"><img class="icon" src="img/user.png" alt="log in"></a>
                <?php } else {?>
                    <a class="site-navigation-link" title="log in" href="login_page.php"><img class="icon" src="img/user.png" alt="log in"></a>
                <?php }?>
            </div>
        </div>
</header>

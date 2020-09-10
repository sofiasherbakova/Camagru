<header>
        <div class="menu">
            <div>
                <a href="#"><img class="logo" src="img/logo.png" alt="logo"></a>
            </div>
            <div class="right-menu">
                <a title="gallery" href="gallery_page.php"><img class="icon" src="img/gallery.png" alt="gallery"></a>
                <a title="add photo" href="make_photo_page.php"><img class="icon" src="img/photo.png" alt="make photo"></a>
                <?php if (isset($_SESSION['user_login'])) {?>
                    <a title="my profile" href="profile_page.php"><img class="icon" src="img/user.png" alt="log in"></a>
                <?php } else {?>
                    <a title="log in" href="index.php"><img class="icon" src="img/user.png" alt="log in"></a>
                <?php }?>
            </div>
        </div>
</header>

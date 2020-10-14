<header>
        <div class="menu">
            <div>
                <a href="gallery_page.php?page=1"><img class="logo" src="img/logo.png" alt="logo"></a>
            </div>
            <ul class="right-menu">
                <li><a title="gallery" href="gallery_page.php?page=1"><img class="icon" src="img/gallery.png" alt="gallery"></a></li>
                    <li><a title="add photo" href="make_photo_page.php"><img class="icon" src="img/photo.png" alt="make photo"></a></li>
                <?php if (isset($_SESSION['user_login'])) {?>
                    <li>
                        <a title="my profile" href=""><img class="icon" src="img/user.png" alt="log in"><i class="fa fa-angle-down"></i></a>
                        <ul class="submenu">
                            <li><a href="profile_photos_page.php">My photo</a></li>
                            <li><a href="profile_page.php">My settings</a></li>
                            <li><a href="../processing/logout.php">Log out</a></li>
                        </ul>
                    </li>
                <?php } else {?>
                    <li><a title="log in" href="index.php"><img class="icon" src="img/user.png" alt="log in"></a></li>
                <?php }?>
            </ul>
        </div>
</header>

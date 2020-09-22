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
            <form action="processing/change_login.php" method="post" class="profile-settings-list">
                <div>Your login: <?php echo $_SESSION['user_login']?></div>
                <input type="text" placeholder="New login" name="login">
                <button type="submit" name="change_login">Change</button>
            </form>
            <?php
                $pdo = connect_to_database();
                $sql = 'SELECT email, notification FROM users WHERE login = :login';
                $params = [':login' => $_SESSION['user_login']];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                $user = $stmt->fetch(PDO::FETCH_OBJ);
            ?>
            <form action="processing/change_email.php" method="post" class="profile-settings-list">
                <div>Your email: <?php echo $user->email?> </div>
                <input type="text" placeholder="New email" name="email">
                <button type="submit" name="OK">Change</button>
            </form>
            <form action="processing/change_password.php" method="post" class="profile-settings-list">
                <div>Password</div>
                <input type="password" placeholder="Old password" name="old_password">
                <input type="password" placeholder="New password" name="new_password">
                <input type="password" placeholder="Repeat password" name="repeat_password">
                <button type="submit" name="OK">Change</button>
            </form>
            <form action="processing/notification.php" method="post" class="profile-settings-list">
                <div>Notifications: <?php if ($user->notification) echo "on"; else echo "off";?></div>
                <button type="submit" name="OK">Change</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>

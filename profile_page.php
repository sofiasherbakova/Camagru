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
        <div class="profile-settings">
            <form action="processing/change_login.php" method="post" class="profile-settings-list">
                <div><strong>Your login: </strong><?php echo $_SESSION['user_login']?></div>
                <input class="profile-input" type="text" placeholder="New login" name="login" autocomplete='off' required>
                <button class="profile-button" type="submit" name="change_login">Change</button>
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
                <div><strong>Your email:</strong> <?php echo $user->email?> </div>
                <input class="profile-input" type="text" placeholder="New email" name="email" autocomplete='off' required>
                <button class="profile-button" type="submit" name="OK">Change</button>
            </form>
            <form action="processing/change_password.php" method="post" class="profile-settings-list">
                <div><strong>Password</strong></div>
                <div>
                    <input class="profile-input" type="password" placeholder="Old password" name="old_password" autocomplete='off' required>
                    <input class="profile-input" type="password" placeholder="New password" name="new_password" autocomplete='off' required>
                    <input class="profile-input" type="password" placeholder="Repeat password" name="repeat_password" autocomplete='off' required>
                </div> 
                <button class="profile-button" type="submit" name="OK">Change</button>
            </form>
            <form action="processing/notification.php" method="post" class="profile-settings-list">
                <div><strong>Notifications: </strong><?php if ($user->notification) echo "on"; else echo "off";?></div>
                <button class="profile-button" type="submit" name="OK">Change</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>

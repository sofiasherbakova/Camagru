<?php
    $title = "";
    require_once 'config/db.php';
    include("./templates/_head.php");
    include("./templates/_header.php");
?>
<main>
    <div class="profile-container">
        <div class="profile-menu">
            <a href="#">Photos</a>
            <a href="#">Comments</a>
            <a href="#">Settings</a>
            <form action="logout.php" method="post">
                <button class="button-profile-menu" type="submit" name="OK">Log out</button>
            </form>
        </div>
        <div class="profile-settings">
            <form action="change_login.php" method="post" class="profile-settings-list">
                <div>Your login: <?php echo $_SESSION['user_login']?></div>
                <input type="text" placeholder="New login" name="login">
                <button type="submit" name="change_login">Change</button>
            </form>
            <?php
                $sql = 'SELECT email FROM users WHERE login = :login';
                $params = [':login' => $_SESSION['user_login']];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                $user = $stmt->fetch(PDO::FETCH_OBJ);
            ?>
            <form action="change_email.php" method="post" class="profile-settings-list">
                <div>Your email: <?php echo $user->email?> </div>
                <input type="text" placeholder="New email" name="email">
                <button type="submit" name="OK">Change</button>
            </form>
            <form action="change_password.php" method="post" class="profile-settings-list">
                <div>Password</div>
                <input type="text" placeholder="Old password" name="login">
                <input type="text" placeholder="New password" name="login">
                <input type="text" placeholder="Repeat password" name="login">
                <button type="submit" name="OK">Change</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>

<?php
    $title = "";
    include("./templates/_head.php");
    include("./templates/_header.php");
    require_once 'config/db.php';
?>
<main>
    <div class="menu">
        <a href="#">My photos</a>
        <a href="#">My comments</a>
        <a href="#">My settings</a>
        <form action="logout.php" method="post">
            <button type="submit" name="OK">LOG OUT</button>
        </form>
    </div>
    <div class="login-form">
        <form action="change_login.php" method="post">
            <div>Your login: <?php echo $_SESSION['user_login']?></div>
            <input type="text" placeholder="New login" name="login">
            <button type="submit" name="OK">Change</button>
        </form>
        <?php
            $sql = 'SELECT email FROM users WHERE login = :login';
            $params = [':login' => $_SESSION['user_login']];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
        ?>
        <form action="change_email.php" method="post">
            <div>Your email: <?php echo $user->email?> </div>
            <input type="text" placeholder="New email" name="email">
            <button type="submit" name="OK">Change</button>
        </form>

        <form action="change_password.php" method="post">
            <div>Password</div>
            <input type="text" placeholder="Old password" name="login">
            <input type="text" placeholder="New password" name="login">
            <input type="text" placeholder="Repeat password" name="login">
            <button type="submit" name="OK">Change</button>
        </form>
    </div>
</main>
</body>
</html>

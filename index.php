<?php
    if ($_GET['err'])
    {
        echo "<script>alert(\"" . htmlentities($_GET['err']) . "\");window.location.href = \"index.php\";</script>";
    }
    if (!isset($_SESSION))
        session_start();
    if (isset($_SESSION['user_login']))
        header('Location: gallery_page.php');
    $title = "Главная";
    include_once "config/database.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
?>
    <img src="img/back.jpg" class="back">
    <main>
        <div class="container">
            <form action="processing/auth.php" method="post" class="login-form">
                <div>Glad to see you!</div>
                <input type="text" class="input" placeholder="Your login" name="login">
                <input type="password" class="input" placeholder="Your password" name="password">
                <button type="submit" class="button" name="OK">Log in</button>
                <div class="form-text">No account? <a class="form-link" href="reg_page.php">Create one!</a></div>
            </form>
        </div>
    </main>
    <?php
        include("./templates/_footer.php");
    ?>
</body>
</html>

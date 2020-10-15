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
?>
    <!DOCTYPE html>
    <html class="login-container">
        <head>
            <meta charset="UTF-8">
            <title><?php echo $title; ?></title>
            <link rel="stylesheet" href="css/style.css">
        </head>
    <body>
<?php
    include "./templates/_header.php";
?>
    <main>
        <div>
            <form action="processing/auth.php" method="post" class="login-form">
                <div>Glad to see you!</div>
                <input type="text" class="input" placeholder="Your login" name="login" autocomplete="off" required>
                <input type="password" class="input" placeholder="Your password" name="password" required>
                <button type="submit" class="button" name="OK">Log in</button>
                <div class="form-text">No account? <a class="form-link" href="reg_page.php">Create one!</a></div>
            </form>
        </div>
        <?php
            include("./templates/_footer.php");
        ?>
    </main>
</body>
</html>

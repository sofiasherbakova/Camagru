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
            <link rel="stylesheet" href="css/media.css">
            <link rel="icon" href="/favicon.png" type="image/png">
        </head>
    <body>
<?php
    include "./templates/_header.php";
?>
    <main>
        <div>
            <form action="<?php echo 'processing/reset_password.php?email=' . $_GET['email'] . '&hash=' . $_GET['hash']?>" method="post" class="login-form">
                <div>Change password</div>
                    <input class="input" type="password" placeholder="New password" name="new_password" autocomplete='off' required>
                    <input class="input" type="password" placeholder="Repeat password" name="repeat_password" autocomplete='off' required>
                    <button class="profile-button" type="submit" name="OK">Change</button>
                    <div class="form-text"><a class="form-link" href="index.php">Back</a></div>
            </form>
        </div>
        <?php
            include("./templates/_footer.php");
        ?>
    </main>
</body>
</html>

<?php
    if ($_GET['err'])
    {
        echo "<script>alert(\"" . htmlentities($_GET['err']) . "\");window.location.href = \"reg_page.php\";</script>";
    }
    if (!isset($_SESSION))
        session_start();
    $title = "register";
    include_once "config/database.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
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
        <form action="/processing/create_account.php" method="post" class="login-form">
            <input type="text" class="input" placeholder="Your name" name="login">
            <input type="text" class="input" placeholder="Your email" name="email">
            <input type="password" class="input" placeholder="Password" name="password">
            <input type="password" class="input" placeholder="Repeat the password" name="password_r">
            <button type="submit" class="button" name="OK">Create account</button>
            <div class="form-text"><a href="index.php">Back</a></div>
        </form>
    </main>
</body>
</html>

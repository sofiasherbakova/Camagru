<?php 
    if (!isset($_SESSION))
        session_start();
    $title = "register";
    include_once "config/db.php";
    include "./templates/_head.php";
    include "./templates/_header.php";
?>
    <main>
        <img src="img/back.jpg" class="back">
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

<?php
	$title = "Главная";
	include("./templates/_head.php");
    include("./templates/_header.php");
    require_once 'config/db.php';
?>
    <img src="img/back.jpg" class="back">
    <main>
        <div class="container">
            <form action="auth.php" method="post" class="login-form">
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

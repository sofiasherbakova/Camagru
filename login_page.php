<?php 
	$title = "";
	include("./templates/_head.php");
    include("./templates/_header.php");
    require_once 'config/db.php';
?>
    <main>
        <form action="auth.php" method="post" class="login-form">
            <input type="text" class="input" placeholder="Your login" name="login">
            <input type="password" class="input" placeholder="Your password" name="password">
            <button type="submit" class="input" name="OK">Log in</button>
            <h3><a href="reg_page.php">Create account</a></h3>
        </form>
    </main>
</body>
</html>

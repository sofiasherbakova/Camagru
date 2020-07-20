<?php 
	$title = "";
	include("./templates/_head.php");
    include("./templates/_header.php");
?>
    <main>
        <form action="create_account.php" method="post" class="login-form">
            <input type="text" class="input" placeholder="Your name" name="login">
            <input type="text" class="input" placeholder="Your email" name="email">
            <input type="password" class="input" placeholder="Password" name="password">
            <input type="password" class="input" placeholder="Repeat the password" name="password_r">
            <button type="submit" class="input" name="OK">Create account</button>
            <h3><a href="login_page.php">Back</a></h3>
        </form>
    </main>
</body>
</html>

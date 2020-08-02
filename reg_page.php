<?php 
	$title = "";
	include("./templates/_head.php");
    include("./templates/_header.php");
?>
    <main>
        <img src="img/back.jpg" class="back">
        <form action="create_account.php" method="post" class="login-form">
            <input type="text" class="input" placeholder="Your name" name="login">
            <input type="text" class="input" placeholder="Your email" name="email">
            <input type="password" class="input" placeholder="Password" name="password">
            <input type="password" class="input" placeholder="Repeat the password" name="password_r">
            <button type="submit" class="button" name="OK">Create account</button>
            <div class="form-text"><a href="gallery.php">Back</a></div>
        </form>
    </main>
</body>
</html>

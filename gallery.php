<?php 
	$title = "";
	include("./templates/_head.php");
    include("./templates/_header.php");
    require_once 'config/db.php';
    $sql = 'SELECT * FROM images ORDER BY id DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $gallery = $stmt->fetchAll();
?>
    <main>
        <div class="gallery">
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
            <div class="gallery-item">
                <img class="gallery-image" src="img/1.jpg">
                <div class="gallery-title">username</div>
            </div>
        </div>
    </main>
</body>
</html>

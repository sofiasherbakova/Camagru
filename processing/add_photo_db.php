<?php
    require_once 'config/db.php';
    if (isset($_FILES['upload_img']['tmp_name'])) {
        $sql = 'INSERT INTO images(image, username) VALUES(:image, :username)';
        $stmt = $pdo->prepare($sql);
        $file = file_get_contents($_FILES['upload_img']['tmp_name']);
        $params = [':image' => $file, ':username' => $_SESSION['login']];
        $stmt->execute($params);
    }

    /*
     *
  function file_download($file) 
  {
	  if (file_exists($file)) {
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
	// если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
    exit;
  }
}
     *
     */
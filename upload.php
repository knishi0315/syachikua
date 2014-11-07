<?php
// 画像アップロードと移動
$image_dir = '/var/www/html/files/';
$file = $_FILES['upfile'];
if (is_uploaded_file($file['tmp_name'])) {
    move_uploaded_file($file['tmp_name'], $image_dir . $file['name']);
}
echo $_FILE["input_name"]["error"];
phpinfo();


?>

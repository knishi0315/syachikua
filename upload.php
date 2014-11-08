<?php
// 画像アップロードと移動
$image_dir = './files/';
$file = $_FILES['upfile'];
if (is_uploaded_file($file['tmp_name'])) {
    move_uploaded_file($file['tmp_name'], $image_dir . $file['name']);
    header("Location: result.php?file=". $file['name']);
}
?>

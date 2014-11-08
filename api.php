<?php
error_reporting(-1);
require_once dirname(__FILE__).'/unirest-php/lib/Unirest.php';

function joushiToImout($filename) {
  // debug.
  // $filename = "ojisan.jpg";
  // $img_url = "http://stat.ameba.jp/user_images/20120703/12/iruka-blog/3a/90/j/o0400026612060016584.jpg";
  // $path = "ojisan.jpg";
  $path = "files/".$filename;
  $img_url = "http://orenojs.ddo.jp/files/".$filename;

  $response = Unirest::get("https://faceplusplus-faceplusplus.p.mashape.com/detection/detect?attribute=glass,pose,gender,age,race,smiling&url=" . $img_url,
    array(
      "X-Mashape-Key" => "K74HWn5JLsmsh6Xrnh6FHDYPI2jzp18pxOpjsnnaIgcHRpvNCc"
    )
  );

  $eye_left_x = $response->body->face[0]->position->eye_left->x;
  $eye_left_y = $response->body->face[0]->position->eye_left->y;
  $eye_right_x = $response->body->face[0]->position->eye_right->x;
  $eye_right_y = $response->body->face[0]->position->eye_right->y;
  $face_width = $response->body->face[0]->position->width;
  $face_height = $response->body->face[0]->position->height;
  $face_center_x = $response->body->face[0]->position->center->x;
  $face_center_y = $response->body->face[0]->position->center->y;

  list($width_base, $height_base) = getimagesize($path);

  $face_width = $width_base * ($face_width / 100);
  $face_height = $height_base * ($face_height / 100);
  $face_center_x = $width_base * ($face_center_x / 100);
  $face_center_y = $height_base * ($face_center_y / 100);

  //extention of joushi image.
  $path_splitted = explode(".", $path);
  $ext = $path_splitted[count($path_splitted) - 1];
  switch($ext) {
    case 'png':
      $base_image = imagecreatefrompng($path);
      break;
    case 'gif':
      $base_image = imagecreatefromgif($path);
      break;
    case 'jpg':
      $base_image = imagecreatefromjpeg($path);
      break;
    case 'jpeg':
      $base_image = imagecreatefromjpeg($path);
      break;
    default:
      break;
  }
  $kami_path = "nekomimi.png";
  $kami = imagecreatefrompng($kami_path);
  
  // scale kami to face_width * 1.2
  list($width_kami, $height_kami) = getimagesize($kami_path);
  $new_width_kami = $face_width * 1.6;
  $new_height_kami = $height_kami * ( $new_width_kami / $width_kami);
  $scaled_kami = imagecreatetruecolor($width_base, $height_base);
  $alpha = imagecolortransparent($kami);
  imagefill($scaled_kami, 0, 0, $alpha);
  imagecolortransparent($scaled_kami, $alpha);
  imagecolortransparent($base_image, $alpha);
  imagecopyresampled($scaled_kami, $kami, 0, 0, 0, 0, $new_width_kami, $new_height_kami, $width_kami, $height_kami);

 
  $result = imagecopy($base_image, $scaled_kami, $face_center_x - ($new_width_kami / 2), $face_center_y - ($new_height_kami / 2) + $face_center_y * 0.1, 0, 0, $width_base, $height_base);
  
  imagepng($base_image, "files2/".$filename);

  imagedestroy($kami);
  imagedestroy($scaled_kami);
  imagedestroy($base_image);

  return $result;
}

?>


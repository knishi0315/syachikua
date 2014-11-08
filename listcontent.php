<div class="col-md-10">
<?php

//ディレクトリ・ハンドルをオープン
$res_dir = opendir( './files' );

//ディレクトリ内のファイル名を１つずつを取得
while( $file_name = readdir( $res_dir ) ){

  if ($file_name == ".") {
    echo "";
  } elseif ($file_name == "..") {
    echo "";
  } else {
        //取得したファイル名を表示
        print "<img src=./files2/{$file_name} alt={$file_name} class=img-responsive img-rounded><br>\n";
  }

}
//ディレクトリ・ハンドルをクローズ
closedir( $res_dir );

?>
</div>

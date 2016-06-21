<?php

$sql = sprintf('SELECT * FROM `events` WHERE `organizer_id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
  );
$record = mysqli_query($db, $sql) or die (mysqli_error($db));
$event = mysqli_fetch_assoc($record); 

$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
  );
$record = mysqli_query($db, $sql) or die (mysqli_error($db));
$user = mysqli_fetch_assoc($record); 

//Cropボタンが押された時
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
//DBからprifile_picture_pathを呼び出し変数に格納
  $filename = 'users/profile_pictures/'.$user['profile_picture_path'].'';

//呼び出した写真のサイズを取得（$with、$heightへ格納）
  list($width,$height) = getimagesize($filename);

//新規サイズを指定し$newwidth,$newheightへ格納
  $newwidth = 480;
  $newheight =$height*(480/$width);

//読み込み
  $thumb = ImageCreateTrueColor($newwidth, $newheight);
  $source = imagecreatefromjpeg($filename);

//リサイズ実行
  imagecopyresized($thumb,$source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

//クロッピング
  $targ_w = 150;
  $targ_h = 150;
  $jpeg_quality = 90;
  $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
  imagecopyresampled($dst_r,$thumb,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);

//クロッピングされた画像にファイル名をつけて保存
  imagejpeg($dst_r,'users/profile_pictures/profile_cropped_picture'.$_SESSION['id'].'', $jpeg_quality);

//アップロード処理
  $sql = sprintf('UPDATE `users` SET `profile_picture_path`="%s", modified = NOW() WHERE `id`=%d',
    mysqli_real_escape_string($db, 'profile_cropped_picture'.$_SESSION['id'].''),
    mysqli_real_escape_string($db, $_SESSION['id'])
    );

//SQL文実行
  mysqli_query($db, $sql) or die(mysqli_error($db));
  header('Location:show');
  exit;

}

?>

<div class="container">
  <div class="row">
    <div class="span12">
      <div class="jc-demo-box">

        <div class="page-header">
          <h1>Crop your profile photo</h1>
        </div>
        <!-- This is the image we're attaching Jcrop to -->
        <img src="../users/profile_pictures/<?php echo $user['profile_picture_path'] ?>" id="cropbox" width="480px">

        <!-- This is the form that our event handler fills-->
        <form action="" method="post" onsubmit="return checkCoords();" enctype="multipart/form-data">
          <input type="hidden" id="x" name="x">
          <input type="hidden" id="y" name="y">
          <input type="hidden" id="w" name="w">
          <input type="hidden" id="h" name="h">
          <input type="submit" href="show" value="Crop Image" class="btn btn-large btn-inverse">
        </form>

        <p>
          <b>If you press the <i>Crop Image</i>
            button, a 150x150 profile photo will be submitted. 
        </p>
      </div>
    </div>
  </div>
</div>

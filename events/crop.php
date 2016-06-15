<?php

$sql = sprintf('SELECT * FROM `events` WHERE `organizer_id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
      );
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $event = mysqli_fetch_assoc($record); 
    // var_dump($event);
    // var_dump($_SESSION);



if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  //(付け足し)https://secure.php.net/manual/ja/function.imagecopyresized.php
  //ファイルと新規サイズ
//  $filename = 'webroot/assets/images/cala.jpg';
  list($width,$height) = getimagesize($filename);
  //新規サイズを取得します
  $newwidth = 1000;
  $newheight =$height*(1000/$width);
  //読み込み
  $thumb = ImageCreateTrueColor($newwidth, $newheight);
  $source = imagecreatefromjpeg($filename);
  //リサイズ
  imagecopyresized($thumb,$source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
  //リサイズした画像の保存
  // imagejpeg($thumb,'webroot/assets/images/'.$event['event_name'].'.jpg', $jpeg_quality);

  //クロッピング
    $targ_w = 1000;
    $targ_h = 500;
    $jpeg_quality = 90;
    // $src = 'webroot/assets/images/mali.jpg';
    // $img_r = imagecreatefromjpeg($thumb);
    $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
    imagecopyresampled($dst_r,$thumb,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);

    header('Content-type: image/jpeg');
    // imagejpeg($dst_r,null,$jpeg_quality);
    imagejpeg($dst_r,'webroot/assets/images/'.$event['event_name'].'.jpg', $jpeg_quality);

    exit;
}

// If not a POST request, display page below:
?>

<div class="container">
<div class="row">
<div class="span12">
<div class="jc-demo-box">

<div class="page-header">
<ul class="breadcrumb first">
  <li><a href="../index.html">Jcrop</a> <span class="divider">/</span></li>
  <li><a href="../index.html">Demos</a> <span class="divider">/</span></li>
  <li class="active">Live Demo (Requires PHP)</li>
</ul>
<h1>Server-based Cropping Behavior</h1>
</div>

    <!-- This is the image we're attaching Jcrop to -->
    <img src="" id="cropbox" width="1000px" style="display:none;">

    <!-- This is the form that our event handler fills -->
    <form action="crop" method="post" onsubmit="return checkCoords();" enctype="multipart/form-data">
      <input type="hidden" name="MAX_FILE_SIZE" value="5120">
      <input type="file" name="picture" id="picture">
      <input type="hidden" id="x" name="x">
      <input type="hidden" id="y" name="y">
      <input type="hidden" id="w" name="w">
      <input type="hidden" id="h" name="h">
      <input type="submit" value="Crop Image" class="btn btn-large btn-inverse">
    </form>

    <p>
      <b>An example server-side crop script.</b> Hidden form values
      are set when a selection is made. If you press the <i>Crop Image</i>
      button, the form will be submitted and a 150x150 thumbnail will be
      dumped to the browser. Try it!
    </p>


  </div>
  </div>
  </div>
  </div>

  <script>


 $('#picture').change(function(){
 //実際に画像のプレビューを行う関数
     var file = $(this).prop('files')[0];
     //png, jpg, jpegのどれにも一致しない場合注意文を表示
     if ( file.type == 'image/png' || file.type == 'image/jpg' || file.type == 'image/jpeg') {
         //空のimgタグにプレビューを挿入
         var fr = new FileReader();
         fr.onload = function() {
             $('#cropbox').attr('src', fr.result ).css('display','inline');
         }
         fr.readAsDataURL(file);
       }
     });
       // } else {
       //   $('#' + previewId).attr('src', '').css('display','none');
       //   $('#' + labelId).text('You can choose only jpg or png file');
       // }

  </script>


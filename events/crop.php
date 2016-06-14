<?php

$sql = sprintf('SELECT * FROM `events` WHERE `organizer_id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
      );
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $event = mysqli_fetch_assoc($record); 
    var_dump($event);
    var_dump($_SESSION);



if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $targ_w = 400;
  $targ_h = 200;
  $jpeg_quality = 90;

  $src = 'webroot/assets/images/mali.jpg';
  $img_r = imagecreatefromjpeg($src);
  $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

  imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
  $targ_w,$targ_h,$_POST['w'],$_POST['h']);

  // header('Content-type: image/jpeg');
  // // imagejpeg($dst_r,null,$jpeg_quality);
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
    <img src="../webroot/assets/images/mali.jpg" id="cropbox" width="1000px" height="700px"/>

    <!-- This is the form that our event handler fills -->
    <form action="crop" method="post" onsubmit="return checkCoords();">
      <input type="hidden" id="x" name="x" />
      <input type="hidden" id="y" name="y" />
      <input type="hidden" id="w" name="w" />
      <input type="hidden" id="h" name="h" />
      <input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
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


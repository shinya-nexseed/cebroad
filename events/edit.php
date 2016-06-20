<?php 
$sql = sprintf("SELECT * FROM events WHERE id=%d",
		mysqli_real_escape_string($db, $id)
	);
$rtn = mysqli_query($db, $sql) or die('Failed to connect a detabase');
$event = mysqli_fetch_assoc($rtn);

if ((int)$_SESSION['id'] !== (int)$event['organizer_id']) {
	header('Location: /cebroad/events/index');
}

  $errors = Array();
  
  //例外を返す関数
  function e($message, $previous = null) {
    return new Exception($message, 0, $previous);
}

  //例外を配列に格納
  function exception_to_array(Exception $e) {
    do {
          $errors[] = $e->getMessage();
      } while ($e = $e->getPrevious());
      return array_reverse($errors);
    }



  if (!empty($_POST)) {
  try{
    $e = null;
    if (isset($_POST['title'])) {
        $title = trim(mb_convert_kana($_POST['title'], "s", 'UTF-8'));
        if ($title === '') {
            $e = e('Please input a title.', $e);
        } else {
          $_POST['title'] = $title;
        }
    } else {
        $e = e('Please input a title.', $e);
    }


    if (isset($_POST['detail'])) {
        $detail = trim(mb_convert_kana($_POST['detail'], "s", 'UTF-8'));
        if ($detail === '') {
            $e = e('Please input a detail.', $e);
        } else {
          $_POST['detail'] = $detail;
        }
    } else {
        $e = e('Please input a detail.', $e);
    }

    if (empty($_POST['starting_time'])) {
        $e = e('Please specify a starting time.', $e);
    }

    if (!empty($_POST['closing_time'])) {

    }

    if (empty($_POST['place_name']) || empty($_POST['lat']) || empty($_POST['lng'])) {
        $e = e('Please specify a place.', $e);
    }

    if (!empty($_POST['capacity'])) {
      if (!ctype_digit(strval($_POST['capacity']))) {
          $e = e('The value of the capacity is invalid.', $e);
      }
    }

    for ($i=1; $i<4; $i++) {

    $pic = 'pic'.$i;
    // 未定義である・複数ファイルである・$_FILES Corruption 攻撃を受けた
    // どれかに該当していれば不正なパラメータとして処理する
    if (
        !isset($_FILES[$pic]['error']) ||
        !is_int($_FILES[$pic]['error'])
    ) {
        $e = e('picture'.$i.'のパラメータが不正です', $e);
    }
    if ($_FILES[$pic]['error'] === 0) {


    // ここで定義するサイズ上限のオーバーチェック
    // (必要がある場合のみ)
    if ($_FILES[$pic]['size'] > 10485760) {
        $e = e('picture'.$i.'のファイルサイズが大きすぎます', $e);
    }


        // $_FILES['upfile']['mime']の値はブラウザ側で偽装可能なので
        // MIMEタイプに対応する拡張子を自前で取得する
        if (!$ext = array_search (
            mime_content_type($_FILES[$pic]['tmp_name']),
            array(
                'jpg' => 'image/jpg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
            ),
            true
        )) {
            $e = e('picture'.$i.'のファイル形式が不正です', $e);
          }

      $_FILES[$pic]['content'] = file_get_contents($_FILES[$pic]['tmp_name']);
      $_FILES[$pic]['ext'] = $ext;
    } else if ($_FILES[$pic]['error'] !== 4) {
      switch($_FILES[$pic]['error']) {
        case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
        case UPLOAD_ERR_FORM_SIZE: //form定義の最大サイズ超過
          $e = e('picture'.$i.'のファイルサイズが大きすぎます。');
        default:
          $e = e('picture'.$i.'にその他のエラーが発生しました。');
      }
    }
  }
    if ($e) {
      throw $e;
    }

    
        $_SESSION['events'] = $_POST + $_FILES;

        header('Location: /cebroad/events/confirm');
      exit();
    } catch (Exception $e) {
    exception_to_array($e);
  }
}

  if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'rewrite') {
    $_POST = $_SESSION['events'];
    $errors['rewrite'] = true;
  }

  $title = '';
  $date = '';
  $starting_time = '';
  $closing_time = '';
  $capacity = '';
  $place = '';
  $place_name = '';
  $lat = '';
  $lng =  '';
  $detail = '';

  if ($id === 'rewrite') {
    $_POST = $_SESSION['events'];
  } else if (!isset($_POST['post_check'])){
  	$_POST = $event;
  }

    if (!empty($_POST['title'])) {
      $title = $_POST['title'];
    }
    if (!empty($_POST['date'])) {
      $date = $_POST['date'];
    }
    if (!empty($_POST['starting_time'])) {
      $starting_time = $_POST['starting_time'];
    }
    if (!empty($_POST['closing_time'])) {
      $closing_time = $_POST['closing_time'];
    }
    if (!empty($_POST['capacity'])) {
      $title = $_POST['capacity'];
    }
    if (!empty($_POST['place'])) {
      $place = $_POST['place'];
    }
    if (!empty($_POST['place_name'])) {
      $place_name = $_POST['place_name'];
    }
    if (!empty($_POST['latitude'])) {
      $lat = $_POST['latitude'];
    }
    if (!empty($_POST['longitude'])) {
      $lng = $_POST['longitude'];
    }
    if (!empty($_POST['detail'])) {
      $detail = $_POST['detail'];
    }

//    if (isset($_POST['picture_path_1']) && )


$now = date('Y-m-d');
$year = date('Y-m-d', strtotime("+1year"));
var_dump($errors);
 ?>
<script src="/cebroad/webroot/assets/js/jquery-1.12.4.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&output?json&region=ph&language=en&key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8"></script>


<div class="container">


    <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="10485760">

      <div class="row">

      <div class="testvar hidden-xs col-sm-2 col-md-2">
        </div>

        <div class="col-sm-8 col-md-8">
            <h1>Edit the event</h1>
            <h3 class="cebroad-pink">Red items are necessarily required</h3>
        </div>

        <div class="col-sm-8 col-md-8">
            <div class="form-group">
                <label class="cebroad-pink">Title</label>
                <input type="text" name="title" id="title" class="form-control" required value="<?=h($title)?>">
            </div>
        </div>

        <div class="col-sm-4 col-md-4">
            <label class="cebroad-pink">Date</label>
            <div class="form-group">
                <input type="date" name="date" id="date" class="form-control " min="<?php echo $now; ?>" max="<?php echo $year; ?>" value="<?=h($date)?>" required>
            </div>
        </div>


        <div class="col-sm-2 col-md-2">
            <label class="cebroad-pink">Starting time</label>
            <div class="form-group">
                <input type="time" name="starting_time" id="starting_time" class="form-control" value="<?=h($starting_time)?>" required>
            </div>
        </div>
        <div class="col-sm-2 col-md-2">
                <label id="closing_time_label">Closing time</label>
                <div class="form-group">
                    <input type="time" name="closing_time" id="closing_time" class="form-control" id="closing_time" value="<?=h($closing_time)?>">
                </div>

<!--             <div class="form-group">
                <a id="time_button" onclick="closingTime()">Add closing time</a>
            </div> -->

        </div>


        <div class="col-sm-4 col-md-4">
            <label>Capacity</label>
            <div class="form-group">
                <input type="number" name="capacity" id="capacity" class="form-control " min="1" value="<?=h($capacity)?>">
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label class="cebroad-pink">Place</label>
            <div class="form-group">
                <input id="searchTextField" type="text" name="place" id="place" value="<?=h($place_name)?>" class="form-control" required>
            </div>
        </div>
        
        <div class="col-sm-8 col-md-8">
            <div class="form-group">
                <label class="cebroad-pink">detail</label>
                <textarea name="detail" id="detail" class="form-control" rows="6" required><?=h($detail)?></textarea>
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label>Picture1</label>
            <input class="pic" name="pic1" id="pic1" type="file" style="display:none">
            <div class="input-group">
              <input type="text" id="photoCover1" class="form-control" placeholder="Select jpg or png">
              <span class="input-group-btn"><button type="button" class="btn btn-cebroad" onclick="$('#pic1').click();">Browse</button></span>
            </div>
            <label id="label1" class="cebroad-pink"></label>
            <div class="events-pad">
              <img src="" id="preview1" style="display:none; width: 300px;">
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label>Picture2</label>
            <input class="pic" name="pic2" id="pic2" type="file" style="display:none">
            <div class="input-group">
              <input type="text" id="photoCover2" class="form-control" placeholder="Select jpg or png">
              <span class="input-group-btn"><button type="button" class="btn btn-cebroad" onclick="$('#pic2').click();">Browse</button></span>
            </div>
            <label id="label2" class="cebroad-pink"></label>
            <div class="events-pad">
              <img src="" id="preview2" style="display:none; width: 300px;">
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label>Picture3</label>
            <input class="pic" name="pic3" id="pic3" type="file" style="display:none">
            <div class="input-group">
              <input type="text" id="photoCover3" class="form-control" placeholder="Select jpg or png">
              <span class="input-group-btn"><button type="button" class="btn btn-cebroad" onclick="$('#pic3').click();">Browse</button></span>
            </div>
            <label id="label3" class="cebroad-pink"></label>
            <div class="events-pad">
              <img src="" id="preview3" style="display:none; width: 300px;">
            </div>
        </div>

        <div class="form-group">
            <input id=place_name type="hidden" name="place_name" value="<?=h($place_name)?>">
            <input id=lat type="hidden" name="latitude" value="<?=h($lat)?>">
            <input id=lng type="hidden" name="longitude" value="<?=h($lng)?>">
            <input id=post_check type="hidden" name="post_check" value="post_check">
        </div>

        <?php foreach($errors as $error): ?>
          <p class="cebroad-pink"><?=$error?></p>
        <?php endforeach; ?>

        <div class="col-sm-8 col-md-8" class="events-pad";>
            <div class="form-group">
                <a href="/cebroad/events/index">Back</a>
                <input type="submit" id="confirm" class="btn btn-cebroad" disabled="disabled" value="confirm">
                <img src="/cebroad/webroot/assets/events/gif/loading.gif" id="loading" style="display: none;">
            </div>
        </div>
 
      </div>
    </form>
</div>
<script src="/cebroad/webroot/assets/events/js/add.js"></script>
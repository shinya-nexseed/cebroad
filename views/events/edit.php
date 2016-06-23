<?php 
//$idを元にイベント参加者を取得
  $sql=sprintf('SELECT * FROM `users` JOIN `participants` ON `id`=participants.user_id WHERE participants.event_id=%d',
    mysqli_real_escape_string($db, $id)
    );
  $record=mysqli_query($db, $sql)or die(mysqli_error($db));
  
  $event_participants=array();

  while($result=mysqli_fetch_assoc($record)){
    $event_participants[]=$result;
  }

//$idを元にイベントを取得
  $sql = sprintf("SELECT * FROM events WHERE id=%d",
      mysqli_real_escape_string($db, $id)
    );
  $rtn = mysqli_query($db, $sql) or die('<h1>Failed to connect a detabase.</h1>');
  $event = mysqli_fetch_assoc($rtn);
  if ((int)$_SESSION['id'] !== (int)$event['organizer_id']) {
    echo '<script> location.replace("/portfolio/cebroad/events/index"); </script>';
  }

  $errors = array();
  $error_messages = array();
  //$eventを省略;
  $a = array();
  $a = $event;
  
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
  //第一引数(日付や時刻)を第二引数の日付・時刻フォーマットと照合し一致すればtrueを返す関数
  function validateDateTime($date, $format = 'Y-m-d H:i:s') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
    }




  if (!empty($_POST)) {
  try{
    $e = null;

    if (!isset($_POST['title'])) {
        $e = e('Please input a title.', $e);
    } else {
      //全角スペースを半角スペースにコンバートし、前後の半角スペースを全削除
      $title = trim(mb_convert_kana($_POST['title'], "s", 'UTF-8'));
        if ($title === '') {
            $e = e('Please input a title.', $e);
            //文字数制限
            if (strlen($title) > 50) {
              $e = e('The title is over 50 characters.', $e);
           } else {
            $a['title'] = $title;
          }
        } 

    }


    if (!isset($_POST['detail'])) {
        $e = e('Please input a detail.', $e);
    } else {
        $detail = trim(mb_convert_kana($_POST['detail'], "s", 'UTF-8'));
        if ($detail === '') {
            $e = e('Please input a detail.', $e);
            //文字数制限
            if (strlen($detail) > 500) {
              $e = e('The detail is over 500 characters.', $e);
            } else {
            $a['detail'] = $detail;
         } 
        }
        
    }
    //年-月-日に一致するかチェック
    if (empty($_POST['date'])) {
      $e = e('Please input a date.', $e);
    } else {
      if (!validateDateTime($_POST['date'], 'Y-m-d')) {
        $e = e('The form of the date is wrong.', $e);
      } else {
        $a['date'] = $_POST['date'];
      }
    }

    //時:分の形に一致するかチェック
    if (empty($_POST['starting_time'])) {
        $e = e('Please input a starting time.', $e);
    } else {
      if (!validateDateTime($_POST['starting_time'], 'H:i')) {
        $e = e('The form of the starting time is wrong.', $e);
      } else {
        $a['starting_time'] = $_POST['starting_time'];
      }
    }

    if (!empty($_POST['closing_time'])) {
      if (!validateDateTime($_POST['closing_time'], 'H:i')) {
        $e = e('The form of the closing time is wrong.', $e);      
      } else {
        $assets['closing_time'] = $_POST['closing_time'];
      }
    }

    if (empty($_POST['place_name']) || empty($_POST['latitude']) || empty($_POST['longitude'])) {
        $e = e('Please input a place.', $e);
    } else {
      //緯度と経度がfloat(小数点以下を含む数字)型であるかチェック
      //phpでは歴史の関係でgettypeの際floatでもdoubleが返ってくる
      if (gettype(floatval($_POST['latitude'])) !== 'double' || gettype(floatval($_POST['longitude'])) !== 'double') {
        $e = e('The parameter of the place is wrong.', $e);
      } else {
          $a['place_name'] = $_POST['place_name'];
          $a['latitude'] = $_POST['latitude'];
          $a['longitude'] = $_POST['longitude'];
      }
    }
    //strvalで文字列としての値を取得し。ctype_digitで全ての文字が数字であることをチェック
    if (!empty($_POST['capacity'])) {
      $_POST['capacity'] = ltrim(mb_convert_kana($_POST['capacity'], "s", 'UTF-8'), '0');
      if (!ctype_digit(strval($_POST['capacity']))) {
          $e = e('The value of the capacity is invalid.', $e);
          //文字数制限
        if (strlen($_POST['capacity']) > 5) {
            $e = e('The capacity is over 5 digit.', $e);
        } else {
            $a['capacity_num'] = $_POST['capacity'];
        }
      }
    }

    if (empty($_POST['category'])) {
      $e = e('Please select a category.', $e);
    } else {
        if (!ctype_digit(strval($_POST['category']))) {
          $e = e('The value of the category is invalid.', $e);
        } else {
            $a['event_category_id'] = $_POST['category'];
      }
    }

    //picture0~3をfor文でまとめて処理
    //${"pic".$i."_path"}のように記述すると変数名に変数を使うことができる。(可変変数という)
    for ($i=0; $i<4; $i++) {

    $pic = 'pic'.$i;
    // 未定義である・複数ファイルである・$_FILES Corruption 攻撃を受けた
    // どれかに該当していれば不正なパラメータとして処理する
    if (
        !isset($_FILES[$pic]['error']) ||
        !is_int($_FILES[$pic]['error'])
    ) {
        $e = e('The parameter of picture'.$i.' is wrong.', $e);
    }
    if ($_FILES[$pic]['error'] === 0) {


    // ここで定義するサイズ上限のオーバーチェック
    if ($_FILES[$pic]['size'] > 10485760) {
        $e = e('The filesize of picture'.$i.' is over 10MB.', $e);
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
            $e = e('The extension of picture'.$i.'is wrong.', $e);
          }

    $image = '';
    switch ($ext) {
      case 'png':
        $image = imagecreatefrompng($_FILES[$pic]['tmp_name']);
        break;
      case 'jpg' or 'jpeg':
        $image = imagecreatefromjpeg($_FILES[$pic]['tmp_name']);
        break;
  }
    list($width, $height) = getimagesize($_FILES[$pic]['tmp_name']);

    $new_width = 800;

    $new_height = 600;

    $new_image = ImageCreateTrueColor($new_width, $new_height);
 
    ImageCopyResampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    ImageJPEG($new_image, $_FILES[$pic]['tmp_name'], 100);
 
    ImageDestroy($image);

    ImageDestroy($new_image);



    } else if ($_FILES[$pic]['error'] !== 4) {
      switch($_FILES[$pic]['error']) {
        case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
        case UPLOAD_ERR_FORM_SIZE: //form定義の最大サイズ超過
          $e = e('The filesize of picture'.$i.' is over 10MB.', $e);
        default:
          $e = e('Something wrong happened with picture'.$i.'.', $e);
      }
    }
  }

    if ($e) {
      throw $e;
    }

    for ($i=0; $i<4; $i++) {

      if ($_FILES['pic'.$i]['error'] === 0) {
        if (move_uploaded_file($_FILES['pic'.$i]['tmp_name'], ${"pic".$i."_path"} = 'views/events/events_pictures/'.sha1(mt_rand() . microtime()).'.jpg')) {
            if (strpos($a['picture_path_'.$i], 'default.jpg') === false) {
            $path_to_delete = mb_substr($a['picture_path_'.$i], strpos($a['picture_path_'.$i], 'views'));
            unlink($path_to_delete);
            }
              $a['picture_path_'.$i] = '/portfolio/cebroad/'.${"pic".$i."_path"};
             } else {
             die('<h1>Sorry, failed to upload picture'.$i.'. Please retry.</h1>');
          }
        }
      }

      $sql = sprintf("UPDATE events SET title='%s', detail='%s', date='%s', starting_time='%s', closing_time='%s', place_name='%s', latitude='%s', longitude='%s', picture_path_0='%s', picture_path_1='%s', picture_path_2='%s', picture_path_3='%s', capacity_num=%d, event_category_id=%d WHERE id=%d",
          mysqli_real_escape_string($db, $_POST['title']),
          mysqli_real_escape_string($db, $_POST['detail']),
          mysqli_real_escape_string($db, $a['date']),
          mysqli_real_escape_string($db, $a['starting_time']),
          mysqli_real_escape_string($db, $a['closing_time']),
          mysqli_real_escape_string($db, $a['place_name']),
          mysqli_real_escape_string($db, $a['latitude']),
          mysqli_real_escape_string($db, $a['longitude']),
          mysqli_real_escape_string($db, $a['picture_path_0']),
          mysqli_real_escape_string($db, $a['picture_path_1']),
          mysqli_real_escape_string($db, $a['picture_path_2']),
          mysqli_real_escape_string($db, $a['picture_path_3']),
          mysqli_real_escape_string($db, $a['capacity_num']),
          mysqli_real_escape_string($db, $a['event_category_id']),
          (int)$id
      );
      mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. Please retry.</h1>');

      //イベント参加者に編集したことを通知する
      foreach ($event_participants as $event_participant) {
            $sql= sprintf('INSERT INTO `notifications`(`user_id`, `partner_id`, `event_id`, `topic_id`, `created`) VALUES(%d,%d,%d,3,now())',
              $event_participant['user_id'],
              $a['organizer_id'],
              $id
              );
            $record = mysqli_query($db, $sql) or die(mysqli_error($db));
      }

      echo '<script> location.replace("/portfolio/cebroad/events/show/'.(int)$id.'"); </script>';
      exit();
    } catch (Exception $e) {
      $error_messages = exception_to_array($e);
  }
}

  $sql = "SELECT * FROM event_categories";
  $rtn = mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. Please retry.</h1>');

  $title = '';
  $date = '';
  $starting_time = '';
  $closing_time = '';
  $capacity = '';
  $category = '';
  $place = '';
  $place_name = '';
  $lat = '';
  $lng =  '';
  $detail = '';

//一度editした後にエラーが出る　という流れでしかpost_checkは存在しない
//よって最初にこのページに遷移してきた時のみ$_POSTに$eventを代入する(htmlでの出力を簡素にするための処理)
if (!isset($_POST['post_check'])) {
  	$_POST = $a;
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
    if (!empty($_POST['category'])) {
      $category = $_POST['category'];
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

//指定できるdateを今日〜1年後にする
$now = date('Y-m-d');
$year = date('Y-m-d', strtotime("+1year"));

 ?>
<script src="/portfolio/cebroad/webroot/assets/js/jquery-1.12.4.min.js"></script>
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
                <input type="text" name="title" id="title" class="form-control" required value="<?=h($title)?>" placeholder="50 character limit">
                <p id="title_count"></p>
            </div>
        </div>

        <div class="col-sm-4 col-md-4">            
            <div class="form-group">
                <label class="cebroad-pink">Date</label>
                <input type="date" name="date" id="date" class="form-control " min="<?=$now?>" max="<?=$year?>" value="<?=h($date)?>" required>
            </div>
        </div>

        <div class="col-sm-2 col-md-2">            
            <div class="form-group">
                <label class="cebroad-pink">Starting time</label>
                <input type="time" name="starting_time" id="starting_time" class="form-control" value="<?=h($starting_time)?>" required>
            </div>
        </div>

        <div class="col-sm-2 col-md-2">                
                <div class="form-group">
                    <label id="closing_time_label">Closing time</label>
                    <input type="time" name="closing_time" id="closing_time" class="form-control" id="closing_time" value="<?=h($closing_time)?>">
                </div>
        </div>

        <div class="col-sm-4 col-md-4">
            <div class="form-group">
                <label class="cebroad-pink">Category</label>
                <select name="category" id="category" class="form-control">
                  <?php while ($cat = mysqli_fetch_assoc($rtn)): ?>
                  <option value="<?=$cat['id']?>" 
                  <?php if ($category === $cat['id']){
                    echo 'selected';
                  } ?>>
                  <?=$cat['name']?></option>
                  <<?php endwhile; ?>
                </select>
            </div>
        </div>


        <div class="col-sm-4 col-md-4">
            <div class="form-group">
                <label>Capacity</label>
                <input type="number" name="capacity" id="capacity" class="form-control " min="1" value="<?=h($capacity)?>" placeholder="5 digit limit">
                <p id="capacity_count"></p>
            </div>
        </div>

        <div class="col-sm-8 col-md-8">            
            <div class="form-group">
                <label class="cebroad-pink">Place</label>
                <input id="searchTextField" type="text" name="place" id="place" value="<?=h($place_name)?>" class="form-control" required>
                <img src="/portfolio/cebroad/webroot/assets/events/img/loading.gif" id="loading" style="display: none;">
            </div>
        </div>
        
        <div class="col-sm-8 col-md-8">
            <div class="form-group">
                <label class="cebroad-pink">detail</label>
                <textarea name="detail" id="detail" class="form-control" rows="10" required placeholder="500 character limit"><?=h($detail)?></textarea>
                <p id="detail_count"></p>
                <p class="cebroad-pink">Type the name of the event location then you see options below the form. You might not see correct options in case the internet is slow. In that case please reload the page.</p>
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label>Thumbnail picture</label>
            <input class="pic" name="pic0" id="pic0" type="file" style="display:none">
            <div class="input-group">
              <input type="text" id="photoCover0" class="form-control" placeholder="Select jpg or png(Maximum of 10MB)">
              <span class="input-group-btn"><button type="button" class="btn btn-cebroad" onclick="$('#pic0').click();">Browse</button></span>
            </div>
            <label id="label0" class="cebroad-pink"></label>
            <div class="events-pad">
              <img src="<?=h($a['picture_path_0'])?>" id="preview0" style="width: 300px;">
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label>Picture1</label>
            <input class="pic" name="pic1" id="pic1" type="file" style="display:none">
            <div class="input-group">
              <input type="text" id="photoCover1" class="form-control" placeholder="Select jpg or png(Maximum of 10MB)">
              <span class="input-group-btn"><button type="button" class="btn btn-cebroad" onclick="$('#pic1').click();">Browse</button></span>
            </div>
            <label id="label1" class="cebroad-pink"></label>
            <div class="events-pad">
              <img src="<?=h($a['picture_path_1'])?>" id="preview1" style="<?php 
                if (empty($a['picture_path_1'])) {
                  echo 'display:none;';
                }
               ?> width: 300px;">
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label>Picture2</label>
            <input class="pic" name="pic2" id="pic2" type="file" style="display:none">
            <div class="input-group">
              <input type="text" id="photoCover2" class="form-control" placeholder="Select jpg or png(Maximum of 10MB)">
              <span class="input-group-btn"><button type="button" class="btn btn-cebroad" onclick="$('#pic2').click();">Browse</button></span>
            </div>
            <label id="label2" class="cebroad-pink"></label>
            <div class="events-pad">
              <img src="<?=h($a['picture_path_2'])?>" id="preview2" style="<?php 
                if (empty($a['picture_path_2'])) {
                  echo 'display:none;';
                }
               ?> width: 300px;">
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label>Picture3</label>
            <input class="pic" name="pic3" id="pic3" type="file" style="display:none">
            <div class="input-group">
              <input type="text" id="photoCover3" class="form-control" placeholder="Select jpg or png(Maximum of 10MB)">
              <span class="input-group-btn"><button type="button" class="btn btn-cebroad" onclick="$('#pic3').click();">Browse</button></span>
            </div>
            <label id="label3" class="cebroad-pink"></label>
            <div class="events-pad">
              <img src="<?=h($a['picture_path_3'])?>" id="preview3" style="<?php 
                if (empty($a['picture_path_3'])) {
                  echo 'display:none;';
                }
               ?> width: 300px;">
            </div>
        </div>

        <div class="form-group">
            <input id=place_name type="hidden" name="place_name" value="<?=h($place_name)?>">
            <input id=lat type="hidden" name="latitude" value="<?=h($lat)?>">
            <input id=lng type="hidden" name="longitude" value="<?=h($lng)?>">
            <input id=post_check type="hidden" name="post_check" value="post_check">
        </div>

        <div class="col-sm-8 col-md-8">
          <?php foreach($error_messages as $error): ?>
            <label class="cebroad-pink"><?=$error?></label>
          <?php endforeach; ?>
        </div>

        <div class="col-sm-8 col-md-8" class="events-pad">
            <div class="form-group">
                <a href="/portfolio/cebroad/events/index">Back</a>
                <input type="submit" id="confirm" class="btn btn-cebroad" disabled="disabled" value="confirm">
            </div>
        </div>
 
      </div>
    </form>
</div>
<script src="/portfolio/cebroad/webroot/assets/events/js/events.js"></script>

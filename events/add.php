<?php
  $error = Array();
  
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

//   try {
//     $e = null;
//     if ($name === '') {
//         $e = e('名前が未入力です', $e);
//     }
//     if ($email === '') {
//         $e = e('メールアドレスが未入力です', $e);
//     }
//     if ($e) {
//         throw $e;
//     }
// } catch (Exception $e) {
//     die(implode("<br />\n", exception_to_array($e)));
// }


  if (!empty($_POST)) {

    if (isset($_POST['title'])) {
        $title = trim(mb_convert_kana($_POST['title'], "s", 'UTF-8'));
        if ($_POST['title'] === '') {
            $error['title'] = 'blank';
        }
    } else {
        $error['title']   = 'blank';
    }


    if (isset($_POST['detail'])) {
        $title = trim(mb_convert_kana($_POST['detail'], "s", 'UTF-8'));
        if ($_POST['detail'] === '') {
            $error['detail'] = 'blank';
        }
    } else {
        $error['detail']   = 'blank';
    }

    if (empty($_POST['starting_time'])) {
        $error['starting_time'] = 'blank';
    }

    if (empty($_POST['place_name']) || empty($_POST['lat']) || empty($_POST['lng'])) {
        $error['place'] = 'blank';
    }

    if (isset($_POST['capacity'])) {
      if (ctype_digit(strval($_POST['capacity']))) {
          $error['capacity'] = 'type';
      }
    }
    for ($i=1; $i<4; $i++) { 
    if (empty($_FILES['pic'.$i])) {
    $fileName = $_FILES['pic'.$i]['name'];
    if (empty($fileName)) {
      $ext = substr($fileName, -3);
      if ($ext !== 'jpg' && $ext !== 'png') {
        $error['pic'.$i] = 'type';
      }
     }
   }
  }

    
    if (empty($error)) {

      for ($i=1; $i<4; $i++) {
      $picture = date('YmdHis') . $_FILES['pic'.$i]['name'];
      @move_uploaded_file($_FILES['pic'.$i]['tmp_name'], 'events/events_pictures/' . $picture);
      $_SESSION['events']['pic'.$i] = $picture;
    }
      // if (move_uploaded_file($_FILES['picture_path']['tmp_name'], '../member_picture/' . $picture) == false) {
      //   echo $_FILES['picture_path']['error'];
      // }
        $_SESSION['events'] = $_POST;
        header('Location: confirm');
      exit();
    }
  }
  if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
    $_POST = $_SESSION['events'];
    $error['rewrite'] = true;
  }

$now = date('Y-m-d');
$year = date('Y-m-d', strtotime("+1year"));
 ?>
<link rel="stylesheet" href="../webroot/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../webroot/assets/events/css/events.css">
<link rel="stylesheet" href="../webroot/assets/font-awesome/css/font-awesome.min.css">
<script src="../webroot/assets/js/jquery-1.12.4.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&output?json&region=ph&language=en&key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8"></script>
<!-- <script src="../webroot/assets/events/js/add.js"></script> -->



<div class="container">


    <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="10240" />

      <div class="row">

      <div class="testvar hidden-xs col-sm-2 col-md-2">
        </div>

        <div class="col-sm-8 col-md-8">
            <h1>New event</h1>
            <h3 class="events_label_color">Red items are necessarily required</h3>
        </div>

        <div class="col-sm-8 col-md-8">
            <div class="form-group">
                <label class="events_label_color">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
        </div>

        <div class="col-sm-4 col-md-4">
            <label class="events_label_color">Date</label>
            <div class="form-group">
                <input type="date" name="date" class="form-control " min="<?php echo $now; ?>" max="<?php echo $year; ?>"  required>
            </div>
        </div>


        <div class="col-sm-2 col-md-2">
            <label class="events_label_color">Starting time</label>
            <div class="form-group">
                <input type="time" name="starting_time" class="form-control" required>
            </div>
        </div>
        <div class="col-sm-2 col-md-2">
                <label id="closing_time_label">Closing time</label>
                <div class="form-group">
                    <input type="time" name="closing_time" class="form-control" id="closing_time">
                </div>

<!--             <div class="form-group">
                <a id="time_button" onclick="closingTime()">Add closing time</a>
            </div> -->

        </div>


        <div class="col-sm-4 col-md-4">
            <label>Capacity</label>
            <div class="form-group">
                <input type="number" name="capacity" class="form-control " min="1">
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label class="events_label_color">Place</label>
            <div class="form-group">
                <input id="searchTextField" type="text" name="place" class="form-control" required>
            </div>
        </div>
        
        <div class="col-sm-8 col-md-8">
            <div class="form-group">
                <label class="events_label_color">detail</label>
                <textarea name="detail" class="form-control" rows="6" required></textarea>
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label>Picture1</label>
            <input class="pic" name="pic1" id="pic1" type="file" style="display:none">
            <div class="input-group">
              <input type="text" id="photoCover1" class="form-control" placeholder="Select jpg or png">
              <span class="input-group-btn"><button type="button" class="btn btn-info browse" id="browse1" onclick="$('#pic1').click();">Browse</button></span>
            </div>
            <label id="label1" class="events_label_color"></label>
            <div class="pad_top">
              <img src="" id="preview1" style="display:none; width: 300px;">
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label>Picture2</label>
            <input class="pic" name="pic2" id="pic2" type="file" style="display:none">
            <div class="input-group">
              <input type="text" id="photoCover2" class="form-control" placeholder="Select jpg or png">
              <span class="input-group-btn"><button type="button" class="btn btn-info browse" id="browse2" onclick="$('#pic2').click();">Browse</button></span>
            </div>
            <label id="label2" class="events_label_color"></label>
            <div class="pad_top">
              <img src="" id="preview2" style="display:none; width: 300px;">
            </div>
        </div>

        <div class="col-sm-8 col-md-8">
            <label>Picture3</label>
            <input class="pic" name="pic3" id="pic3" type="file" style="display:none">
            <div class="input-group">
              <input type="text" id="photoCover3" class="form-control" placeholder="Select jpg or png">
              <span class="input-group-btn"><button type="button" class="btn btn-info browse" id="browse3" onclick="$('#pic3').click();">Browse</button></span>
            </div>
            <label id="label3" class="events_label_color"></label>
            <div class="pad_top">
              <img src="" id="preview3" style="display:none; width: 300px;">
            </div>
        </div>

        <div class="form-group">
            <input id=place_name type="hidden" name="place_name" value="">
            <input id=lat type="hidden" name="lat" value="">
            <input id=lng type="hidden" name="lng" value="">
        </div>

        <div class="col-sm-8 col-md-8" class="pad_top";>
            <div class="form-group">
                <input type="submit" id="confirm" class="btn btn-primary" disabled="disabled" value="confirm">
            </div>
        </div>

      </div>
    </form>
</div>
<script>

function initialize() {
    var input = document.getElementById('searchTextField');

    var options = {
        componentRestrictions: {country: 'ph'}
    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        $('#place_name').attr('value', place.name);
        $('#lat').attr('value', place.geometry.location.lat());
        $('#lng').attr('value', place.geometry.location.lng());
        $('#confirm').attr('disabled', false);
        });
}

google.maps.event.addDomListener(window, 'load', initialize);

//Placeに何か変更があった場合confirmを無効にする
$('#searchTextField').keydown(function() {
    $('#confirm').attr('disabled', true);
});

//3つある画像のプレビューを共通の関数で処理するためにそれぞれのidを取得する関数
$('.pic').change(function(){
    console.log('preview振り分け');
    var picId = $(this).attr('id');
    preview(picId);
});
//実際に画像のプレビューを行う関数
function preview(id) {
    console.log('preview');
    var file = $('#' + id).prop('files')[0];
    var num = id.slice(-1);
    var previewId = 'preview' + num;
    var labelId = 'label' + num;
    var photoCoverId = 'photoCover' + num;
    //png, jpg, jpegのどれにも一致しない場合注意文を表示
    if ( file.type == 'image/png' || file.type == 'image/jpg' || file.type == 'image/jpeg') {
        //空のimgタグにプレビューを挿入
        var fr = new FileReader();
        fr.onload = function() {
            $('#' + previewId).attr('src', fr.result ).css('display','inline');
            $('#' + labelId).text('');
        }
        fr.readAsDataURL(file);
      } else {
        $('#' + previewId).attr('src', '').css('display','none');
        $('#' + labelId).text('You can choose only jpg or png file');
      }
      //display: none;で隠したinputタグのfile情報をphotoCoverに渡す
        $('#' + photoCoverId).val($('#' + id).val().replace("C:\\fakepath\\", ""));
    }
    
</script>
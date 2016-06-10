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

  try {
    $e = null;
    if ($name === '') {
        $e = e('名前が未入力です', $e);
    }
    if ($email === '') {
        $e = e('メールアドレスが未入力です', $e);
    }
    if ($e) {
        throw $e;
    }
} catch (Exception $e) {
    die(implode("<br />\n", exception_to_array($e)));
}


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

    if (!empty($_POST['starting_time'])) {
        $error['starting_time'] = 'blank';
    }

    if (!empty($_POST['closing_time'])) {
        $error['closing_time'] = 'blank';
    }

    if (!empty($_POST['capacity'])) {
      $error['capacity'] = 'blank';
    } else if (ctype_digit(strval($_POST['capacity']))) {
        $error['capacity'] = 'type';
    }
    $fileName = $_FILES['pic1']['name'];
    if (!empty($fileName)) {
      $ext = substr($fileName, -3);
      if ($ext !== 'jpg' && $ext !== 'gif' && $ext !== 'png') {
        $error['pic1'] = 'type';
      }
    }
    
    if (empty($error)) {

      $picture = date('YmdHis') . $_FILES['pic1']['name'];
      @move_uploaded_file($_FILES['pic1']['tmp_name'], 'events/events_pictures/' . $picture);
      // if (move_uploaded_file($_FILES['picture_path']['tmp_name'], '../member_picture/' . $picture) == false) {
      //   echo $_FILES['picture_path']['error'];
      // }
        $_SESSION['join'] = $_POST;
        $_SESSION['join']['picture'] = $picture;
        header('Location:check.php');
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
<link rel="stylesheet" href="../webroot/assets/css/bootstrap.css">
<link rel="stylesheet" href="../webroot/assets/css/add.css">
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&output?json&region=ph&language=en&key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8"></script>
<script src="../webroot/assets/js/jquery-1.12.4.min.js"></script>

<div class="container">
    <form action="/cebroad/events/confirm" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="10240" />

      <div class="row">

        <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
            <h1>New event</h1>
            <h3>Red items are necessarily required</h3>
        </div>

        <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
            <div class="form-group">
                <label class="red">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
        </div>

        <div class="col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2">
            <label class="red">Date</label>
            <div class="form-group">
                <input type="date" name="date" class="form-control " min="<?php echo $now; ?>" max="<?php echo $year; ?>"  required>
            </div>
        </div>

        <div class="col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2">
            <label class="red">Starting time</label>
            <div class="form-group">
                <input type="time" name="starting_time" class="form-control" required>
            </div>
                <label id="closing_time_label">Closing time</label>
                <div class="form-group">
                    <input type="time" name="closing_time" class="form-control" id="closing_time">
                </div>
<!--             <div class="form-group">
                <a id="time_button" onclick="closingTime()">Add closing time</a>
            </div> -->

        </div>


        <div class="col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2">
            <label>Capacity</label>
            <div class="form-group">
                <input type="number" name="capacity" class="form-control " min="1" required>
            </div>
        </div>

        <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
            <label class="red">Place</label>
            <div class="form-group">
                <input id="searchTextField" type="text" name="place" class="form-control" required>
            </div>
        </div>
        
        <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
            <div class="form-group">
                <label class="red">detail</label>
                <textarea name="detail" class="form-control" rows="6" required></textarea>
            </div>
        </div>

        <div class="col-sm-8 col-md-2 col-md-offset-2 col-sm-offset-2">
            <div class="form-group">
                <label>Picture1</label>
                <input type="file" name="pic1">
            </div>
        </div>

        <div class="col-sm-8 col-md-2 col-md-offset-2 col-sm-offset-2">
            <div class="form-group">
                <label>Picture2</label>
                <input type="file" name="pic2">
            </div>
        </div>

        <div class="col-sm-8 col-md-2 col-md-offset-2 col-sm-offset-2">
            <div class="form-group">
                <label>Picture3</label>
                <input type="file" name="pic3">
            </div>
        </div>

        <div class="col-sm-8 col-md-2 col-md-offset-2 col-sm-offset-2">
          <div class="form-group">
              <a id="addPic">Add a picture</a>
          </div>
        </div>


        <div class="form-group">
            <input id=place_name type="hidden" name="place_name" value="">
            <input id=lat type="hidden" name="lat" value="">
            <input id=lng type="hidden" name="lng" value="">
        </div>

        <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2";>
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

$('#searchTextField').keydown(function() {
    $('#confirm').attr('disabled', true);
});

</script>




<!-- <script src="https://maps.google.com/maps/api/js?key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&language=en&region=ph"></script> -->

<!-- <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&language=en"></script> -->

<!-- <script src="../webroot/assets/js/gmap.js"></script> -->


<script src="../webroot/assets/js/bootstrap.js"></script>
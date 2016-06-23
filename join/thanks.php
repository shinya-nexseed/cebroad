<?php
   // ログイン判定
    if (!isset($_SESSION['id'])) {
      echo '<script> location.replace("/cebroad/index"); </script>';
      exit();
    }
    

   //国籍テーブルから国籍名を取得
      $sql = 'SELECT * FROM `nationalities`';
      $nationalities = mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');

      $sql = sprintf('SELECT * FROM `users` WHERE `id`=%d',
        $_SESSION['id']
        );
      $record = mysqli_query($db, $sql) or die (mysqli_error());
      $user = mysqli_fetch_assoc($record);

    //アップデート処理
    $errors = array();
    $error_messages = array();

    if (!empty($_POST)) {
      //項目が空で送信された場合の処理
      if ($_POST['gender'] === '0') {
        $_POST['gender'] = '';
      }

      if ($_POST['nationality_id'] === '0') {
        $_POST['nationality_id'] = '';
      }



      //画像サイズが送信された場合
    if ($_FILES['profile_picture_path']['error'] === 0) {
        $fileName = $_FILES['profile_picture_path']['name'];
        if (!empty($fileName)) {
            $ext = substr($fileName, -3);
            if ($ext !== 'jpg' && $ext !== 'gif' && $ext !== 'png') {
              $error['profile_picture_path'] = 'type';
            }
        }
    }
      //エラーがなければ
        //画像が選択されていれば
        if(!empty($fileName)) {
          //画像のアップロード
          $picture = date('YmdHis').$_FILES['profile_picture_path']['name'];
          move_uploaded_file($_FILES['profile_picture_path']['tmp_name'],'./users/profile_pictures/'.$picture);
        } else {
          $picture = $user['profile_picture_path'];
        }
    //画像が選択されている場合のアップロード処理
  if(!empty($fileName)) {
        //①更新用sql文
        $sql = sprintf("UPDATE `users` SET `gender`=%d, `profile_picture_path`='%s', `birthday`='%s', `nationality_id`=%d WHERE id=%d",
          mysqli_real_escape_string($db, $_POST['gender']),
          mysqli_real_escape_string($db, $picture),
          mysqli_real_escape_string($db,$_POST['birthday']),
          mysqli_real_escape_string($db, $_POST['nationality_id']),
          mysqli_real_escape_string($db, $_SESSION['id'])
        );
        //echo $sql;

        //②sql文を実行する
        mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');

        //Jcropの画面に遷移させる
        // header('Location: crop');
        echo '<script> location.replace("/cebroad/join/crop"); </script>';


      }

      // header('Location: /cebroad/users/show');
      exit();
      }
?> 
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="panel panel-login">
                <div class="panel-heading">
                  <div class="row">
                    <label id="register-form-link">Thank you for your registration.</label>
                  </div>
                  <hr>
                </div>
                  <div class="col-lg-12">
                    <p>If you want to add your informations,you can add and press the "Add Information" button.</p>
                    <p>If you do not want, please press the "To Event Screen" button. Thank you.</p>
                  </div>
              <div class="panel-body">              
                  <div class="col-lg-12">
                  <form class="thanks-form" id="register-form" action="" method="post" role="form" enctype="multipart/form-data" style="display: block;">

          <!-- プロフィール写真 -->
                  <label class="control-label">Profile Picture</label>
                  <input type="file" name="profile_picture_path" id="profile_picture_path" style="display: none;">
                  <div class="input-group">
                    <input type="text" id="photoCover" class="form-control" placeholder="Select jpg or png(Maximum of 5MB)">
                    <span class="input-group-btn"><button type="button" class="btn btn-cebroad" onclick="$('#profile_picture_path').click();">Browse</button></span>
                  </div>
                  <label id="label" class="cebroad-pink"></label>
                  <div class="events-pad">
                    <img src="" id="preview" style="display:none; width: 300px;">
                  </div>
                  <?php if (isset($error['profile_picture_path']) && $error['profile_picture_path'] === 'type'): ?>
                    <p class="error">* You can choose「.jpg」「.png」file only.</p>
                  <?php endif; ?>

          <!-- 性別 -->
            <div class="form-group">
                  <label class="control-label">Gender</label>
                  <select class="form-control" name="gender">
                    <option value="0">Select Your Gender</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                  </select>
                </div>
          <!-- 誕生日 -->
            <div class="form-group">
                  <label class="control-label">Birthday</label>
                  <input type="date" name="birthday" class="form-control" min="1930-01-01" max="2010-12-31">
                  <!-- placeholder="Example:1990/01/01" -->
                </div>
          <!-- 国籍 -->
          <!-- 国籍テーブルから外部キーとして取得 -->
            <div class="form-group">
              <label class="control-label">Nationality</label>
                  <select class="form-control" name="nationality_id">
                        <option value="0">Select your nationality</option>
                      <?php while ($nationality = mysqli_fetch_assoc($nationalities)) { ?>
                        <option value="<?php echo $nationality['nationality_id']; ?>"><?php echo $nationality['nationality_name']; ?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>

            <div class="col-sm-12 col-md-12 pull-right">
              <input type="submit" class="btn btn-cebroad pull-right" name="register-submit" action='' value="Add Information" onclick="return check()">
            </div>

            <div class="col-sm-12 col-md-12 pull-right" style="padding-top: 20px;">
              <a href="/cebroad/events/index" class="btn btn-cebroad pull-right" onclick="return check2()">To Event Screen</a>
            </div>
        </form>
                </div>
            </div>
          </div>
        </div>
    </div>
<script src="/cebroad/webroot/assets/js/thanks.js"></script>

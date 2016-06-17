<?php 
    // $_SESSION['join']が存在しなければsignup.phpに強制遷移させる
    // if (!isset($_SESSION['join'])) {
    // header('Location: signup');
    // exit();
    // }
 echo $_SESSION['id'];
  $sql = 'SELECT * FROM `nationalities`';
  $nationalities = mysqli_query($db, $sql) or die(mysqli_error($db));

 // ログイン判定
  if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();
    $sql = sprintf('SELECT * FROM `users` WHERE `id`=%d',
      mysqli_real_escape_string($db, $_SESSION['id'])
      );
    $record = mysqli_query($db, $sql) or die (mysqli_error());
    $member = mysqli_fetch_assoc($record);
  } else {
    header('Location: /cebroad/join/signup');
    exit();
  }
  $error = array();
  if (!empty($_POST)) {

    if ($_POST['gender'] === '0') {
      $_POST['gender'] = '';
    }
    if (!isset($_POST['birthday'])) {
      $_POST['birthday'] = '';
    }
    if ($_POST['nationality_id'] === '0') {
      $_POST['nationality_id'] = '';
    }

  //プロフィール写真のエラーチェック
    if ($_FILES['profile_picture_path']['error'] === 0) {
      $fileName = $_FILES['profile_picture_path']['name'];
      if (isset($fileName)) {
          $ext = substr($fileName, -3);
          if ($ext !== 'jpg' && $ext !== 'gif' && $ext !== 'png') {
            $error['peofile_picture_path'] = 'type';

            //move_uploaded_file関数でアップロード
          }
      }
    } else if ($_FILES['profile_picture_path']['error'] === 4) {
      $_FILES['profile_picture_path'] = '';
    }

    

    //エラーがなければ
      if (empty($error)) {
    //フォームからデータが送信された場合
        echo 'エラーなし';
        //①更新用sql文
        $sql = sprintf("UPDATE `users` SET `gender`=%d, `profile_picture_path`='%s', `birthday`='%s', `nationality_id`=%d WHERE id=%d",
          mysqli_real_escape_string($db, $_POST['gender']),
          mysqli_real_escape_string($db, $_FILES['profile_picture_path']),
          mysqli_real_escape_string($db,$_POST['birthday']),
          mysqli_real_escape_string($db, $_POST['nationality_id']),
          mysqli_real_escape_string($db, $_SESSION['id'])
        );
        echo $sql;

      // ②sql文を実行する
      mysqli_query($db, $sql) or die(mysqli_error($db));



    // ③実行時に取得したデータを処理する (SELECTの場合のみ)
    // unset($_SESSION['join']);
    // header('Location: thanks');
    // exit();
      // エラーがない場合
      // if (empty($error)) {
      //   $_SESSION['join'] = $_POST;

      header('Location: /cebroad/users/show');
      exit();
        }
  }
?> 
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="panel panel-login">
                <div class="panel-heading">
                  <div class="row">
                    <a href="#" id="register-form-link"></a>
                  </div>
                  <hr>
                </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-12">
                  <!-- 登録完了を表示 -->
                <div class="form-group">
                <div class="col-sm-10">
                  Thank you for your registration.
                </div>
                </div>
                
        <form id="register-form" action="" method="post" role="form" enctype="multipart/form-data" style="display: block;">
          <!-- プロフィール写真 -->
          <div class="form-group">
            <label class="col-sm-4 control-label">Profile Picture</label>
              <div class="col-sm-8">
                <input type="file" name="profile_picture_path" class="form-control">
                <?php if (isset($error['profile_picture_path']) && $error['profile_picture_path'] === 'type'): ?>
                  <p class="error">* You can choose 「.gif」「.jpg」「.png」file only.</p>
                <?php endif; ?>
              </div>
          </div>

          <!-- 性別 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">Gender</label>
                <div class="col-sm-10">
                  <select class="form-control" name="gender">
                    <option value="0">Select Your Gender</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                  </select>
                </div>
            </div>
          <!-- 誕生日 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">Birthday</label>
                <div class="col-sm-10">
                  <input type="date" name="birthday" class="form-control">
                  <!-- placeholder="Example:1990/01/01" -->
                </div>
            </div>
          <!-- 国籍 -->
          <!-- 国籍テーブルから外部キーとして取得 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">Nationality</label>
                <div class="col-sm-10">
                  <select class="form-control" name="nationality_id">
                        <option value="0">Select your nationality</option>
                      <?php while ($nationality = mysqli_fetch_assoc($nationalities)) { ?>
                        <option value="<?php echo $nationality['nationality_id']; ?>"><?php echo $nationality['nationality_name']; ?></option>
                      <?php } ?>
                  </select>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
              <input type="submit" class="btn btn-register"  name="register-submit" action='' value="Add Information">
            </div>
        </form> 
                  <div class="col-md-6 col-md-offset-3">
                    <a href="/cebroad/events/index" class="btn btn-register">EVENTS</a>
                  </div>
                </div>
              </div>   
            </div>
          </div>
        </div>
      </div>
    </div>
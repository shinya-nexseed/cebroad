<?php 
  if (!empty($_POST)) {

  $fileName = $_FILES['profile_picture_path']['name'];
  if (isset($fileName)) {
      $ext = substr($fileName, -3);
      if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
        $error['peofile_picture_path'] = 'type';
      }
    }

    // エラーがない場合
    if (empty($error)) {
      $_SESSION['join'] = $_POST;
      header('Location: ../users/show');
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
                <center>Thank you for your registration.
                <br><br>
        <form id="register-form" action="" method="post" role="form" style="display: block;">
          <!-- プロフィール写真 -->
          <div class="form-group">
            <label class="col-sm-4 control-label">Profile Picture</label>
            <div class="col-sm-8">
              <input type="file" name="profile_picture_path" class="form-control">
              <?php if (isset($error['profile_picture_path']) && $error['profile_picture_path'] == 'type'): ?>
                <p class="error">* You can choose 「.gif」「.jpg」「.png」file only.</p>
              <?php endif; ?>
              <?php if (!empty($error)): ?>
                <p class="error">* Sorry. Please choose picture again.</p>
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
                <input type="date" name="age" class="form-control">
                <!-- placeholder="Example:1990/01/01" -->
              </div>
            </div>
          <!-- 国籍 -->
          <!-- 国籍テーブルから外部キーとして取得 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">Nationality</label>
              <div class="col-sm-10">
                <select class="form-control" name="gender">
                  <option value="0">Select Your Nationality</option>
                  <option value="1">Japan</option>
                  <option value="2">Korea</option>
                  <option value="3">Taiwan</option>
                  <option value="4">China</option>
                </select>
              </div>
            </div>

            
            	<input type="submit" class="btn btn-register"  name="register-submit" value="Add Information">
              <br><br>
              <a href="">
              <button name="events" class="btn btn-register">EVENTS</button>
            </a>
            </center>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
<?php 
// メモ
// join/register(メールアドレス登録)→pre_thanks→signup→check→thanks
if ($id === '0' || $id === '') {
  echo '<script> location.replace("/portfolio/cebroad/index"); </script>';
  exit();
} 
// else {
//   echo $id;
// }

if ($id === 'rewrite') {
  $mail = $_SESSION['join']['email'];
} else {
  $sql = sprintf('SELECT * FROM `pre_users` WHERE urltoken="%s"',
    mysqli_real_escape_string($db, $id)
    );
  $rtn = mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');

  $pre_user = mysqli_fetch_assoc($rtn);
  $mail = $pre_user['email'];
  $confirmed_flag = $pre_user['confirmed_flag']; // 0か1

  if ($confirmed_flag === '1') {
  exit('<h1>This URL is invalid.</h1>');
  }
}

// if(isset($school)){
  $sql = 'SELECT * FROM `schools`';
  $schools = mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');
// }
  //フォームからデータが送信された場合(ボタンが押されたときに発動)
  if(!empty($_POST)){
    //エラー項目の確認
    if($_POST['nick_name'] === ''){
    $error['nick_name'] = 'blank';
    }

    if($_POST['password'] === ''){
      $error['password'] = 'blank';
      //パスワードが4文字以上か？↓
    } else if(strlen($_POST['password']) < 4){
      $error['password'] = 'length';
    }
    if(($_POST['password']) !== ($_POST['confirm_password'])){
      $error['confirm_password'] = 'incorrect';
    }
    if($_POST['school_id'] === '0'){
      $error['school_id'] = 'not_selected';
    }

  // 重複アカウントのチェック
  // if (isset($_POST['email']) && empty($error)) {
  //   $sql = sprintf(
  //         'SELECT COUNT(*) AS cnt FROM users WHERE email="%s"',
  //         mysqli_real_escape_string($db,$_POST['email'])
  //       );
  //       $record = mysqli_query($db,$sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');
  //       $table = mysqli_fetch_assoc($record);
  //       // もし$table['cnt']が1以上を返せば、アカウントが重複しているとみなして$errorを生成する
  //       if ($table['cnt'] > 0) {
  //           $error['email'] = 'duplicate';
  //       }
  // }
  // エラーがない場合
    if (empty($error)) {
      $_SESSION['join'] = $_POST;
      $_SESSION['join']['email'] = $mail;
      echo '<script> location.replace("/portfolio/cebroad/join/check"); </script>';
      exit();
    }
  }

//書き直し　http://192.168.33.10/seed_sns/join/signup?action=rewrite
    if (isset($id) && $id === 'rewrite') {//上記のパラメーターがあれば

      $_POST = $_SESSION['join'];
      $mail = $_SESSION['join']['email'];
      $_POST['password'] = '';
      $_POST['confirm_password'] = '';
      $error['rewrite'] = true;
    }

?>
  
      <div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="panel panel-login">
                <div class="panel-heading">
                  <div class="row">
                    <a href="#" id="register-form-link">SIGNUP</a>
                  </div>
                  <hr>
                </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-12">
                  <form id="register-form" action="" method="post" role="form" style="display: block;">
                    <!--ニックネーム-->
                      <div class="form-group">
                        <?php if(isset($_POST['nick_name'])): ?>
                          <input type="text" name="nick_name" id="nick_name" tabindex="1" class="form-control" placeholder="Nickname" value="<?=h($_POST['nick_name'])?>">
                        <?php else: ?>
                          <input type="text" name="nick_name" id="nick_name" tabindex="1" class="form-control" placeholder="Nickname" value="">
                        <?php endif; ?>
                        <!-- ニックネームが空欄だったら -->
                        <?php if(isset($error['nick_name']) && $error['nick_name'] === 'blank'): ?>
                          <p class="error">* Please input your Nickname.</p>
                        <?php endif; ?>
                      </div>
                    <!--メールアドレス-->
                      <p>email：<?=h($mail)?></p>
                    <!--パスワード-->
                      <div class="form-group">
                        <?php if(isset($_POST['password'])): ?>
                          <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="<?=h($_POST['password'])?>">
                        <?php else: ?>
                          <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="">
                        <?php endif; ?>
                        <?php if(isset($error['password']) && $error['password'] === 'blank'): ?>
                          <p class="error">* Please input Password.</p>
                        <?php endif; ?>
                        <?php if(isset($error['password']) && $error['password'] === 'length'): ?>
                         <p class="error">* Please input Password more than 4 letters.</p>
                        <?php endif; ?>
                      </div>
                    <!--2つのパスワードが一致するか確認-->
                      <div class="form-group">
                        <?php if(isset($_POST['confirm_password'])): ?>
                          <input type="password" name="confirm_password" id="confirm_password" tabindex="2" class="form-control" placeholder="Confirm Password" value="<?=h($_POST['confirm_password'])?>">
                        <?php else: ?>
                            <input type="password" name="confirm_password" id="confirm_password" tabindex="2" class="form-control" placeholder="Confirm Password" value="">
                        <?php endif; ?>
                        <?php if(isset($error['confirm_password']) && $error['confirm_password'] === 'blank'): ?>
                          <p class="error">* Please input Password.</p>
                        <?php endif; ?>
                        <?php if (isset($error['confirm_password']) && $error['confirm_password'] === 'incorrect'): ?>
                          <p class="error">* The 2 Passwords do not match.</p>
                        <?php endif; ?>
                      </div>
                      <!--学校名-->
                      <div class="form-group">
                        <select type="" class="form-control" name="school_id">
                        <option value="0">Select your school</option>

                      <?php while ($school = mysqli_fetch_assoc($schools)): ?>
                        <option value="<?=h($school['id'])?>" <?php if (isset($_POST['school_id']) && $school['id'] === $_POST['school_id']) {
                          echo 'selected';
                          } ?>><?=h($school['name'])?></option>
                      <?php endwhile; ?>

                        </select>
                      <?php if (isset($error['school_id']) && $error['school_id'] === 'not_selected'): ?>
                          <p class="error">* Please select your school's name.</p>
                      <?php endif; ?>
                     </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-6 col-sm-offset-3">
                            <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-cebroad" value="CHECK">
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

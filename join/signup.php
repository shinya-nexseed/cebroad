<?php 
  // require('dbconnect.php');

  //セッションを使うページに必ず入れる
  // session_start();

  // $error = Array();

  //フォームからデータが送信された場合
  //ボタンが押されたときに発動
  if(!empty($_POST)){

    //エラー項目の確認
    if($_POST['nick_name'] == ''){
    $error['nick_name'] = 'blank';
    }
    if ($_POST['email'] == ''){
      $error['email'] = 'blank';
    }
    if($_POST['password'] == ''){
      $error['password'] = 'blank';
      //パスワードが4文字以上か？↓
    } else if(strlen($_POST['password']) < 4){
      $error['password'] = 'length';
    }
  }

  //htmlspecialcharsのショートカット
  function h($value){
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }
?>
    <!-- Bootstrap -->
    <link href="../webroot/assets/css/bootstrap.css" rel="stylesheet">
    <link href="../webroot/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../webroot/assets/css/form.css" rel="stylesheet">
    <link href="../webroot/assets/css/timeline.css" rel="stylesheet">
    <link href="../webroot/assets/css/signup.css" rel="stylesheet">
    <link href="../webroot/assets/css/main.css" rel="stylesheet">
  
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
                        <input type="text" name="nick_name" id="nick_name" tabindex="1" class="form-control" placeholder="Nickname" value="<?php echo h($_POST['nick_name']); ?>">
                      <?php else: ?>
                        <input type="text" name="nick_name" id="nick_name" tabindex="1" class="form-control" placeholder="Nickname" value="">
                      <?php endif; ?>
                      <!-- ニックネームが空欄だったら -->
                      <?php if(isset($error['nick_name']) && $error['nick_name'] == 'blank'): ?>
                        <p class="error">＊Please type your Nicknake.</p>
                      <?php endif; ?>
                      </div>
                    <!--メールアドレス-->
                      <div class="form-group">
                      <?php if (isset($_POST['email'])): ?>
                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="<?php echo h($_POST['email']); ?>">
                        <?php else: ?>
                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
                        <?php endif; ?>
                      <!-- メールアドレスが空欄だったら -->
                      <?php if(isset($error['email']) && $error['email'] == 'blank'): ?>
                        <p class="error">＊Please type your Email Address.</p>
                      <?php endif; ?>
                      </div>
                    <!--パスワード-->
                      <div class="form-group">
                      <?php if(isset($_POST['password'])): ?>
                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="<?php echo h($_POST['password']); ?>">
                      <?php else: ?>
                          <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="">
                      <?php endif; ?>
                      <?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
                        <p class="error">＊Please type Password.</p>
                      <?php endif; ?>
                      <?php if(isset($error['password']) && $error['password'] == 'length'): ?>
                         <p class="error">＊Please type Password more than 4 letters.</p>
                      <?php endif; ?>
                      </div>

                      <div class="form-group">
                      <?php if(isset($_POST['password'])): ?>
                        <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" value="<?php echo h($_POST['password']); ?>">
                      <?php else: ?>
                          <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" value="">
                      <?php endif; ?>
                      <?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
                        <p class="error">＊Please type Password.</p>
                      <?php endif; ?>
                      </div>
                     
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-6 col-sm-offset-3">
                            <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="CONFIRM">
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
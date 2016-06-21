<?php 
header("Content-type: text/html; charset=utf-8");
 
//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['join']['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['join']['token'];
 
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');



  //htmlspecialcharsのショートカット
  function h($value){
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }
$error = Array();
if (!empty($_POST)) {
    if ($_POST['email'] === '') {
      $error['email'] = 'blank';

        //メール入力判定
    }else{
      if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])){
        $error['email'] = 'type';
      }
      
      /*
      ここで本登録用のmemberテーブルにすでに登録されているemailかどうかをチェックする。
      $errors['member_check'] = "このメールアドレスはすでに利用されております。";
      */
    }

    if (empty($error)) {
      $sql = sprintf('SELECT COUNT(*) AS cnt FROM pre_users WHERE email="%s"',mysqli_real_escape_string($db, $_POST['email']));//%sの中には入力したメアド
      $record = mysqli_query($db, $sql) or die(mysqli_error($db));
      $table = mysqli_fetch_assoc($record);

      //　上の実行文で何をしているか
      // echo $table;
      // $table = array('COUNT(*)'=> '1');
      // $table = array('cnt'=> '1');　count(*)を簡易に

      // もし$table['cnt']が１以上を返せば、アカウントが重複しているとみなして$errorを生成する
      if ($table['cnt'] > 0) {
        $error['email'] = 'duplicate';
      } else {
        $_SESSION['join'] = $_POST;
        header('Location: regist_end');
      }
    }
  }
?>
 
<!--メールアドレス-->
  <!-- <div class="container">
    <div class="row">
      <div class="col-sm-8 col-md-8 col-sm-offset-2 col-md-offset-2">
        <h1>email registration screen</h1>
                        
            </div>
 
            <input type="hidden" name="token" value="<?=$token?>">
      <div class="col-sm-1 col-md-1 col-sm-offset-2 col-md-offset-2">
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Confirm">
            </div>
      </div>
    </div>
  </div>
 
</form> --> 
  
       <div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="panel panel-login">
                <div class="panel-heading">
                  <div class="row">
                    <a href="#" id="register-form-link">EMAIL REGISTRATION</a>
                  </div>
                  <hr>
                </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-12">
                  <form id="register-form" action="" method="post" role="form" style="display: block;">
                    <!--メールアドレス-->
                        <div class="form-group">
                        <?php if (isset($_POST['email'])): ?>
                          <input type ="email" name="email" id="email" tabindex="1" class="form-control" placeholder="ex:cebroad@mail.com" value="<?=h($_POST['email'])?>">
                        <?php else: ?>
                          <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="ex:cebroad@mail.com" value="">
                        <?php endif; ?> 
                        <!-- メールアドレスが空欄だったら -->
                        <?php if(isset($error['email']) && $error['email'] === 'blank'): ?>
                          <p class="error">* Please input your Email Address.</p>
                        <?php endif; ?>
                        <!--すでにメールアドレスが存在していたら-->  
                        <?php if (isset($error['email']) && $error['email'] === 'duplicate'): ?>
                          <p class="error">* This Email Address already exists.</p>
                        <?php endif; ?>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-6 col-sm-offset-3">
                            <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-cebroad" value="CONFIRM">
                            <input type="hidden" name="token" value="<?=$token?>">
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
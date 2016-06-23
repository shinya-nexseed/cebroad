<?php
require('dbconnect.php');

session_start();

// $_SESSION = array();//セッションの初期化（リダイレクト処理確認時のデバッグに使用）

//自動ログイン処理
// if(isset($_COOKIE['email']) && $_COOKIE['email'] !== '') {
//   $_POST['email'] = $_COOKIE['email'];
//   $_POST['password'] = $_COOKIE['password'];
//   $_POST['save'] = 'on';
// }
$errors = array();
//ログインボタンを押した際に読まれる
if(!empty($_POST)) {

  if (empty($_POST['email'])) {
    $errors['email'] = '*Please input your email address.';
  }
  if (empty($_POST['password'])) {
    $errors['password'] = '*Please input your password.';
  }


  if (count($errors) === 0) {
		//emailとパスワードが入力された値と一致するデータをSELECT文で取得
		$sql = sprintf('SELECT * FROM users WHERE email="%s" AND password="%s"',
			mysqli_real_escape_string($db, $_POST['email']),
			mysqli_real_escape_string($db, sha1($_POST['password'])));
		$record = mysqli_query($db, $sql) or die ('<h1>Sorry, something wrong happened. please retry.</h1>');

		//SELECT文で取得したデータが存在するかどうかで条件分岐している
		if($table = mysqli_fetch_assoc($record)) {
			//データが存在したときログイン成功
			$_SESSION['id'] = $table['id'];//次のページでログイン判定をするために使用するidをSESSIONで管理
			//$_SESSION['time'] = time();
			

      //ログイン情報を記録する
      // if(isset($_POST['save']) && $_POST['save'] === 'on') {
      //   //cookieはsetcookie関数を使用して、
      //   //保持する値と保持したい期間を引数に与える
      //   setcookie('email',$_POST['email'],time()+60*60*24*14);//期間は14日間
      //   setcookie('password',$_POST['password'],time()+60*60*24*14);
      //   //【関数】setcookie('キー',値、期限)
      //   //↓
      //   //$_COOKIE = array('email'=>$_POST['email'],'password'=>$_POST['password']);
      // }

      // header('Location: events/index');
      echo '<script> location.replace("/cebroad/events/index"); </script>';

      exit();
    } else {
      $errors['login'] = '*You failed to sign in. Please check your email address and password.';
    }
  }
}

  

  function h($value){
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cebroad</title>

    <!-- Bootstrap -->
    <link href="/cebroad/webroot/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/cebroad/webroot/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/cebroad/webroot/assets/css/form.css" rel="stylesheet">
    <link href="/cebroad/webroot/assets/css/timeline.css" rel="stylesheet">
    <link href="/cebroad/webroot/assets/css/signup.css" rel="stylesheet">
    <link href="/cebroad/webroot/assets/css/main.css" rel="stylesheet">
    <!--
      designフォルダ内では2つパスの位置を戻ってからcssにアクセスしていることに注意！
     -->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body>
 
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-md-8 col-lg-8 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
              <div class="panel panel-login">
                <div class="panel-heading">
                  <div class="row">
                    <a href="#" id="register-form-link">SIGNIN</a>
                  </div>
                  <hr>
                </div>
              <div class="panel-body">

                  <form id="register-form" action="" method="post" role="form" style="display: block;">
                  <p>If you do not register yet, please register.</p>
                  <p>&raquo;  <a href="/cebroad/join/regist_form">TO THE REGISTERATION SCREEN</a></p>
                  <br>
                  <h3>Please input your Email address and password to sign in ♪</h3>
                    <!--メールアドレス-->
                      <div class="form-group">

                          <?php if(!empty($_POST['email'])):?>
                            <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="ex:cebroad@mail.com" value="<?=h($_POST['email'])?>" required>
                          <?php else: ?>
                            <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="ex:cebroad@mail.com" required>
                          <?php endif; ?>

                          <?php if(!empty($errors['email'])):?>
                            <p class="error"><?php echo $errors['email'];?></p>
                          <?php endif;?>
                      </div>
                    <!--パスワード-->
                      <div class="form-group">
                        <?php if (!empty($_POST['password'])): ?>
                          <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="<?=h($_POST['password'])?>" required>
                        <?php else: ?>
                          <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required>
                        <?php endif; ?>

                        <?php if(!empty($errors['password'])):?>
                            <p class="error"><?php echo $errors['password'];?></p>
                          <?php endif;?>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-8 col-md-8 col-lg-8 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
                            <?php if (!empty($errors['login'])): ?>
                              <label class="error"><?=$errors['login']?></label>
                            <?php endif; ?>
                            <button type="submit" name="register-submit" id="register-submit" class="form-control btn btn-cebroad" value="check">SIGN IN</button>
                          </div>
                        </div>
                      </div>
                    </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/cebroad/webroot/assets/js/bootstrap.min.js"></script>
  </body>
</html>

<?php 

	// $_SESSION['join']が存在しなければindex.phpに強制遷移させる
  	if (!isset($_SESSION['join'])) {
   	header('Location: signup');
   	exit();
  	}

// signupからpostで持ってきたschool_idの値を使用してselect文作成
	$sql = sprintf('SELECT * FROM schools WHERE school_id=%d',
		mysqli_real_escape_string($db, $_SESSION['join']['school_id'])
		);
	$rtn = mysqli_query($db, $sql) or die(mysqli_error($db));

// $school_nameに上記のsql文で取得したschool_name一件を代入
	$school = mysqli_fetch_assoc($rtn);
	$school_name = $school['school_name'];


if (!empty($_POST)) {
	 // ①登録用sql文
    $sql = sprintf('INSERT INTO `users` SET `nick_name`="%s", `email`="%s", `password`="%s", `school_id`=%d, created=NOW()',
        mysqli_real_escape_string($db, $_SESSION['join']['nick_name']),
        mysqli_real_escape_string($db, $_SESSION['join']['email']),
        mysqli_real_escape_string($db, sha1($_SESSION['join']['password'])),
        mysqli_real_escape_string($db, $_SESSION['join']['school_id'])
      );

    // ②sql文を実行する
    if(mysqli_query($db, $sql)) {
       //true
      if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    //$_SESSIONに保存している時間更新
    $_SESSION['time'] = time();//このコードが無ければ、ログイン後、一時間経つと勝手にログイン画面に遷移してしまう。毎回、リセットしてあげる必要。
    //ログインしているユーザーのデータをDBから取得（$_SESSION['id']を使用して）
    $sql = sprintf('SELECT * FROM users WHERE id=%d', mysqli_real_escape_string($db, $_SESSION['id'])
      );
    $record = mysqli_query($db, $sql) or die(mysqli_error($db));
    $member = mysqli_fetch_assoc($record);

   }
    } else {
      //sqlが正しく実行されず、データが入力されなかった場合
      header('Location: /cebroad/index');
      exit();
    }


    // ③実行時に取得したデータを処理する (SELECTの場合のみ)
    unset($_SESSION['join']);
    header('Location: thanks');
    exit();
 }

  //htmlspecialcharsのショートカット
  function h($value){
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }
?>
      <div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="panel panel-login">
                <div class="panel-heading">
                  <div class="row">
                    <a href="#" id="register-form-link">CHECK</a>
                  </div>
                  <hr>
                </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-12">
                  <!-- 登録内容を表示 -->
            <table class="table">
                <tr>
                  <td><div class="text-center">Nickname</div></td>
                  <td><div class="text-center"><?php echo h($_SESSION['join']['nick_name']); ?></div></td>
                </tr>
                <tr>
                  <td><div class="text-center">Email Address</div></td>
                  <td><div class="text-center"><p>email：<?=h($_SESSION['join']['email'])?></p></div></td>
                </tr>
                <tr>
                  <td><div class="text-center">Password</div></td>
                  <td><div class="text-center">●●●●●●●●</div></td>
                </tr>
                <tr>
                  <td><div class="text-center">School Name</div></td>
                  <td><div class="text-center"><?php echo h($school_name); ?></div></td>
                </tr>
            </table>
                    <center>
                      <a href="/cebroad/join/signup/rewrite">Rewrite</a>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-6 col-sm-offset-3">
                            <form method="post">
                      	       <input type="submit" name="check-submit" id="check-submit" tabindex="4" class="form-control btn btn-register" value="Register">
                            </form>
                          </div>
                        </div>
                      </div>
                    </center>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
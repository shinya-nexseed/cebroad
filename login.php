<?php
require('dbconnect.php');

session_start();

// $_SESSION = array();//セッションの初期化（リダイレクト処理確認時のデバッグに使用）

//自動ログイン処理
if(isset($_COOKIE['email'])&&$_COOKIE['email']!=''){
  $_POST['email']=$_COOKIE['email'];
  $_POST['password']=$_COOKIE['password'];
  $_POST['save']='on';
}

//ログインボタンを押した際に読まれる
if(!empty($_POST)){
	//ログインの処理

	//二つのフォームに値が入力されていれば読まれる
	if($_POST['email']!='' && $_POST['password']!=''){

		//emailとパスワードが入力された値と一致するデータをSELECT文で取得
		$sql = sprintf('SELECT * FROM members WHERE email="%s" AND password="%s"',
			mysqli_real_escape_string($db, $_POST['email']),
			mysqli_real_escape_string($db, sha1($_POST['password'])));
		$record = mysqli_query($db, $sql) or die (mysqli_error($db));

		//SELECT文で取得したデータが存在するかどうかで条件分岐している
		if($table = mysqli_fetch_assoc($record)){
			//データが存在したときログイン成功
			$_SESSION['id']=$table['member_id'];//次のページでログイン判定をするために使用するidをSESSIONで管理
			$_SESSION['time']=time();
			

      //ログイン情報を記録する
      if(isset($_POST['save'])&&$_POST['save']=='on'){
        //cookieはsetcookie関数を使用して、
        //保持する値と保持したい期間を引数に与える
        setcookie('email',$_POST['email'],time()+60*60*24*14);//期間は14日間
        setcookie('password',$_POST['password'],time()+60*60*24*14);
        //【関数】setcookie('キー',値、期限)
        //↓
        //$_COOKIE = array('email'=>$_POST['email'],'password'=>$_POST['password']);
      }

      header('Location: events/index');
      exit();


		}else{
			//データが存在しないときログイン失敗
			$error['login']='failed';
		}
	} else{//データが入力されていないとき
		$error['login']='blank';
	}
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
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
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
      <div class="col-md-6 col-md-offset-3 content-margin-top">
        <legend>ログイン</legend>
        <form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
        	<div id="lead">
				<p>メールアドレスとパスワードを記入してログインしてください。</p>
				<p>入会手続きがまだの方はこちらからどうぞ。</p>
				<p>&raquo;<a href="join/">入会手続きをする</a></p>
			</div>
          <!-- メールアドレス -->
          <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
            <input type="text" name="email" size="35" maxlength="255" <?php if(!empty($_POST['email'])){?>value="<?php echo htmlspecialchars($_POST['email']);?>"<?php }?>/>
			<?php if(isset($error['login'])&&$error['login']=='blank'):?>
				<p class="error">メールアドレスとパスワードをご記入ください</p>
			<?php endif;?>
			<?php if(isset($error['login'])&&$error['login']=='failed'):?>
				<p class="error">*ログインに失敗しました。正しくご記入ください。</p>
			<?php endif;?>
            </div>
          </div>
          <!-- パスワード -->
          <div class="form-group">
            <label class="col-sm-4 control-label">パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" size="35" maxlength= "255" <?php if(!empty($_POST['password'])){?>value="<?php echo htmlspecialchars($_POST['password']);?>"<?php }?>/>
            </div>
          </div>
          
          <input id="save" type="checkbox" name="save" value="on"><label for="save">次回からは自動的にログインする</label><br />
          <input type="submit" class="btn btn-default" value="ログインする">
        </form>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

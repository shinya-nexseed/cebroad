<?php
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
	$_SESSION['time'] = time();
}

//ユーザー情報取得
$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
	);
$record = mysqli_query($db, $sql) or die ('<h1>Sorry, something wrong happened. please retry.</h1>');
$user = mysqli_fetch_assoc($record); 

//フォームからデータが送信された場合
$error = Array();
if(!empty($_POST)){
//エラー項目の確認
//Emailアドレスの空チェック
	if ($_POST['email'] == ''){
		$error['email'] = 'blank';	
	}

//正規表現チェック
	if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD', $_POST['email'])){
		$error['email'] = 'regex'; 
	}

//$subjectのなかに半角スペースが含まれていないかチェック
	if(preg_match('/ /',$_POST['email'])){ 
		$error['email'] = 'space'; 
	}

//$subjectのなかに全角スペースが含まれていないかチェック
	if(preg_match('/　/',$_POST['email'])){ 
		$error['email'] = 'capital_space';
	}

//入力されたアドレスとDBのアドレスが一致するかチェック
	if(sha1($_POST['password']) !== $user['password']){
		$error['password'] = 'incorrect'; 
	}
}

//重複アカウントのチェック
if(!empty($_POST) && empty($error)){
	if ($_POST['email'] != $user['email']){
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM `users` WHERE `email`= "%s"', mysqli_real_escape_string($db, $_POST['email'])
			);
		$record = mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');
		$table = mysqli_fetch_assoc($record); 

		if($table['cnt'] > 0){
			$error['email'] = 'duplicate'; 
		}
	}
}

//エラーがなければ
if (!empty($_POST) && empty($error)){
//アップロード処理
	$sql = sprintf('UPDATE `users` SET `email`= "%s", modified = NOW() WHERE `id`=%d',
		mysqli_real_escape_string($db, $_POST['email']),
		mysqli_real_escape_string($db, $_SESSION['id'])
		);
//SQL文実行
	mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');
// header('Location:show');
}

//ユーザー情報取得
$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
	);
$record = mysqli_query($db, $sql) or die ('<h1>Sorry, something wrong happened. please retry.</h1>');
$user = mysqli_fetch_assoc($record); 

?>

<!-- 以下application.php内で表示 -->
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-9 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad"> 
			<form method="post" action="" role="form" enctype="multipart/form-data">
				<div class="panel-body">
					<div class="row">
						<div class=" col-md-3 col-lg-3" align="center"> 
							<img alt="User Pic" src="/portfolio/cebroad/views/users/profile_pictures/<?php echo h($user['profile_picture_path']); ?>" class="img-responsive"><br>
							<div class="list-group">
								<a class="list-group-item" href="edit">Basic info.</a>
								<a class="list-group-item" href="edit_password">Password</a>
								<a class="list-group-item" href="edit_email">Email</a>
							</div>
						</div>
						<div class="col-sm-12 col-md-9 col-lg-9"> 
							<table class="table table-user-information">
								<tbody>
									<tr>
										<td>Email:</td>
										<td><?php if(isset($user['email'])): ?>
											<input type="email" name="email" class="form-control" value="<?php echo h($user['email']); ?>">
										<?php else: ?>
											<input type="email" name="email" class="form-control" placeholder="例： kon@gmail.com" value="" ?>
										<?php endif; ?>
										<?php if(isset($error['email']) && $error['email'] == 'blank'): ?>
											<p class="error">＊Please input your email address</p>
										<?php endif; ?>
										<?php if(isset($error['email']) && $error['email'] == 'duplicate'): ?>
											<p class="error">* The email address is already in use</p>
										<?php endif; ?>
										<?php if(isset($error['email']) && $error['email'] == 'regex'): ?>
											<p class="error">* Your email address has an invalid email address format. Please correct and try again.</p>
										<?php endif; ?>
										<?php if(isset($error['email']) && $error['email'] == 'space'): ?>
											<p class="error">* Your email address has an invalid email address format. Please correct and try again.</p>
										<?php endif; ?>
										<?php if(isset($error['capital_space']) && $error['email'] == 'regex'): ?>
											<p class="error">* Your email address has an invalid email address format. Please correct and try again.</p>
										<?php endif; ?>
									</td> 
									</tr>
									<rt>
										<td>Password:</td>
										<td>
											<input type="password" name="password" class="form-control" placeholder="" value="">
											<?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
												<p class="error">＊Please input the current password</p>
											<?php endif; ?>
											<?php if(isset($error['password']) && $error['password'] == 'incorrect'): ?>
												<p class="error">＊Please check that you've entered and confirmed your password</p>
											<?php endif; ?>
										</td> 
									</rt>
									<tr>
										<td>
											<br>
											<input type="submit" class="btn btn-cebroad" value="update" align="" onclick="gate();">
										</td>
									</tr>
								</tbody>
							</table>			                 
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div> 

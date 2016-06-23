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
//パスワードの空チェック
	if($_POST['password'] == ''){
		$error['password'] = 'blank';
	}
//新しいパスワードの空チェック
	if($_POST['password_new'] == ''){
		$error['password'] = 'blank';
	}

//入力されたアドレスとDBのアドレスが一致するかチェック
	if(sha1($_POST['password']) !== $user['password']){
		$error['password'] = 'incorrect'; 
	} 
}

//エラーがなければ
if (!empty($_POST) && empty($error)){	    
//アップロード処理
	$sql = sprintf('UPDATE `users` SET `password`= "%s", modified = NOW() WHERE `id`=%d',
		mysqli_real_escape_string($db, sha1($_POST['password_new'])),
		mysqli_real_escape_string($db, $_SESSION['id'])
		);
//SQL文の実行
	mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');
// header('Location:show');
}

//ユーザー情報取得
$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
	);
$record = mysqli_query($db, $sql) or die ('<h1>Sorry, something wrong happened. please retry.</h1>');
$user = mysqli_fetch_assoc($record); 

?>

<!-- Javascriptでのパスワードチェック -->
<script type="text/javascript">
	function checkForm(){
		if(form.password_new.value != "" && form.password_new.value == form.password_confirm.value) {
//4文字以上チェック
if(form.password_new.value.length =< 4) {
	alert("Error: Password must contain at least four characters");
	form.password_new.focus();
	return false;
}
//20文字以下チェック
if(form.password_new.value.length >= 20) {
	alert("Error: Password must be less than twenty characters");
	form.password_new.focus();
	return false;
}
//数字が1文字以上含まれているかチェック
re = /[0-9]/;
if(!re.test(form.password_new.value)) {
	alert("Error: password must contain at least one number (0-9)");
	form.password_new.focus();
	return false;
}
//小文字が1文字以上含まれているかチェック
re = /[a-z]/;
if(!re.test(form.password_new.value)) {
	alert("Error: password must contain at least one lowercase letter (a-z)");
	form.password_new.focus();
	return false;
}
//大文字が1文字以上含まれているかチェック
re = /[A-Z]/;
if(!re.test(form.password_new.value)) {
	alert("Error: password must contain at least one uppercase letter (A-Z)");
	form.password_new.focus();
	return false;
}
//新しいパスワードと確認パスワードが一致しない場合
} else {
	alert("Error: Please check that you've entered and confirmed your password");
	form.password_new.focus();
	return false;
}
//エラーがない場合
alert("You entered a valid password: " + form.password_new.value);
return true;
}
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-9 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad">
			<!-- form送信時にonsubmitでjsの関数発動 -->
			<form name="form" method="post" onsubmit="return checkForm();" role="form" enctype="multipart/form-data" >
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
										<td>Current password:</td>
										<td>
											<input type="password" name="password" class="form-control" placeholder="" value="">
											<?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
												<p class="error">＊Please enter your current password</p>
											<?php endif; ?>
											<?php if(isset($error['password']) && $error['password'] == 'incorrect'): ?>
												<p class="error">＊Please check that you've entered and confirmed your password</p>
											<?php endif; ?>
										</td> 
									</tr>
									<tr>
										<td>New password:</td>
										<td>
											<input type="password" name="password_new" class="form-control" placeholder="" value="">
											<?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
												<p class="error">＊Please enter new password</p>
											<?php endif; ?>
										</td> 
									</tr>
									<tr>
										<td>Confirm new password:</td>
										<td>
											<input type="password" name="password_confirm" class="form-control" placeholder="" value="">
											<?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
												<p class="error">＊Please confirm new password</p>
											<?php endif; ?>
											<?php if(isset($error['password']) && $error['password'] == 'length'): ?>
												<p class="error">＊Password must contain at least four characters! </p>
											<?php endif; ?>
											<?php if(isset($error['contradiction']) == 'contradiction'): ?>
												<p class="error">＊Please check that you've entered and confirmed your password</p>
											<?php endif; ?>				                        
										</td> 
									</tr>
									<tr>
										<td>
											<br>
											<input type="submit" class="btn btn-cebroad" value="update" align="">
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

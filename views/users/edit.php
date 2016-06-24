<?php
   if (!isset($_SESSION['id'])) {
   		echo '<script> location.replace("/portfolio/cebroad/home"); </script>';
   		exit();
	}

//ユーザー情報取得
$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d',$_SESSION['id']
	);
$record = mysqli_query($db, $sql) or die ('<h1>Sorry, something wrong happened. please retry.</h1>');
$user = mysqli_fetch_assoc($record);
//フォームからデータが送信された場合
$error = Array();
if(!empty($_POST)) {
//エラー項目の確認
	if(isset($_POST['nick_name'])) {
		if ($_POST['nick_name'] === '') {
			$error['nick_name'] = 'blank';
		}
	} else {
		$error['nick_name'] = 'blank';
	}
	if (empty($_POST['gender'])){
		$error['gender'] = 'blank';
	}
}
//画像ファイルが送信された場合
if(!empty($_FILES)){
	$fileName = $_FILES['profile_picture_path']['name'];
	if (!empty($fileName)) {
		$ext = substr($fileName, -3);
		if ($ext != 'jpg' && $ext && $ext != 'png') {
			$error['profile_picture_path'] = 'type';
		}
	}
}
//エラーがない場合
if (!empty($_POST) && empty($error)){
//画像が選択されていれば
	if(!empty($fileName)){
//画像のアップロード
		$picture = date('YmdHis').$_FILES['profile_picture_path']['name'];
		move_uploaded_file($_FILES['profile_picture_path']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/portfolio/cebroad/views/users/profile_pictures/'.$picture);
	} else {
		$picture = $user['profile_picture_path'];
	}
//画像が選択されている場合のアップロード処理
	if(!empty($fileName)){
		$sql = sprintf('UPDATE `users` SET `nick_name`="%s", `school_id`=%d, gender="%s", `profile_picture_path`="%s", `introduction`="%s", `birthday`="%s", `nationality_id`=%d, modified = NOW() WHERE `id`=%d',
			mysqli_real_escape_string($db, $_POST['nick_name']), 
			mysqli_real_escape_string($db, $_POST['school_id']),
			mysqli_real_escape_string($db, $_POST['gender']),
			mysqli_real_escape_string($db, $picture),
			mysqli_real_escape_string($db, $_POST['introduction']),
			mysqli_real_escape_string($db, $_POST['birthday']),
			mysqli_real_escape_string($db, $_POST['nationality_id']),
			mysqli_real_escape_string($db, $_SESSION['id'])
			);
//SQL文実行
		mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');
//Jcropの画面に遷移させる
		// header('Location:crop');
		echo '<script> location.replace("crop"); </script>';
		exit();
//画像が選択されていない場合のアップロード処理
	}else{
		$sql = sprintf('UPDATE `users` SET `nick_name`="%s", `school_id`=%d, gender="%s",`introduction`="%s", `birthday`="%s", `nationality_id`=%d, modified = NOW() WHERE `id`=%d',
			mysqli_real_escape_string($db, $_POST['nick_name']), 
			mysqli_real_escape_string($db, $_POST['school_id']),
			mysqli_real_escape_string($db, $_POST['gender']),
			mysqli_real_escape_string($db, $_POST['introduction']),
			mysqli_real_escape_string($db, $_POST['birthday']),
			mysqli_real_escape_string($db, $_POST['nationality_id']),
			mysqli_real_escape_string($db, $_SESSION['id'])
			);
//SQL文実行
		mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');
//ユーザー情報詳細表示ページへ遷移
		//header('Location:/cebroad/users/show');
		echo '<script> location.replace("/portfolio/cebroad/users/show"); </script>';
		exit();
	}
}
//国籍情報取得
$sql = sprintf('SELECT * FROM `nationalities` WHERE `nationality_id`=%d', 
	mysqli_real_escape_string($db, $user['nationality_id'])
	);
$record = mysqli_query($db, $sql) or die ('<h1>Sorry, something wrong happened. please retry.</h1>');
$nationality_selected = mysqli_fetch_assoc($record); 
//全籍情報取得
$sql = sprintf('SELECT * FROM `nationalities` WHERE 1'
	);
$nationalities = mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. please retry.</h1>');
//学校情報取得
$sql = sprintf('SELECT * FROM `schools` WHERE `id`=%d', 
	mysqli_real_escape_string($db, $user['school_id'])
	);
$record = mysqli_query($db, $sql) or die ('<h1>Sorry, something wrong happened. please retry.</h1>');
$school_selected = mysqli_fetch_assoc($record);    
//全学校情報取得
$sql = sprintf('SELECT * FROM `schools` WHERE 1'
	);
$schools = mysqli_query($db, $sql) or die ('<h1>Sorry, something wrong happened. please retry.</h1>');
//ユーザー情報取得
$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d', 
	mysqli_real_escape_string($db, $_SESSION['id'])
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
										<td>Nick name:</td>
										<td><?php if(isset($user['nick_name'])): ?>
											<input type="text" name="nick_name" class="form-control" value="<?php echo h($user['nick_name']); ?>">
										<?php else: ?>
											<input type="text" name="nick_name" class="form-control" placeholder="例： Kon" value="" ?>
										<?php endif; ?>
										<?php if(isset($error['nick_name']) && $error['nick_name'] == 'blank'): ?>
											<p class="error">＊Please input your nickname</p>
										<?php endif; ?>
									</td> 
								</tr>
								  <tr>
								<!-- 性別 -->
									<td>Gender:</td>
									<td>
										<?php if(isset($user['gender'])): ?>
											<input type="radio" name="gender" value="1" <?php if($user['gender'] === '1') echo "checked" ?>><label for="male">male</label>
											<input type="radio" name="gender" value="2"<?php if($user['gender'] === '2') echo "checked" ?>><label for="female">female</label>
										<?php else: ?>
											<input type="radio" name="gender"><label value="1">male</label>
											<input type="radio" name="gender"><label value="2">female</label>
										<?php endif; ?>	
										<?php if(isset($error['gender']) && $error['gender'] == 'blank'): ?>
											<p class="error">＊Please choose your gender </p>
										<?php endif; ?>
									</td>
								  </tr>
								  <tr>
								<!-- 誕生日 -->
									<td>Birthday</td>
									<td>
										<?php if(isset($user['birthday'])): ?>
											<input type="date" name="birthday" class="form-control" min="1930-01-01" max="2010-12-31" value="<?php echo h($user['birthday']); ?>">
										<?php else: ?>
											<input type="date" name="birthday" class="form-control" min="1930-01-01" max="2010-12-31" value="" ?>
										<?php endif; ?>	
									</td>
								  </tr>
								  <tr>
								<!-- 国籍 -->
									<td>Nationality</td>
									<td>
										<select name="nationality_id" class="form-control">
											<?php while($nationality = mysqli_fetch_assoc($nationalities)): ?>
												<?php if($nationality_selected['nationality_id'] == $nationality['nationality_id']): ?>
													<option value="<?php echo $nationality['nationality_id'] ?>" selected><?php echo $nationality['nationality']; ?></option>
												<?php else: ?>
													<option value="<?php echo $nationality['nationality_id'] ?>"><?php echo $nationality['nationality']; ?></option>
												<?php endif; ?>
											<?php endwhile; ?>
										</select>				              
									</td>
								  </tr>
								<tr>
								<!-- 学校名 -->
									<td>School name</td>
									<td>
										<select name="school_id" id="school_id" class="form-control">
											<?php while($school = mysqli_fetch_assoc($schools)): ?>
												<?php if($school_selected['id']==$school['id']): ?>
													<option value="<?php echo $school['id']; ?>" selected><?php echo $school['name']; ?></option>
												<?php else: ?>
													<option value="<?php echo $school['id']; ?>"><?php echo $school['name']; ?></option>
												<?php endif; ?>
											<?php endwhile; ?>
										</select>
									</td>
								  </tr>
								  <tr>
								<!-- 自己紹介 -->
									<td>Self-introduction</td>
									<td>
										<?php if(isset($user['introduction'])): ?>
											<textarea type="text" name="introduction" class="form-control"><?php echo h($user['introduction']); ?></textarea>
										<?php else: ?>
											<textarea type="text" name="introduction" class="form-control" placeholder="例： Nice to meet you." value="" ?></textarea>
										<?php endif; ?>
									</td>
								  </tr>	
								  <tr>
								<!-- プロフィール写真 -->
									<td>Profile photo</td>
									<td>
					                  	<input type="file" name="profile_picture_path" id="profile_picture_path" style="display: none;">
					                  	<div class="input-group">
					                    	<input type="text" id="photoCover" class="form-control" placeholder="Select jpg or png(Maximum of 5MB)">
					                    	<span class="input-group-btn"><button type="button" class="btn btn-cebroad" onclick="$('#profile_picture_path').click();">Browse</button></span>
					                  	</div>
					                  		<label id="label" class="cebroad-pink"></label>
					                  	<div class="events-pad">
					                    	<img src="" id="preview" style="display:none; width: 300px;">
					                  	</div>
					                  	<?php if (isset($error['profile_picture_path']) && $error['profile_picture_path'] === 'type'): ?>
					                    	<p class="error">* You can choose「.jpg」「.png」file only.</p>
					                  	<?php endif; ?>
										<td>
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

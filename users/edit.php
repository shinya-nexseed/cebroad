<?php
//関数
  require('functions.php'); 

//ログイン判定
   //セッションにidが存在し、かつオンのtimeと3600秒足した値が現在時刻より小さい時に
   //現在時刻より小さい時にログインしていると判定する
   if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
    //$_SESSIONに保存している時間更新
    //これがないとログインから１時間たったら再度ログインしないとindex.phpに入れなくなる。
    $_SESSION['time'] = time();
	}
var_dump($_SESSION);

//エラーの設定
    $error = Array();
    //フォームからデータが送信された場合
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
	    //新しいパスワードと確認パスワードが一致していない場合エラー
	    if ($_POST['password_new'] !== $_POST['password_confirm']){
	        $error['contradiction'] = 'contradiction';
	    }

	    if ($_POST['gender'] == ''){
	        $error['gender'] = 'blank';
	    }

        $fileName = $_FILES['profile_picture_path']['name'];
       if (!empty($fileName)) {
          $ext = substr($fileName, -3);
          if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
            $error['profile_picture_path'] = 'type';
           }
       }

 		//エラーがなければ
	    if (empty($error)){
	        // //画像が選択されていれば
	        if(!empty($fileName)){
		        //画像のアップロード
		        $picture = date('YmdHis').$_FILES['profile_picture_path']['name'];
	        	move_uploaded_file($_FILES['profile_picture_path']['tmp_name'],'users/profile_pictures/'. $picture );
	        } else {
	         	$picture = $_SESSION['profile_picture_path'];
        	}

	        //アップロード処理
	        $sql = sprintf('UPDATE `users` SET `nick_name`="%s", `email`= "%s", `password`= "%s", `school_id`=%d, gender="%s", `profile_picture_path`="%s", `introduction`="%s", `birthday`="%s", `nationality_id`=%d, modified = NOW() WHERE `id`=%d',
	          mysqli_real_escape_string($db, $_POST['nick_name']), 
	          mysqli_real_escape_string($db, $_POST['email']),
	          mysqli_real_escape_string($db, sha1($_POST['password_new'])),
	          mysqli_real_escape_string($db, $_POST['school_id']),
	          mysqli_real_escape_string($db, $_POST['gender']),
	          mysqli_real_escape_string($db, $picture),
	          mysqli_real_escape_string($db, $_POST['introduction']),
	          mysqli_real_escape_string($db, $_POST['birthday']),
	          mysqli_real_escape_string($db, $_POST['nationality_id']),
	          mysqli_real_escape_string($db, $_SESSION['id'])
	        );

	    	mysqli_query($db, $sql) or die(mysqli_error($db));
	    	// header('Location:show');
	    }

	}

//ユーザー情報取得
  	$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
  		);
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $user = mysqli_fetch_assoc($record); 
    
    var_dump($user);

//国籍情報取得
    $sql = sprintf('SELECT * FROM `nationality` WHERE `nationality_id`=%d', mysqli_real_escape_string($db, $user['nationality_id'])
      );
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $nationality_selected = mysqli_fetch_assoc($record); 

//全籍情報取得
    $sql = sprintf('SELECT * FROM `nationality` WHERE 1'
    	);
    $nationalities = mysqli_query($db, $sql) or die(mysqli_error($db));

    
//学校情報取得
    $sql = sprintf('SELECT * FROM `schools` WHERE `id`=%d', mysqli_real_escape_string($db, $user['school_id'])
      );
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $school_selected = mysqli_fetch_assoc($record);    

//全学校情報取得
    $sql = sprintf('SELECT * FROM `schools` WHERE 1'
      );
    $schools = mysqli_query($db, $sql) or die (mysqli_error($db));


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="../webroot/assets/css/users_show.css" rel="stylesheet">
	<link href="../webroot/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
     <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >   
         	<div class="panel panel-info" id="panel-color">
            	<div class="panel-heading" id="panel-color">
              		<h3 class="panel-title"><?php echo h($user['nick_name']); ?></h3>
            	</div>
            	<form method="post" action="" role="form" enctype="multipart/form-data">
		            <div class="panel-body">
		              	<div class="row">
		                	<div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="profile_pictures/<?php echo h($user['profile_picture_path']); ?>" class="img-circle img-responsive"><br>
		                	<input type="file" name="profile_picture_path" class="form-control">
				                <?php if(isset($error['profile_picture_path']) && $error['profile_picture_path'] == 'type'): ?>
				                	<p class="error">＊プロフィール写真は「.gif」「.jpg」「.png」の画像を指定してください</p>
				                <?php endif; ?>
				                <?php if(!empty($error)): ?>
				                	<p class="error">＊画像を指定していた場合は、恐れ入りますが画像を改めて指定してください</p>
				                <?php endif; ?>
		                	</div>
			                <div class=" col-md-9 col-lg-9 "> 
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
									                <p class="error">＊ニックネームを入力してください</p>
									            <?php endif; ?>
									        </td> 
				                      </tr>
				                      <tr>
				                        <td>Email:</td>
				                        	<td><?php if(isset($user['email'])): ?>
									            <input type="email" name="email" class="form-control" value="<?php echo h($user['email']); ?>">
									            <?php else: ?>
									            <input type="email" name="email" class="form-control" placeholder="例： kon@gmail.com" value="" ?>
									            <?php endif; ?>
									            <?php if(isset($error['email']) && $error['email'] == 'blank'): ?>
	              									<p class="error">＊メールアドレスを入力してください</p>
	          									<?php endif; ?>
	          									<?php if(isset($error['email']) && $error['email'] == 'duplicate'): ?>
								                <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
								                <?php endif; ?>
									        </td> 
				                      </tr>
				                      <tr>
				                        <td>Current password:</td>
				                        	<td>
									            <input type="password" name="password" class="form-control" placeholder="" value="">
									            <?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
									            <p class="error">＊現在のパスワードを入力してください</p>
									            <?php endif; ?>
									            <?php if(isset($error['password']) && $error['password'] == 'length'): ?>
									            <p class="error">＊パスワードは4文字以上で入力してください </p>
									            <?php endif; ?>
									        </td> 
				                      </tr>
				                      <tr>
				                        <td>New password:</td>
				                        	<td>
									            <?php if(isset($_POST['password_new'])): ?>
									            	<input type="password" name="password_new" class="form-control" placeholder="" value="">
									            <?php else: ?>
									                <input type="password" name="password_new" class="form-control" placeholder="" value="">
									            <?php endif; ?>
									            <?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
									                <p class="error">＊新しいパスワードを入力してください</p>
									            <?php endif; ?>
									            <?php if(isset($error['password']) && $error['password'] == 'length'): ?>
									                <p class="error">＊パスワードは4文字以上で入力してください </p>
									            <?php endif; ?>				                        	
									        </td> 
				                      </tr>
				                      <tr>
				                        <td>Confirm new password:</td>
				                        	<td>
									            <?php if(isset($_POST['password_confirm'])): ?>
									                <input type="password" name="password_confirm" class="form-control" placeholder="" value="">
									            <?php else: ?> 
									                <input type="password" name="password_confirm" class="form-control" placeholder="" value="">
									            <?php endif; ?>
									            <?php if(isset($error['password']) && $error['password'] == 'blank'): ?>
									                <p class="error">＊新しいパスワードをもう一度入力して下さい。</p>
									            <?php endif; ?>
									            <?php if(isset($error['password']) && $error['password'] == 'length'): ?>
									                <p class="error">＊パスワードは4文字以上で入力してください </p>
									            <?php endif; ?>
									            <?php if(isset($error['contradiction']) == 'contradiction'): ?>
									                <p class="error">＊確認パスワードが一致しません。</p>
									            <?php endif; ?>				                        
									        </td> 
				                      </tr>
				                      <tr>
				                        <td>Gender:</td>
				                        	<td>
				                        		<?php if(isset($user['gender'])): ?>
									              <input type="radio" name="gender" value="male" <?php if($user['gender']== "male") echo "checked" ?>><label for="male">male</label>
												  <input type="radio" name="gender" value="female"<?php if($user['gender']== "female") echo "checked" ?>><label for="female">female</label>
									              <?php else: ?>
												  <input type="radio" name="gender"><label value="male">male</label>
												  <input type="radio" name="gender"><label value="female">female</label>
												<?php endif; ?>	
									            <?php if(isset($error['gender']) && $error['gender'] == 'blank'): ?>
									                <p class="error">＊性別を入力してください</p>
									            <?php endif; ?>
				                        	</td>

				                      </tr>
				                      <tr>
				                        <td>Birthday</td>
					                        <td>
					                        	<?php if(isset($user['birthday'])): ?>
										              <input type="text" name="birthday" class="form-control" value="<?php echo h($user['birthday']); ?>">
										              <?php else: ?>
										              <input type="text" name="birthday" class="form-control" placeholder="例： 1986/09/01" value="" ?>
										        <?php endif; ?>	
					                        </td>
				                      </tr>
				                      <tr>
				                        <td>Nationality</td>
					                        <td>
					                        	<select name="nationality_id">
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
				                        <td>School name</td>
					                        <td>
												<select name="school_id" id="school_id">
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
				                        <td>Self-introduction</td>
					                        <td>
					                        	<?php if(isset($user['introduction'])): ?>
									              	<input type="text" name="introduction" class="form-control" value="<?php echo h($user['introduction']); ?>">
									              <?php else: ?>
									              	<input type="text" name="introduction" class="form-control" placeholder="例： Nice to meet you." value="" ?>
									            <?php endif; ?>
					                        </td>
				                      </tr>
				                    </tbody>
			                  	</table>			                 
			                </div>
		            	</div>
	           		</div>
		            <div class="panel-footer">
	                    <!-- <a data-original-title="Broadcast Message" data-toggle="tooltip" type="submit" class="btn btn-sm btn-warning" href="">保存</a> -->
	                    <input type="submit" class="btn btn-default"  value="保存">
		            </div> 
	            </form>           
        	</div>
    	</div>
	</div>
</div> 


</body>
</html>
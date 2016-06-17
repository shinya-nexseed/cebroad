<?php
//関数
  require('functions.php'); 

// ログイン判定
//    セッションにidが存在し、かつオンのtimeと3600秒足した値が現在時刻より小さい時に
//    現在時刻より小さい時にログインしていると判定する
//    if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
//     //$_SESSIONに保存している時間更新
//     //これがないとログインから１時間たったら再度ログインしないとindex.phpに入れなくなる。
//     $_SESSION['time'] = time();
// 	}

//ユーザー情報取得
  	$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
  		);
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $user = mysqli_fetch_assoc($record); 

//フォームからデータが送信された場合
    $error = Array();
    if(!empty($_POST)){
	    //エラー項目の確認
	    if($_POST['nick_name'] == ''){
	    	$error['nick_name'] = 'blank';
	    }

	    if ($_POST['gender'] == ''){
        $error['gender'] = 'blank';
    	}
	}

//画像ファイルが送信された場合
	if(!empty($_FILES)){
		$fileName = $_FILES['profile_picture_path']['name'];
	    if (!empty($fileName)) {
	      $ext = substr($fileName, -3);
	      if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
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
	        move_uploaded_file($_FILES['profile_picture_path']['tmp_name'],'./users/profile_pictures/'.$picture);
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
			mysqli_query($db, $sql) or die(mysqli_error($db));
			//Jcropの画面に遷移させる
			header('Location:crop');
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
			mysqli_query($db, $sql) or die(mysqli_error($db));
			//ユーザー情報詳細表示ページへ遷移
			header('Location:show');
		}
	}

//国籍情報取得
    $sql = sprintf('SELECT * FROM `nationality` WHERE `nationality_id`=%d', 
    	mysqli_real_escape_string($db, $user['nationality_id'])
      );
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $nationality_selected = mysqli_fetch_assoc($record); 

//全籍情報取得
    $sql = sprintf('SELECT * FROM `nationality` WHERE 1'
    	);
    $nationalities = mysqli_query($db, $sql) or die(mysqli_error($db));

    
//学校情報取得
    $sql = sprintf('SELECT * FROM `schools` WHERE `id`=%d', 
    	mysqli_real_escape_string($db, $user['school_id'])
      );
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $school_selected = mysqli_fetch_assoc($record);    

//全学校情報取得
    $sql = sprintf('SELECT * FROM `schools` WHERE 1'
      );
    $schools = mysqli_query($db, $sql) or die (mysqli_error($db));

//hのショートカット
    function h($value){
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

//ユーザー情報取得
  	$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d', 
  		mysqli_real_escape_string($db, $_SESSION['id'])
  		);
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
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
	              			<img alt="User Pic" src="profile_pictures/<?php echo h($user['profile_picture_path']); ?>" class="img-responsive"><br>	              			    
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
								                <p class="error">＊ニックネームを入力してください</p>
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
								            	<textarea type="text" name="introduction" class="form-control"><?php echo h($user['introduction']); ?></textarea>
								            <?php else: ?>
								              	<textarea type="text" name="introduction" class="form-control" placeholder="例： Nice to meet you." value="" ?></textarea>
								            <?php endif; ?>
				                        </td>
			                      　</tr>	
			                     　 <tr>
				                      	<td>Profile photo</td>
				                      	<td>
				                      		<input type="file" name="profile_picture_path" class="from-control">
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

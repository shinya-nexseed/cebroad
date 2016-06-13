<?php
//関数
  require('functions.php'); 

//ログイン判定
   //セッションにidが存在し、かつオンのtimeと3600秒足した値が現在時刻より小さい時に
   //現在時刻より小さい時にログインしていると判定する
 //   if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
 //    //$_SESSIONに保存している時間更新
 //    //これがないとログインから１時間たったら再度ログインしないとindex.phpに入れなくなる。
 //    $_SESSION['time'] = time();
	// }

//ユーザー情報取得
  	$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
  		);
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $user = mysqli_fetch_assoc($record); 
    

//フォームからデータが送信された場合
    $error = Array();
    if(!empty($_POST)){
	    //エラー項目の確認

	    if($_POST['password'] == ''){
	        $error['password'] = 'blank';
	    }

	    if($_POST['password_new'] == ''){
	        $error['password'] = 'blank';
	    }

	    if(sha1($_POST['password']) !== $user['password']){
        $error['password'] = 'incorrect'; 
    	} 
	}

// var_dump($_POST);
// var_dump($user);
// // var_dump(sha1($_POST['password']));
	

//エラーがなければ
	if (!empty($_POST) && empty($error)){
	    // //画像が選択されていれば
	    if(!empty($fileName)){
	        //画像のアップロード
	        $picture = date('YmdHis').$_FILES['profile_picture_path']['name'];
	    	move_uploaded_file($_FILES['profile_picture_path']['tmp_name'],'users/profile_pictures/'. $picture );
	    } else {
	     	$picture = $user['profile_picture_path'];
		}

	    //アップロード処理
	    $sql = sprintf('UPDATE `users` SET `password`= "%s", modified = NOW() WHERE `id`=%d',
	      mysqli_real_escape_string($db, sha1($_POST['password_new'])),
	      mysqli_real_escape_string($db, $_SESSION['id'])
	    );

		mysqli_query($db, $sql) or die(mysqli_error($db));
		// header('Location:show');
	}


//hのショートカット
    function h($value){
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

//ユーザー情報取得
  	$sql = sprintf('SELECT * FROM `users` WHERE `id`=%d', mysqli_real_escape_string($db, $_SESSION['id'])
  		);
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $user = mysqli_fetch_assoc($record); 

// var_dump($user);

?>


<script type="text/javascript">
  function checkForm(){
    if(form.password_new.value != "" && form.password_new.value == form.password_confirm.value) {
      if(form.password_new.value.length < 4) {
        alert("Error: Password must contain at least four characters");
        form.password_new.focus();
        return false;
      }

      if(form.password_new.value.length > 20) {
        alert("Error: Password must be less than twenty characters");
        form.password_new.focus();
        return false;
      }

      re = /[0-9]/;
      if(!re.test(form.password_new.value)) {
        alert("Error: password must contain at least one number (0-9)");
        form.password_new.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.password_new.value)) {
        alert("Error: password must contain at least one lowercase letter (a-z)");
        form.password_new.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.password_new.value)) {
        alert("Error: password must contain at least one uppercase letter (A-Z)");
        form.password_new.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password");
      form.password_new.focus();
      return false;
    }

    alert("You entered a valid password: " + form.password_new.value);
    return true;
  }
</script>
<div class="container-fluid">
     <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-3 col-md-offset-3 col-lg-offset-3 toppad" >   
         	<!-- <div class="panel panel-info" id="panel-color"> -->
            	<!-- <div class="panel-heading" id="panel-color"> -->
              		<!-- <h3 class="panel-title"><?php //echo h($user['nick_name']); ?></h3> -->
            	<!-- </div> -->
            	<form name="form" method="post" onsubmit="return checkForm();" role="form" enctype="multipart/form-data" >
		            <div class="panel-body">
		              	<div class="row">
		              		<div class=" col-md-3 col-lg-3" align="center"> 
		              			<img alt="User Pic" src="profile_pictures/<?php echo h($user['profile_picture_path']); ?>" class="img-circle img-responsive"><br>
		              			<div class="list-group">
									<a class="list-group-item" href="edit">Basic info.</a>
									<a class="list-group-item" href="edit_password">Password</a>
									<a class="list-group-item" href="edit_email">Email</a>
								</div>
		              		</div>
			                <div class="col-sm-6 col-md-9 col-lg-9"> 
			                  	<table class="table table-user-information">
				                    <tbody>
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
			                      			<input type="submit" class="btn btn-mini" value="update" align="">
			                      		</td>
			                          </tr>
				                    </tbody>
			                  	</table>			                 
			                </div>
		            	</div>
	           		</div>
    	</div>
	</div>
</div> 
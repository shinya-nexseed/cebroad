<?php
// //データベース接続
//   require('dbconnect.php');
// //関数
//   require('functions.php'); 


// //セッションを使うページに必ず入れる
//   session_start();

// //ログイン判定
//    //セッションにidが存在し、かつオンのtimeと3600秒足した値が現在時刻より小さい時に
//    //現在時刻より小さい時にログインしていると判定する
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
    
    // var_dump($user);

//国籍情報取得
    $sql = sprintf('SELECT * FROM `nationality` WHERE `nationality_id`=%d', mysqli_real_escape_string($db, $user['nationality_id'])
      );
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $nationality = mysqli_fetch_assoc($record); 
    
    // var_dump($nationality);

 //学校情報取得
    $sql = sprintf('SELECT * FROM `schools` WHERE `id`=%d', mysqli_real_escape_string($db, $user['school_id'])
      );
    $record = mysqli_query($db, $sql) or die (mysqli_error($db));
    $school = mysqli_fetch_assoc($record); 
    
// var_dump($school);
function h($value){
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }


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
	            <div class="panel-body">
	              	<div class="row">
	                	<div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="profile_pictures/<?php echo h($user['profile_picture_path']); ?>" class="img-responsive"> </div>
		                <div class=" col-md-9 col-lg-9 "> 
		                  	<table class="table table-user-information">
			                    <tbody>
			                      <tr>
			                        <td>Nick name:</td>
			                        	<td><?php echo h($user['nick_name']); ?></td> 
			                      </tr>
			                      <tr>
			                        <td>Gender:</td>
			                        	<td><?php echo h($user['gender']); ?></td>	 
			                      </tr>
			                      <tr>
			                        <td>Birthday</td>
			                        <td><?php echo h($user['birthday']); ?></td>
			                      </tr>
			                      <tr>
			                        <td>Nationality</td>
			                        <td><?php echo h($nationality['nationality']); ?></td>
			                      </tr>
			                        <tr>
			                        <td>School name</td>
			                        <td><?php echo h($school['name']); ?></td>
			                      </tr>
			                      <tr>
			                        <td>Self-introduction</td>
			                        <td><?php echo h($user['introduction']); ?></td>
			                      </tr>
			                    </tbody>
		                  	</table>	
		                  	</form>		                 
		                </div>
	            	</div>
           		</div>
	            <div class="panel-footer">
                    <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning" href="edit"><i class="glyphicon glyphicon-edit"></i></a>
	            </div>            
        	</div>
    	</div>
	</div>
</div> 
</body>
</html>


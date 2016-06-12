<?php 
header("Content-type: text/html; charset=utf-8");
 
//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];
 
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
 
?>
<link rel="stylesheet" href="../webroot/assets/css/bootstrap.min.css">

 
<form action="/cebroad/join/regist_fin" method="post">
 
<!--メールアドレス-->
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-md-8 col-sm-offset-2 col-md-offset-2">
				<h1>email registration screen</h1>
                        <div class="form-group">
                        <?php if (isset($_POST['email'])): ?>
                          <input type ="email" name="mail" id="email" tabindex="1" class="form-control" value="<?php echo h($_POST['email']); ?>">
                        <?php else: ?>
                          <input type="email" name="mail" id="email" tabindex="1" class="form-control" value="">
                        <?php endif; ?>
                        <!-- メールアドレスが空欄だったら -->
                        <?php if(isset($error['email']) && $error['email'] === 'blank'): ?>
                          <p class="error">* Please type your Email Address.</p>
                        <?php endif; ?>
                        <!--すでにメールアドレスが存在していたら-->  
                        <?php if (isset($error['email']) && $error['email'] === 'duplicate'): ?>
                          <p class="error">* This Email Address already exists.</p>
                        <?php endif; ?>
                      </div>
            </div>
 
						<input type="hidden" name="token" value="<?=$token?>">
			<div class="col-sm-1 col-md-1 col-sm-offset-2 col-md-offset-2">
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Confirm">
						</div>
			</div>
		</div>
	</div>
 
</form>
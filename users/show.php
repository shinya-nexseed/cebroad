<?php 
	$sql = 'SELECT * FROM `users` WHERE `id`=' . $_SESSION['id'];
	$record = mysqli_query($db, $sql);

	if($user = mysqli_fetch_assoc($record)) {
		$filepath = './profile_pictures/' . $user['profile_picture_path'];
	} 
 ?>

 <img src="<?php echo $filepath; ?>">
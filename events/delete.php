<?php

//投稿を検査する
$sql = sprintf('SELECT * FROM `comments` WHERE id=%d',
  mysqli_real_escape_string($db, $id)
  );
$record = mysqli_query($db, $sql) or die (mysqli_error($db));
$table = mysqli_fetch_assoc($record); 

if ($table['user_id'] == $_SESSION['id']){
//削除
  $sql = sprintf ('UPDATE `comments` SET `delete_flag`=1 WHERE id=%d', 
    mysqli_real_escape_string($db,$id)
    ); 
  mysqli_query($db, $sql) or die(mysqli_error($db)); 
}

// header('Location: /cebroad/events/show/');
exit();

?>
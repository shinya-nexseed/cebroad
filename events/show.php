<?php 

//アクション名の後に$id(routs.php参照)が存在する場合に
if(!empty($id)){
//対象$idのイベントデータを取得（$idが2ならイベント2のidを取得）
  $sql=sprintf('SELECT * FROM `events` JOIN `event_categories` ON events.event_category_id=event_categories.id WHERE events.id='.$id);
  $record=mysqli_query($db, $sql)or die(mysqli_error($db));
  $event=mysqli_fetch_assoc($record);


//対象$idのイベントのオーガナイザー情報を取得
  $sql=sprintf('SELECT * FROM `users` WHERE `id`='.$event['organizer_id']);
  $record=mysqli_query($db, $sql)or die(mysqli_error($db));
  $organizer=mysqli_fetch_assoc($record);


//参加者情報を取得（usersのidと中間テーブルのuser_idを結合し、中間テーブルのevent_idが$idと一緒の時$event_participantsにusers情報を格納）
  $sql=sprintf('SELECT * FROM `users` JOIN `participants` ON `id`=participants.user_id WHERE participants.event_id='.$id);
  $record=mysqli_query($db, $sql)or die(mysqli_error($db));
  $event_participants=array();
  while($result=mysqli_fetch_assoc($record)){
    $event_participants[]=$result;
  }

//コメント情報を取得（commentsのuser_idとusersのidを結合し、commentsテーブルのevent_idが$idと一緒の時$commentsにcomments情報を格納）
  $sql=sprintf('SELECT * FROM `comments` JOIN `users` ON comments.user_id=users.person_id WHERE event_id='.$id.' ORDER BY comments.created DESC');
  $record=mysqli_query($db, $sql)or die(mysqli_error($db));
  $comments=array();
  while($result=mysqli_fetch_assoc($record)){
    $comments[]=$result;
  }

 var_dump($comments);

//対象$idイベンのlike数を取得
  $sql = sprintf('SELECT COUNT(*) AS cnt FROM likes WHERE event_id=%d',
    $id
    );

  $record = mysqli_query($db, $sql) or die(mysqli_error($db));
  $cnt_like = mysqli_fetch_assoc($record);


//対象$idイベントの参加ボタンが押された数をチェック
  $sql = sprintf('SELECT COUNT(*) AS cnt FROM participants WHERE event_id=%d',
    $id
    );
  $record = mysqli_query($db, $sql) or die(mysqli_error($db));
  $cnt_paticipant = mysqli_fetch_assoc($record);


//すでにLikeされているかどうかを判定(Likeボタン中間テーブルのON/OFF、ボタンの色の切り替え用)
  $sql = sprintf('SELECT COUNT(*) AS cnt FROM likes WHERE user_id=%d AND event_id=%d',
    $_SESSION['id'],
    $id
    );
  $record = mysqli_query($db, $sql) or die(mysqli_error($db));
  $table_like = mysqli_fetch_assoc($record);


//すでに参加ボタンを押しているかどうかを判定(参加ボタンのON/OFF中間テーブルのON/OFF、ボタンの色の切り替え用)
  $sql = sprintf('SELECT COUNT(*) AS cnt FROM participants WHERE user_id=%d AND event_id=%d',
    $_SESSION['id'],
    $id
    );

  $record = mysqli_query($db, $sql) or die(mysqli_error($db));
  $table_paticipant = mysqli_fetch_assoc($record);


//いいねデータ更新
  if(isset($_POST['like'])){
if($table_like['cnt']>0){//‚·‚Å‚Éƒf[ƒ^‚ª‘¶Ý‚µ‚Ä‚¢‚éê‡
  $sql_like = sprintf('DELETE FROM `likes` WHERE user_id=%d AND event_id=%d',
    $_SESSION['id'],
    $id
    );

  $record=mysqli_query($db, $sql_like)or die(mysqli_error($db));
}
else{//データが存在しない場合
  $sql_like=sprintf('INSERT INTO `likes`(`user_id`, `event_id`) VALUES('.$_SESSION['id'].','.$id.')');
  $record=mysqli_query($db, $sql_like)or die(mysqli_error($db));
}

$sql = sprintf('SELECT COUNT(*) AS cnt FROM likes WHERE user_id=%d AND event_id=%d',
  $_SESSION['id'],
  $id
  );
$record = mysqli_query($db, $sql) or die(mysqli_error($db));
$table_like = mysqli_fetch_assoc($record);
header('Location: /cebroad/'.$resource.'/'.$action.'/'.$id);

}
else if(isset($_POST['paticipant'])){

if($table_paticipant['cnt']>0){//すでにデータが存在している場合
  $sql = sprintf('DELETE FROM `participants` WHERE user_id=%d AND event_id=%d',
    $_SESSION['id'],
    $id
    );
  $record=mysqli_query($db, $sql)or die(mysqli_error($db));


}
else{//データが存在しない場合
  $sql=sprintf('INSERT INTO `participants`(`user_id`, `event_id`) VALUES('.$_SESSION['id'].','.$id.')');
  $record=mysqli_query($db, $sql)or die(mysqli_error($db));
}

$sql = sprintf('SELECT COUNT(*) AS cnt FROM participants WHERE user_id=%d AND event_id=%d',
  $_SESSION['id'],
  $id
  );


$record = mysqli_query($db, $sql) or die(mysqli_error($db));
$table_paticipant = mysqli_fetch_assoc($record);

header('Location: /cebroad/'.$resource.'/'.$action.'/'.$id);
}

//commentが送信された場合
if(isset($_POST['comment'])){
//コメントを保存
  $sql = sprintf('INSERT INTO `comments`(`event_id`, `user_id`, `comment`, `delete_flag`, `created`) VALUES (%d,%d,"%s",0,now())',
    $id,
    $_SESSION['id'],
    $_POST['comment']
    );
  $record = mysqli_query($db, $sql) or die(mysqli_error($db));
}

// if(isset($_POST['comment_delete'])){
// //コメントを保存
//   $sql = sprintf('DELETE FROM `comments` WHERE `id`='.$_POST['comment_delete']);
//   $record = mysqli_query($db, $sql) or die(mysqli_error($db));
//   echo $sql;
// }



if ( !function_exists('mime_content_type') ) {
  function mime_content_type($filename) {
    $mime_type = exec('file -Ib '.$filename);
    return $mime_type;
  }
}
}
 ?>

<!-- content -->                   
<div class="row" id="main">
  <!-- イベントメイン写真 -->
  <div class="col-sm-10">
    <div class="panel panel-default">
      <!-- <div class="panel-thumbnail"> -->
      <img src="/cebroad/webroot/assets/images/sand.jpg" class="img-responsive" height="600">
      <!-- </div> -->
      <div class="panel-body">
        <p class="lead"><?php echo $event['event_name']; ?></p>
        <h4><i class="fa fa-users" aria-hidden="true"></i><?php echo $cnt_paticipant['cnt']?>  <i class="fa fa-thumbs-o-up" aria-hidden="true"></i><?php echo $cnt_like['cnt']?></h4>
        <p><img src="/cebroad/images/<? echo $organizer['profile_picture_path'];?>" class="img-circle pull-left"></p>
        <!-- いいねボタン -->
        <form method="post" action="" class="navbar-right">
          <input type="hidden" name="like" value="1">
          <?php if($table_like['cnt']>0){ ?>
          <i class="fa fa-thumbs-o-up" aria-hidden="true"></i><input type="submit" class="btn btn-default" value="Cansel">
          <?php }else { ?>
          <i class="fa fa-thumbs-o-up" aria-hidden="true"></i><input type="submit" class="btn btn-success" value="Like">
          <?php } ?>
        </form>
        <!-- 参加者ボタン - ログインしているユーザーでないとき参加者ボタンを表示 -->
        <?php if($_SESSION['id']!=$event['organizer_id']){ ?>
        <form method="post" action="" class="navbar-right">
          <input type="hidden" name="paticipant" value="1">
          <!-- 1度でも押したことがある場合はキャンセルできるようにボタンの色を変更 -->
          <?php if($table_paticipant['cnt']>0){ ?>
          <i class="fa fa-users" aria-hidden="true"></i><input type="submit" class="btn btn-default" value="Cansel">  
          <?php }else { ?>
          <!-- 押したことがなく、定員に達している場合はボタンは非アクティブ状態 -->
          <?php if($cnt_paticipant['cnt']<$event['capacity_nim']){?> 
          <i class="fa fa-users" aria-hidden="true"></i><input type="submit" class="btn btn-success" value="Join">
          <!-- 押したことがなく、定員に達していない場合はボタンはアクティブ状態 -->
          <?php }else { ?>
          <i class="fa fa-users" aria-hidden="true"></i><input type="submit" class="btn btn-success" disabled="disabled" value="Join">
          <?php } ?>
          <?php } ?>
          <?php } else{?>
          <!-- ログインしているユーザーのときは参加者ボタンを非アクティブ状態 -->
          <div class="navbar-right">
            <i class="fa fa-users" aria-hidden="true"></i><input type="submit" class="btn btn-success" disabled="disabled" value="Join">
          </div>
          <?php } ?>
        </form>
      </div>
    </div>
  </div>

  <!-- </div> -->
  <!-- main col left -->
  <!-- <div calss="row"> -->
  <div class="col-sm-3 col-sm-push-7">

    <div class="panel panel-default">
      <!-- <div class="panel-thumbnail"></div> -->
      <div class="panel-body">
        <p class="lead">Date/Place</p>
        <p>Date:<?php echo $event['date']; ?></p>
        <p>Place:<?php echo $event['place_name']; ?></p>
        <p>
          <img src="/cebroad/images/<? echo $organizer['profile_picture_path'];?>" class="img-circle pull-left">
        </p>
      </div>
    </div>


    <div class="panel panel-default">
      <!-- <div class="panel-heading"><a href="#" class="pull-right"></a> <h4>Bootstrap Examples</h4></div> -->
      <div class="panel-body">
        <p class="lead">Paticipants</p>
        <div class="list-group">
          <?php foreach($event_participants as $event_participant){ ?>
          <img src="/cebroad/images/<? echo $event_participant['profile_picture_path'];?>" class="img-circle pull-left">
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <!-- main col right -->
  <div class="col-sm-7 col-sm-pull-3" >
    <div class="panel-detail">
      <div class="panel panel-default">
        <div class="panel-heading"><a href="#" class="pull-right">View all</a> <h4>Event details</h4></div>
        <div class="panel-body">
          <p><img src="/cebroad/webroot/assets/images/photo1.jpg" class="img-circle pull-right"> <?php echo $event['detail']; ?></p>
          <div class="clearfix"></div>
          <hr>Event category: <?php echo $event['name']; ?>
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading"><h4>Comments</h4></div>
      <div class="panel-body">
        <div class="clearfix">
          <br>
          <form method="post">
            <input type="text" name="comment" class="form-control" placeholder="Add a comment..">
            <input type="submit" class="btn btn-default pull-right" value="Post">
          </form>
        </div>
        <?php foreach($comments as $comment){ ?>
        <!-- <img src=/cebroad/images/<? //echo $comment['profile_picture_path'];?> class="img-circle pull-left comment"> -->
        <img src="/cebroad/images/<? echo $coment['profile_picture_path'];?>" class="img-circle pull-left">
          <div class="comment">
            <h5><?php echo $comment['nick_name']; ?></h5>
            <p><?php echo $comment['comment']; ?></p>
            <p><?php echo $comment['created'];?></p>
<!--             <form class="comment" name="delete" method="post" action="">
              <input type="hidden" name="comment_delete" value="<?php //echo $comment['id']; ?>">
              <a class="delete" href="javascript.delete.submit()"><i class="fa fa-trash" aria-hidden="true"></i></a>
            </form> -->
            <!-- セッションIDとコメントのIDが一致した時にだけ削除ボタンを表示  -->
            <?php if ($_SESSION['id']== $comment['user_id']):?>
            <a href="/cebroad/events/delete/<?php echo $comment['id'];?>" style="color: #F33;">Delete</a>
            <?php endif;?>
            <hr>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div><!-- /row -->
<!-- </div>/col-9 -->
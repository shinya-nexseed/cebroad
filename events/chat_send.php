<?php
    session_start();
    // このファイルのみ独立しているので、DBやセッションなどは個別で読み込む必要あり
    $db = mysqli_connect('localhost', 'root', 'mysql', 'cebroad') or die(mysqli_connect_error());
    mysqli_set_charset($db, 'utf8');
    // production
    // $db = mysqli_connect('mysql465.db.sakura.ne.jp', 'nexseed', 'nexseedwebsite129', 'nexseed_cebroad') or die(mysqli_connect_error());
    // mysqli_set_charset($db, 'utf8');

    if (isset($_POST['message_val'])) {
        $sql = sprintf('INSERT INTO message SET message="%s", sender_id=1, room_id=%d, created=NOW()',
            $_POST['message_val'],
            $_POST['room_id']
        );
        mysqli_query($db, $sql) or die(mysqli_error($db));
    }
    
    //対象のルームのIDからメッセージを一覧化する
    $messages = array();
    $sql='SELECT r.*, m.* FROM `message` m, `rooms` r WHERE m.room_id=r.id AND room_id=' . $_POST['room_id'];
    $records = mysqli_query($db, $sql) or die(mysqli_error($db));
    
    while($result=mysqli_fetch_assoc($records)){
      //実行結果として得られたデータを取得
      $messages[]=$result;
    }

    // $data = array(
    //       'id' => $messages[0]['id'],
    //       'message' => $messages[0]['message'],
    //   );

    // $data = array();
    // $data = '';
    // for ($i=0; $i < count($messages); $i++) { 
      // $data[$i] = $messages[$i];
      // $data[$i] = array(
      //       $i => $messages[$i]
      //   );
    // }

    $data = $messages;


    header("Content-type: text/plain; charset=UTF-8");
    //ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）

    echo json_encode($data);


?>

<?php
    require('../dbconnect.php');

    //クリックされたときの対象IDのroomのデータを表示する
    // $sql=sprintf('SELECT * FROM `rooms` WHERE organizer_id=%d AND participant_id=%d AND event_id=%d',
    //   mysqli_real_escape_string($db, $_POST['organizer_id']),
    //   mysqli_real_escape_string($db, $_POST['participant_id']),
    //   mysqli_real_escape_string($db, $id)
    //   );

    // $records = mysqli_query($db, $sql) or die(mysqli_error($db));
    // $room = mysqli_fetch_assoc($records);
    
    //対象のルームのIDからメッセージを一覧化する
    $messages = array();
    $sql='SELECT * FROM `message` WHERE room_id=' . $_POST['room_id'];
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

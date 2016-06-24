<?php 

// クリックされたときの対象IDのroomのデータを表示する
    // $sql=sprintf('SELECT * FROM `rooms` WHERE organizer_id=%d AND participant_id=%d AND event_id=%d',
    //   mysqli_real_escape_string($db, $_POST['organizer_id']),
    //   mysqli_real_escape_string($db, $_POST['participant_id']),
    //   mysqli_real_escape_string($db, $id)
    //   );

    // $records = mysqli_query($db, $sql) or die(mysqli_error($db));
    // $room = mysqli_fetch_assoc($records);

     //対象イベントがオーガナイザーかどうかを判定するために$id(events/showのID)からeventのデータを取得
      $sql=sprintf('SELECT * FROM `events` WHERE events.id='.$id);
      $record=mysqli_query($db, $sql)or die(mysqli_error($db));
      $event=mysqli_fetch_assoc($record);
// var_dump($_SESSION);
// var_dump($event);

      if($event['organizer_id']!=$_SESSION['id']){//対象のイベントがオーガナイザーでない場合
        //対象のroomが存在するかを確認
        $sql = sprintf('SELECT COUNT(id) AS cnt FROM `rooms` WHERE organizer_id=%d AND participant_id=%d AND event_id=%d',
          mysqli_real_escape_string($db, $event['organizer_id']),
          mysqli_real_escape_string($db, $_SESSION['id']),
          mysqli_real_escape_string($db, $id)
          );

        $records = mysqli_query($db, $sql) or die(mysqli_error($db));
        $messages = array();
        $cnt = mysqli_fetch_assoc($records);

// var_dump($cnt);
// echo "hoge";

        //対象のIDが存在しない場合
          if($cnt['cnt']<1){
            $sql=sprintf('INSERT INTO `rooms`(`event_id`,`organizer_id`, `participant_id`)
              VALUES(%d, %d, %d)',
              mysqli_real_escape_string($db, $id),
              mysqli_real_escape_string($db, $event['organizer_id']),
              mysqli_real_escape_string($db, $_SESSION['id'])
              );
            $records = mysqli_query($db, $sql) or die(mysqli_error($db));
          }

// var_dump($records);

          //対象のルームの一覧化
          $sql=sprintf('SELECT rooms.*, events.title, a_users.nick_name AS organizer_name, b_users.nick_name AS participant_name, a_users.profile_picture_path AS a_users_picture, b_users.profile_picture_path AS b_users_picture FROM `rooms`
            LEFT JOIN `events` ON rooms.event_id=events.id
            LEFT JOIN `users` AS a_users ON rooms.organizer_id=a_users.id
            LEFT JOIN `users` AS b_users ON rooms.participant_id=b_users.id
            WHERE rooms.organizer_id=%d AND participant_id=%d AND event_id=%d',
            mysqli_real_escape_string($db, $event['organizer_id']),
            mysqli_real_escape_string($db, $_SESSION['id']),
            mysqli_real_escape_string($db, $id)
            );

          $records = mysqli_query($db, $sql) or die(mysqli_error($db));
          $room = mysqli_fetch_assoc($records);
// echo "どるroom バーダンプ";
// var_dump($room);

      }else{//ログインユーザーとオーガナイザーが一致する場合
            //対象のルームの一覧化
            $sql=sprintf('SELECT rooms.*, events.title ,a_users.nick_name AS organizer_name, b_users.nick_name AS participant_name, a_users.profile_picture_path AS a_users_picture, b_users.profile_picture_path AS b_users_picture FROM `rooms`
            LEFT JOIN `events` ON rooms.event_id=events.id
            LEFT JOIN `users` AS a_users ON rooms.organizer_id=a_users.id
            LEFT JOIN `users` AS b_users ON rooms.participant_id=b_users.id
            WHERE rooms.organizer_id=%d AND event_id=%d',
              mysqli_real_escape_string($db, $_SESSION['id']),
              mysqli_real_escape_string($db, $id)
              );

            $records = mysqli_query($db, $sql) or die(mysqli_error($db));
            $rooms = Array();

            while($result=mysqli_fetch_assoc($records)){
                //実行結果として得られたデータを取得
                $rooms[]=$result;
              }
      }

// var_dump($_POST);



 ?>


<script type="text/javascript">
    var user_id = <?php echo $_SESSION['id'];?>;
    // var str = 'user_id = ' + user_id;
    // console.log(str);
</script>

<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
 <script>
 $(document).ready(function()
 {
     /**
      * 送信ボタンクリック
      */
     $('a').click(function()
     {
         //POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
         var id = $(this).attr('id');
         console.log(id);
         // jsを使ってセッションにroom_idを保持  insert時に使用
         window.sessionStorage.setItem(['room_id'],[id]);
         var room_id = window.sessionStorage.getItem(['room_id']);
         console.log(room_id);
         var data = {room_id : room_id};
         // var user_id = <?= $_SESSION['id'];?>;
         /**
          * Ajax通信メソッド
          * @param type  : HTTP通信の種類
          * @param url   : リクエスト送信先のURL
          * @param data  : サーバに送信する値
          */
         $.ajax({
             type: "POST",
             url: "/cebroad/events/chat_send.php",
             data: data,
             /**
              * Ajax通信が成功した場合に呼び出されるメソッド
              */
             success: function(data, dataType)
             {
                 //successのブロック内は、Ajax通信が成功した場合に呼び出される
                 // jsonデータをjsの配列データに変換してvar dataに代入
                 var data = JSON.parse(data);
                 
                 //PHPから返ってきたデータの表示
                 console.log(data);
                 // console.log(data[0]['message']);
                 // var element1 = document.getElementById('chat_message');
                 // // console.log(element);
                 // var element2 = document.getElementById('chat_message_right');
                 var element = document.getElementById('chat_box');
                 
                 // $("#chat_message").empty(); // 一度ul#chat_messageの子要素を削除
                 // $("#chat_message_right").empty(); // 一度ul#chat_messageの子要素を削除
                 $("#chat_box").empty(); // 一度ul#chat_messageの子要素を削除
                 for (var i = 0; i < data.length; i++) {
                   // sender_idで分岐
                   var str = 'ajax user_id = ' + user_id;
                   console.log(str);
                   var str = 'ajax sender_id = ' + data[i]['sender_id'];
                   console.log(str);
                   if (user_id != data[i]['sender_id']) {
                        var add_element = '<div class="chat_message_wrapper"><div class="chat_user_avatar"><a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" ><img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)"  src="http://www.webncc.in/images/gurdeeposahan.jpg" class="md-user-image"></a></div><ul class="chat_message" id="chat_message"><li><p>' + data[i]['message'] + '</p></li></ul></div>';
                        console.log(add_element);
                        // ul#chat_messageの子要素として追加
                        $(element).append(add_element);
                   } else {
                        var add_element = '<div class="chat_message_wrapper chat_message_right"><div class="chat_user_avatar"><a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" ><img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)" src="http://bootsnipp.com/img/avatars/bcf1c0d13e5500875fdd5a7e8ad9752ee16e7462.jpg" class="md-user-image"></a></div><ul class="chat_message" id="chat_message_right"><li><p>' + data[i]['message'] + '</p></li></ul></div>';
                        console.log(add_element);
                        $(element).append(add_element);
                   }
                   // ↑この追加するというコードを、分岐やメッセージごとに一意なidをタグにつけるなどして
                   // 表示を作っていく
                 };
             },
             /**
              * Ajax通信が失敗した場合に呼び出されるメソッド
              */
             error: function(XMLHttpRequest, textStatus, errorThrown)
             {
                 //通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、単純に通信に失敗した際の処理を記述します。
                 //this;
                 //thisは他のコールバック関数同様にAJAX通信時のオプションを示します。
                 //エラーメッセージの表示
                 alert('Error : ' + errorThrown);
             }
         });
         
         //サブミット後、ページをリロードしないようにする
         return false;
     });

    $('#message_form').submit(function(event)
    {
        // HTMLでの送信をキャンセル
        event.preventDefault();
        var val = $("#submit_message").val();
        console.log(val);
        // jsを使ってセッションにroom_idを保持
        var room_id = window.sessionStorage.getItem(['room_id']);
        console.log(room_id);
        var data = {message_val : val, room_id : room_id};
        // var user_id = <?php echo $_SESSION['id'];?>
        // console.log(user_id);
        /**
         * Ajax通信メソッド
         * @param type  : HTTP通信の種類
         * @param url   : リクエスト送信先のURL
         * @param data  : サーバに送信する値
         */
        $.ajax({
            type: "POST",
            url: "/cebroad/events/chat_send.php",
            data: data,
            /**
             * Ajax通信が成功した場合に呼び出されるメソッド
             */
            success: function(data, dataType)
            {
                // jsonデータをjsの配列データに変換してvar dataに代入
                var data = JSON.parse(data);
                
                //PHPから返ってきたデータの表示
                console.log(data);
                // console.log(data[0]['message']);
                 var element = document.getElementById('chat_box');
                 
                 // $("#chat_message").empty(); // 一度ul#chat_messageの子要素を削除
                 // $("#chat_message_right").empty(); // 一度ul#chat_messageの子要素を削除
                 $("#chat_box").empty(); // 一度ul#chat_messageの子要素を削除
                 for (var i = 0; i < data.length; i++) {
                   // sender_idで分岐
                   if (user_id != data[i]['sender_id']) {
                        var add_element = '<div class="chat_message_wrapper"><div class="chat_user_avatar"><a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" ><img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)"  src="http://www.webncc.in/images/gurdeeposahan.jpg" class="md-user-image"></a></div><ul class="chat_message" id="chat_message"><li><p>' + data[i]['message'] + '</p></li></ul></div>';
                        console.log(add_element);
                        // ul#chat_messageの子要素として追加
                        $(element).append(add_element);
                   } else {
                        var add_element = '<div class="chat_message_wrapper chat_message_right"><div class="chat_user_avatar"><a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" ><img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)" src="http://bootsnipp.com/img/avatars/bcf1c0d13e5500875fdd5a7e8ad9752ee16e7462.jpg" class="md-user-image"></a></div><ul class="chat_message" id="chat_message_right"><li><p>' + data[i]['message'] + '</p></li></ul></div>';
                        console.log(add_element);
                        $(element).append(add_element);
                   }
                  // ↑この追加するというコードを、分岐やメッセージごとに一意なidをタグにつけるなどして
                  // 表示を作っていく
                };

            },
            /**
             * Ajax通信が失敗した場合に呼び出されるメソッド
             */
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                //通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、単純に通信に失敗した際の処理を記述します。
                //this;
                //thisは他のコールバック関数同様にAJAX通信時のオプションを示します。
                //エラーメッセージの表示
                alert('Error : ' + errorThrown);
            }
        });
    
            $('#submit_message').val('');

        //サブミット後、ページをリロードしないようにする
        return false;
    });


 });
 </script>

<div class="container text-center">
    <div class="row">
        <div class="round hollow text-center">
        <!-- organizerの場合はopen btnをwhile文で複数表示、participantの場合は一つ表示の条件分岐-->
        <?php if($event['organizer_id']!=$_SESSION['id']){//対象のイベントのオーガナイザーで無い場合 ?>
         <a href="#" class="open-btn" id=<?php echo $room['id']; ?> onclick="scroll()"><i class="fa fa-comments-o" aria-hidden="true"></i>send to <?php echo $event['title']; ?></a>
        <?php }else{  
            foreach ($rooms as $room) { ?>
            <a href="#" class="open-btn" id=<?php echo $room['id']; ?> onclick="scroll()"><i class="fa fa-comments-o" aria-hidden="true"></i>send to <?php echo $room['participant_id']; ?></a>  
            <?php } ?>
        <?php } ?>
        </div>
    </div>
</div>

<aside id="sidebar_secondary" class="tabbed_sidebar ng-scope chat_sidebar">

    <div class="popup-head">
        <div class="popup-head-left pull-left"><a Design and Developmenta title="Gurdeep Osahan (Web Designer)" target="_blank" href="">
            <img class="md-user-image" alt="" title="" src="" title="" alt="">
            <h1><?php echo $room['title']; ?></h1></a></div>
            <button data-widget="remove" id="removeClass" class="chat-header-button pull-right" type="button"><i class="glyphicon glyphicon-remove"></i></button>
        </div>
    </div>

<div id="chat" class="chat_box_wrapper chat_box_small chat_box_active" style="opacity: 1; display: block; transform: translateX(0px);">
    <div class="chat_box touchscroll chat_box_colors_a" id="chat_box">

    </div>
</div>

<div class="chat_submit_box">
    <div class="uk-input-group">
        <div class="gurdeep-chat-box">
            <form method="post" action="" id="message_form">
                <input type="text" placeholder="Type a message" id="submit_message" name="submit_message" class="md-input">
                <!-- <span class="uk-input-group-addon"> -->
                    <button type="submit" name="submit_message">send</button>
                <!-- </span> -->
            </form>
        </div>
    
<!--     <span class="uk-input-group-addon">
    <a href="#"><i class="glyphicon glyphicon-send"></i></a>
    </span> -->
    </div>
</div>
        
</div>

<script type="text/javascript">
$(function(){
$("a").click(function () {
  $('#sidebar_secondary').addClass('popup-box-on');
    });
  
    $("#removeClass").click(function () {
  $('#sidebar_secondary').removeClass('popup-box-on');
    });
})

function scroll() {
window.scrollTo(0,50);
console.log('scroll');
}

</script>

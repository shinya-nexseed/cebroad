
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

         /**
          * Ajax通信メソッド
          * @param type  : HTTP通信の種類
          * @param url   : リクエスト送信先のURL
          * @param data  : サーバに送信する値
          */
         $.ajax({
             type: "POST",
             url: "/portfolio/cebroad/events/chat_send.php",
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
                   if (data[i]['organizer_id'] == data[i]['sender_id']) {
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

        /**
         * Ajax通信メソッド
         * @param type  : HTTP通信の種類
         * @param url   : リクエスト送信先のURL
         * @param data  : サーバに送信する値
         */
        $.ajax({
            type: "POST",
            url: "/portfolio/cebroad/events/chat_send.php",
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
                   if (data[i]['organizer_id'] == data[i]['sender_id']) {
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
 });
 </script>

<div class="container text-center">
    <div class="row">
        <div class="round hollow text-center">
         <a href="#" class="open-btn" id="1"><i class="fa fa-comments-o" aria-hidden="true"></i>room1</a>
         <a href="#" class="open-btn" id="2"><i class="fa fa-comments-o" aria-hidden="true"></i>room2</a>
        </div>
    </div>
</div>


<aside id="sidebar_secondary" class="tabbed_sidebar ng-scope chat_sidebar">

    <div class="popup-head">
        <div class="popup-head-left pull-left"><a Design and Developmenta title="Gurdeep Osahan (Web Designer)" target="_blank" href="">
            <img class="md-user-image" alt="" title="" src="" title="" alt="">
            <h1>Gurdeep Osahan</h1><small><br> <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> Web Designer</small></a></div>
            <button data-widget="remove" id="removeClass" class="chat-header-button pull-right" type="button"><i class="glyphicon glyphicon-remove"></i></button>
        </div>
    </div>

<div id="chat" class="chat_box_wrapper chat_box_small chat_box_active" style="opacity: 1; display: block; transform: translateX(0px);">
    <div class="chat_box touchscroll chat_box_colors_a" id="chat_box">
        <!-- 左メッセージ -->
        <!-- <div class="chat_message_wrapper">
            <div class="chat_user_avatar">
                <a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" >
                <img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)"  src="http://www.webncc.in/images/gurdeeposahan.jpg" class="md-user-image">
                </a>
            </div>
            <ul class="chat_message" id="chat_message">
                
            </ul>
        </div> -->

        <!-- 右メッセージ -->
        <div class="chat_message_wrapper chat_message_right">
            <div class="chat_user_avatar">
            <a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" >
                <img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)" src="http://bootsnipp.com/img/avatars/bcf1c0d13e5500875fdd5a7e8ad9752ee16e7462.jpg" class="md-user-image">
            </a>
            </div>
            <ul class="chat_message" id="chat_message_right">
                <!-- <li>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem delectus distinctio dolor earum est hic id impedit ipsum minima mollitia natus nulla perspiciatis quae quasi, quis recusandae, saepe, sunt totam.
                        <span class="chat_message_time">13:34</span>
                    </p>
                </li> -->
            </ul>
        </div>

    </div>
</div>

<div class="chat_submit_box">
    <div class="uk-input-group">
        <div class="gurdeep-chat-box">
            <form method="post" action="" id="message_form">
                <input type="text" placeholder="Type a message" id="submit_message" name="submit_message" class="md-input">
                <!-- <span class="uk-input-group-addon"> -->
                    <button type="submit" name="submit_message"><i class="glyphicon glyphicon-send"></i></button>
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
</script>

<?php 

 ?>
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

         var data = {room_id : id};

         /**
          * Ajax通信メソッド
          * @param type  : HTTP通信の種類
          * @param url   : リクエスト送信先のURL
          * @param data  : サーバに送信する値
          */
         $.ajax({
             type: "POST",
             url: "chat_send.php",
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

                 var element = document.getElementById('chat_message');
                 // console.log(element);

                 $("#chat_message").empty(); // 一度ul#chat_messageの子要素を削除

                 for (var i = 0; i < data.length; i++) {
                   var add_element = '<li>' + data[i]['message'] + '</li>';
                   console.log(add_element);

                   // ul#chat_messageの子要素として追加
                   $(element).append(add_element);
                 };


                 // clickしたinputタグを取得し、スタイルの変更やチェックのon/offを切り替える
                 // var element = document.getElementById(data['id']);
                 // element.checked = data['completed'];

                 // element.nextSibling.classList.toggle('checked');
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
    <div class="chat_box touchscroll chat_box_colors_a">
        
        <div class="chat_message_wrapper">
            <div class="chat_user_avatar">
                <a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" >
                <img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)"  src="http://www.webncc.in/images/gurdeeposahan.jpg" class="md-user-image">
                </a>
            </div>
            <ul class="chat_message" id="chat_message">
                <!-- <li>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio, eum? </p>
                </li>
                <li>
                    <p> Lorem ipsum dolor sit amet.<span class="chat_message_time">13:38</span> </p>
                </li> -->
            </ul>
        </div>

        <!-- <div class="chat_message_wrapper chat_message_right">
            <div class="chat_user_avatar">
            <a href="https://web.facebook.com/iamgurdeeposahan" target="_blank" >
                <img alt="Gurdeep Osahan (Web Designer)" title="Gurdeep Osahan (Web Designer)" src="http://bootsnipp.com/img/avatars/bcf1c0d13e5500875fdd5a7e8ad9752ee16e7462.jpg" class="md-user-image">
            </a>
            </div>
            <ul class="chat_message">
                <li>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem delectus distinctio dolor earum est hic id impedit ipsum minima mollitia natus nulla perspiciatis quae quasi, quis recusandae, saepe, sunt totam.
                        <span class="chat_message_time">13:34</span>
                    </p>
                </li>
            </ul>
        </div> -->

    </div>
</div>

<div class="chat_submit_box">
    <div class="uk-input-group">
        <div class="gurdeep-chat-box">
            <form method="post" action="">
                <input type="text" placeholder="Type a message" id="submit_message" name="submit_message" class="md-input">
            </form>
        </div>
    
    <span class="uk-input-group-addon">
    <a href="#"><i class="glyphicon glyphicon-send"></i></a>
    </span>
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

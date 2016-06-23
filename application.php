<?php
  // session_start();
  require('dbconnect.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
    <link href="/cebroad/webroot/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/cebroad/webroot/assets/font-awesome/css/font-awesome.css">
    <link href="/cebroad/webroot/assets/css/styles.css" rel="stylesheet">

<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Oswald:400,300);
@import url(https://fonts.googleapis.com/css?family=Open+Sans);
body
{
font-family: 'Open Sans', sans-serif;
}
.chat_box .chat_message_wrapper ul.chat_message > li + li {
    margin-top: 4px;
}
.popup-box-on {
    display: block !important;
}
a:focus {
    outline: none;
    outline-offset: 0px;
}
.popup-head-left.pull-left h1 {
    color: #fff;
    float: left;
    font-family: oswald;
    font-size: 18px;
    margin: 2px 0 0 5px;
   
}
.popup-head-left a small {
    display: table;
    font-size: 11px;
    color: #fff;
    line-height: 4px;
    opacity: 0.5;
    padding: 0 0 0 7px;
}
.chat-header-button {
    background: transparent none repeat scroll 0 0;
    border: 1px solid #fff;
    border-radius: 7px;
    font-size: 15px;
    height: 26px;
    opacity: 0.9;
    padding: 0;
    text-align: center;
    width: 26px;
}
.popup-head-right {
    margin: 9px 0 0;
}
.popup-head .btn-group {
    margin: -5px 3px 0 -1px;
}
.gurdeepoushan .dropdown-menu {
    padding: 6px;
}
.gurdeepoushan .dropdown-menu li a span {
    border: 1px solid;
    border-radius: 50px;
    display: list-item;
    font-size: 19px;
    height: 40px;
    line-height: 36px;
    margin: auto;
    text-align: center;
    width: 40px;
}
.gurdeepoushan .dropdown-menu li {
    float: left;
    text-align: center;
    width: 33%;
}
.gurdeepoushan .dropdown-menu li a {
    border-radius: 7px;
    font-family: oswald;
    padding: 3px;
   transition: all 0.3s ease-in-out 0s;
}
.gurdeepoushan .dropdown-menu li a:hover {
    background:#304445 none repeat scroll 0 0 !important;
    color: #fff;
}
.popup-head {
    background: #304445 none repeat scroll 0 0 !important;
    border-bottom: 3px solid #ccc;
    color: #fff;
    display: table;
    width: 100%;
    padding: 8px;
}
.popup-head .md-user-image {
    border: 2px solid #5a7172;
    border-radius: 12px;
    float: left;
    width: 44px;
}
.uk-input-group-addon .glyphicon.glyphicon-send {
    color: #ffffff;
    font-size: 21px;
    line-height: 36px;
    padding: 0 6px;
}
.chat_box_wrapper.chat_box_small.chat_box_active {
    
    height: 342px;
    overflow-y: scroll;
    width: 316px;
}
aside {
     background-attachment: fixed;
    background-clip: border-box;
    background-color: rgba(0, 0, 0, 0);
    background-image: url("https://scontent.fixc1-1.fna.fbcdn.net/v/t1.0-9/12670232_624826600991767_3547881030871377118_n.jpg?oh=92b8b3e25bdd56df4af5dc466feb46ce&oe=57CC10E7");
    background-origin: padding-box;
    background-position: center top;
    background-repeat: repeat;
    border: 1px solid #304445;
    bottom: 0;
    display: none;
    height: 466px;
    position: fixed;
    right: 70px;
    width: 300px;
    font-family: 'Open Sans', sans-serif;
}
.chat_box {
    padding: 16px;
}
.chat_box .chat_message_wrapper::after {
    clear: both;
}
.chat_box .chat_message_wrapper::after, .chat_box .chat_message_wrapper::before {
    content: " ";
    display: table;
}
.chat_box .chat_message_wrapper .chat_user_avatar {
    float: left;
}
.chat_box .chat_message_wrapper {
    margin-bottom: 32px;
}
.md-user-image {
    border-radius: 50%;
    width: 34px;
}
img {
    border: 0 none;
    box-sizing: border-box;
    height: auto;
    max-width: 100%;
    vertical-align: middle;
}
.chat_box .chat_message_wrapper ul.chat_message, .chat_box .chat_message_wrapper ul.chat_message > li {
    list-style: outside none none;
    padding: 0;
}
.chat_box .chat_message_wrapper ul.chat_message {
    float: left;
    margin: 0 0 0 20px;
    max-width: 77%;
}
.chat_box.chat_box_colors_a .chat_message_wrapper ul.chat_message > li:first-child::before {
    border-right-color: #616161;
}
.chat_box .chat_message_wrapper ul.chat_message > li:first-child::before {
    border-color: transparent #ededed transparent transparent;
    border-style: solid;
    border-width: 0 16px 16px 0;
    content: "";
    height: 0;
    left: -14px;
    position: absolute;
    top: 0;
    width: 0;
}
.chat_box.chat_box_colors_a .chat_message_wrapper ul.chat_message > li {
    background: #FCFBF6 none repeat scroll 0 0;
    color: #000000;
}
.open-btn {
    border: 2px solid #189d0e;
    border-radius: 32px;
    color: #189d0e !important;
    display: inline-block;
    margin: 10px 0 0;
    padding: 9px 16px;
    text-decoration: none !important;
    text-transform: uppercase;
}
.chat_box .chat_message_wrapper ul.chat_message > li {
    background: #ededed none repeat scroll 0 0;
    border-radius: 4px;
    clear: both;
    color: #212121;
    display: block;
    float: left;
    font-size: 13px;
    padding: 8px 16px;
    position: relative;
    word-break: break-all;
}
.chat_box .chat_message_wrapper ul.chat_message, .chat_box .chat_message_wrapper ul.chat_message > li {
    list-style: outside none none;
    padding: 0;
}
.chat_box .chat_message_wrapper ul.chat_message > li {
    margin: 0;
}
.chat_box .chat_message_wrapper ul.chat_message > li p {
    margin: 0;
}
.chat_box.chat_box_colors_a .chat_message_wrapper ul.chat_message > li .chat_message_time {
    color: rgba(185, 186, 180, 0.9);
}
.chat_box .chat_message_wrapper ul.chat_message > li .chat_message_time {
    color: #727272;
    display: block;
    font-size: 11px;
    padding-top: 2px;
    text-transform: uppercase;
}
.chat_box .chat_message_wrapper.chat_message_right .chat_user_avatar {
    float: right;
}
.chat_box .chat_message_wrapper.chat_message_right ul.chat_message {
    float: right;
    margin-left: 0 !important;
    margin-right: 24px !important;
}
.chat_box.chat_box_colors_a .chat_message_wrapper.chat_message_right ul.chat_message > li:first-child::before {
    border-left-color: #E8FFD4;
}
.chat_box.chat_box_colors_a .chat_message_wrapper ul.chat_message > li:first-child::before {
    border-right-color: #FCFBF6;
}
.chat_box .chat_message_wrapper.chat_message_right ul.chat_message > li:first-child::before {
    border-color: transparent transparent transparent #ededed;
    border-width: 0 0 29px 29px;
    left: auto;
    right: -14px;
}
.chat_box .chat_message_wrapper ul.chat_message > li:first-child::before {
    border-color: transparent #ededed transparent transparent;
    border-style: solid;
    border-width: 0 29px 29px 0;
    content: "";
    height: 0;
    left: -14px;
    position: absolute;
    top: 0;
    width: 0;
}
.chat_box.chat_box_colors_a .chat_message_wrapper.chat_message_right ul.chat_message > li {
    background: #E8FFD4 none repeat scroll 0 0;
}
.chat_box .chat_message_wrapper ul.chat_message > li {
    background: #ededed none repeat scroll 0 0;
    border-radius: 12px;
    clear: both;
    color: #212121;
    display: block;
    float: left;
    font-size: 13px;
    padding: 8px 16px;
    position: relative;
}
.gurdeep-chat-box {
    background: #fff none repeat scroll 0 0;
    border-radius: 5px;
    float: left;
    padding: 3px;
    width: 243px;
}
#submit_message {
    background: transparent none repeat scroll 0 0;
    border: medium none;
    padding: 4px;
}
.gurdeep-chat-box i {
    color: #333;
    font-size: 21px;
    line-height: 1px;
}
.chat_submit_box {
    bottom: 0;
    box-sizing: border-box;
    left: 0;
    overflow: hidden;
    padding: 10px;
    position: absolute;
    width: 100%;
}
.uk-input-group {
    border-collapse: separate;
    display: table;
    position: relative;
}
    </style>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
                
    <?php
    require($resource.'/'.$action.'.php');
    ?>     
  
</body>
</html>

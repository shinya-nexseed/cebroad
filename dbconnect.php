<?php
    if (DEBUG) { // development
        $db = mysqli_connect('localhost', 'root', 'mysql', 'cebroad') or die(mysqli_connect_error());
        mysqli_set_charset($db, 'utf8');
    } else { // production
        $db = mysqli_connect('mysql465.db.sakura.ne.jp', 'nexseed', 'nexseedwebsite129', 'nexseed_cebroad') or die(mysqli_connect_error());
        mysqli_set_charset($db, 'utf8');
    }
?>

<?php
	
	//ページネイション
	$page = $id;//ページ番号を/resource/action/idのidとして取得
	if($page == ''){
		$page = 1;//$pageが空の場合は$pageに1を代入
	}
	$page = max($page, 1);//ページ数が0以下にならないように、0以下の場合は1にできるようにする（1と0を比較して大きい方を代入する）


	//最終ページの番号を取得する
	if(!empty($_POST['srch-categories'])&&!empty($_POST['srch-word'])){
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM events WHERE event_category_id=%d AND event_name LIKE "%%%s%%"',
			$_POST['srch-categories'],
			$_POST['srch-word']
			);
	}
	else if(!empty($_POST['srch-categories'])){
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM events WHERE event_category_id=%d',
			$_POST['srch-categories']
			);
	}
	else if(!empty($_POST['srch-word'])){
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM events WHERE event_name LIKE "%%%s%%"',
			$_POST['srch-word']
			);
	}
	else{
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM events');
	}


	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$table = mysqli_fetch_assoc($records);
	$maxPage = ceil(intval($table['cnt']) / 6);//必要なページ数を計算する(ceil関数で切り上げて整数値を返す)
	$page = min($page, $maxPage);//$maxPageが1より小さい場合（不正なページ数）は補正

	$start = ($page - 1) * 6;

	$start=max(0,$start);


	//一覧化するイベントのデータを取得（LIMIT句は1ページで表示する数を決める）
	//あいまい検索+カテゴリ検索
	if(!empty($_POST['srch-categories'])&&!empty($_POST['srch-word'])){
		$sql = sprintf('SELECT * FROM events WHERE event_category_id=%d AND event_name LIKE "%%%s%%" ORDER BY date DESC LIMIT '.$start.', 6',
			$_POST['srch-categories'],
			$_POST['srch-word']
			);
	}
	//カテゴリ検索のみ
	else if(!empty($_POST['srch-categories'])){
			$sql = sprintf('SELECT * FROM events WHERE event_category_id=%d ORDER BY date DESC LIMIT '.$start.', 6',
			$_POST['srch-categories']
			);
	}
	//あいまい検索のみ
	else if(!empty($_POST['srch-word'])){
			$sql = sprintf('SELECT * FROM events WHERE event_name LIKE "%%%s%%" ORDER BY date DESC LIMIT '.$start.', 6',
			$_POST['srch-word']
			);
	}
	else{
		//イベント一覧を全取得
		$sql = 'SELECT * FROM events ORDER BY date DESC LIMIT '.$start.', 6';
	}

	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$rtn = array();
	while($result = mysqli_fetch_assoc($records)) {
	  $rtn[] = $result;
	 }


	//保存されているいいねで一番小さいevent_idを取得する
	$sql = sprintf('SELECT MIN(event_id) AS min FROM likes WHERE 1');

	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$min = mysqli_fetch_assoc($records);


	//保存されているいいねで一番大きいevent_idを取得する
	$sql = sprintf('SELECT MAX(event_id) AS max FROM likes WHERE 1');

	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$max = mysqli_fetch_assoc($records);


	//event_idの小さい数字から大きい数字までいいねのユーザーの数をevent_id毎にカウントする
	$cnt_likes=array();

	for ($i=$min['min']; $i <($max['max']+1) ; $i++) { //maxの値に+1をいれることでmaxの値までカウントする
		$sql = sprintf('SELECT COUNT(user_id) AS cnt FROM likes WHERE event_id='.$i);
		$records = mysqli_query($db, $sql) or die(mysqli_error($db));
		$cnt_likes[$i]=mysqli_fetch_assoc($records);
	}


	//保存されている参加者で一番小さいevent_idを取得する
	$sql = sprintf('SELECT MIN(event_id) AS min FROM participants WHERE 1');

	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$min = mysqli_fetch_assoc($records);


	//保存されている参加者で一番大きいevent_idを取得する
	$sql = sprintf('SELECT MAX(event_id) AS max FROM participants WHERE 1');

	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$max = mysqli_fetch_assoc($records);


	//event_idの小さい数字から大きい数字まで参加者のユーザーの数をevent_id毎にカウントする
	$cnt_likes=array();

	for ($i=$min['min']; $i <($max['max']+1) ; $i++) { //maxの値に+1をいれることでmaxの値までカウントする
		$sql = sprintf('SELECT COUNT(user_id) AS cnt FROM participants WHERE event_id='.$i);
		$records = mysqli_query($db, $sql) or die(mysqli_error($db));
		$cnt_participants[$i]=mysqli_fetch_assoc($records);
	}


	//当日の日付を取得する
	 $today = substr(date("c"),5,5);

 ?>


            <div class="col-sm-10 col-md-10">
        		<div class="col-sm-12 col-md-12 events-pad">
        			<button class="btn btn-cebroad pull-right " onclick="location.href='/cebroad/events/add'">Create a new event</button><br><br>
        		</div>

        		<!-- イベントID毎に表示 -->
    			<?php foreach ($rtn as $event): ?>

    				<div class="col-sm-4 col-md-4">				
                        <div class="panel panel-default">
                        	<!-- 画像 -->
                        	<div class="panel-thumbnail"><img class="img-responsive" src="<?=h($event['picture_path_1'])?>"></div>
                                <div class="panel-body">
                                	<!-- イベント名 -->
                                    <a href="/cebroad/events/show/<?=h($event['id'])?>">
                                    <p class="lead"><?=h($event['event_name'])?></p></a>

                                    <!-- 日付 -->
                                    
									<?php if($today<h(substr($event['date'],5,5))){ ?>
										<p>Date:
										<?php echo h(substr($event['date'],5,5)); ?>
										</p>
									<?php }else{ ?>
										<p>Date:Closed</p>
									<?php } ?>
                                    

                                    <!-- いいねの数 -->
                                    <!-- $cnt_***[$event['id']]['cnt']=cnt_***[イベントID][カウントの配列名]を表す -->
                                   	<p class="event_people"><i class="fa fa-users fa-lg"></i>:
                                   	<?php 
                                   	if(isset($cnt_participants[$event['id']]['cnt'])){
                                   		echo $cnt_participants[$event['id']]['cnt']; 
                                   	} else {
                                   		echo '0';
                                   	}
                                   	?></p>

                                   	<!-- 参加者数 -->
                                   	
    								<p class="event_like"><i class="fa fa-thumbs-o-up fa-lg"></i>:
    								<?php 
    									if(isset($cnt_likes[$event['id']]['cnt'])){
                                   		echo $cnt_likes[$event['id']]['cnt']; 
                                   	} else{
                                   		echo '0';
                                   	} 
    								?></p>
    								
                                </div>
                            </div>
    				</div>
    			<?php endforeach; ?>

    			<!-- 検索時のパラメータ文字列を作成 -->

    			<?php

    			if(!empty($_POST['srch-categories'])){
    				$srch_categories=$_POST['srch-categories'];
    			}
    			if(!empty($_POST['srch-word'])){
    				$srch_word=$_POST['srch-word'];
    			}
    			?>

    			<!-- ページジャンプ 1ページ目、最終ページからはリンクジャンプしないように条件分岐を設定-->
    		<div class="col-sm-12 col-md-12 events-pad">	

    				<form method="post" action="/cebroad/events/index/<?php echo ($page - 1); ?>" style="display:inline;">
    					<?php if(isset($srch_categories)){ ?>
    					<input type="hidden" name="srch-categories" value="<?php echo $srch_categories;?>">
    					<?php } ?>
    					<?php if(isset($srch_word)){ ?>
    					<input type="hidden" name="srch-word" value="<?php echo $srch_word;?>">
    					<?php } ?>

    					<?php if($page > 1){ ?>
    					<input type="submit" value="Back" class="btn btn-default">
    					<?php } else { ?>
    					<input type="submit" value="Back" class="btn btn-default" disabled="disabled">
    					<?php } ?>
    				</form>

    				&nbsp;&nbsp;|&nbsp;&nbsp;
    				<form method="post" action="/cebroad/events/index/<?php echo ($page + 1); ?>" style="display:inline;">
    					<?php if(isset($srch_categories)){ ?>
    					<input type="hidden" name="srch-categories" value="<?php echo $srch_categories;?>">
    					<?php } ?>
    					<?php if(isset($srch_word)){ ?>
    					<input type="hidden" name="srch-word" value="<?php echo $srch_word;?>">
    					<?php } ?>

    					<?php if($page < $maxPage){ ?>
    					<input type="submit" value="Next" class="btn btn-default">
    					<?php } else { ?>
    					<input type="submit" value="Next" class="btn btn-default" disabled="disabled">
    					<?php } ?>
    				</form>

    		</div>
        </div>
		

<!-- <div class="col-sm-12"> -->
                      
                        <!-- content -->                      
                        <div class="row">

                         <!-- イベントメイン写真 -->
                        <div class="col-sm-12">
                          <div class="panel panel-default">
                                <!-- <div class="panel-thumbnail"> -->
                            <p class="text"><img src="/cebroad/webroot/assets/images/mali.jpg" class="topimg img-responsive " width="100%" height="50%"></p>
                                <!-- </div> -->
                            <div class="panel-body">
                              <p class="lead"><?php echo $event['event_name']; ?></p>
                              <h4><i class="fa fa-users" aria-hidden="true"></i><?php echo $cnt_paticipant['cnt']?>  <i class="fa fa-thumbs-o-up" aria-hidden="true"></i><?php echo $cnt_like['cnt']?></h4>
                                  
                              <p>
                                <img src="/cebroad/images/<? echo $organizer['profile_picture_path'];?>" class="img-circle pull-left">
                              </p>


                              <!-- いいねボタン -->
                              <form method="post" action="" class="navbar-right">
                                  <input type="hidden" name="like" value="1">
                                  <?php if($table_like['cnt']>0){ ?>
                                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i><input type="submit" class="btn btn-default" value="Cansel">
                                  <?php }else { ?>
                                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i><input type="submit" class="btn btn-success" value="Like">
                                  <?php } ?>
                              </form>

                              <!-- 参加者ボタン -->
                              <!-- ログインしているユーザーでないとき参加者ボタンを表示 -->
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
                         <div class="col-sm-4 col-sm-push-8">
                           
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
                                        <img src=/cebroad/images/<? echo $event_participant['profile_picture_path'];?> class="img-circle pull-left">
                                      <?php } ?>
                                    </div>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- main col right -->
                          <div class="col-sm-8 col-sm-pull-4" >
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
                                      <h5><?php echo $comment['nick_name']; ?></h5>
                                      <p><?php echo $comment['comment']; ?><p>
                                      <p class="navar-right"><?php echo $comment['created']; ?><p>

                                      <form name="delete" method="post" action="">
                                        <input type="hidden" name="comment_delete" value="<?php echo $comment['comment_id'] ?>">
                                        <p class="navar-right"><a href="javascript.delete.submit()">delete</a></p>
                                      </form>
                                    <?php } ?>
                                  </div>
                               </div>
                          </div>
                       </div><!-- /row -->
                    <!-- </div>/col-9 -->
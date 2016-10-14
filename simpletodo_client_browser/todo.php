<?php
    session_start();
    include_once('apicaller.php');
 
    $apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', 'kishore.afixiindia.com/Kishore/todoapi/simpletodo_api/');
    //$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', 'bhagyashree.afixiindia.com/simpletodo_api/');
    
    $todo_items = $apicaller->sendRequest(array(
        'controller' => 'todo',
        'action'     => 'list',
        'username'   => $_SESSION['username'],
        'password'   => $_SESSION['userpass']
    ));
    
//    echo '2. ';
//   echo "<pre>";var_dump($todo_items);echo "</pre><br>";
//   echo "===========================================<br>";
//   echo "<pre>";print_r($todo_items);echo "</pre><br>";
//   echo "===========================================<br>";
//foreach ($todo_items as $key => $value) {
// echo $value['title']."<br>k";
//}exit;
?>
    <!DOCTYPE html>
<html>
    <head>
        <title>SimpleTODO</title>

        <link rel="stylesheet" href="css/reset.css" type="text/css" />
        <!--<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />-->
        <link rel="stylesheet" href="css/jquery-ui-1.10.4.custom.css" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--<script src="js/jquery-3.1.0.min.js"></script>-->
        <script src="js/jquery-ui.min.js"></script>

        <style>
        body {
            padding-top: 40px;
        }
        #main {
            margin-top: 80px;
        }

        .textalignright {
            text-align: right;
        }

        .marginbottom10 {
            margin-bottom: 10px;
        }
        #newtodo_window {
            text-align: left;
            display: none;
        }
        </style>

        <script>
        $(document).ready(function() {
            //$("#accordian").accordion({
              //  collapsible: true
            //});
            $(".datepicker").datepicker();
            $('#newtodo_window').dialog({
                autoOpen: false,
                height: 'auto',
                width: 'auto',
                modal: true
            });
            $('#newtodo').click(function() {
                $('#newtodo_window').dialog('open');
            });
            
        });
        function setisdone(){
//            $("#is_done").val("1");
//            $('#frm').submit();
        
    }
        </script>
    </head>
    <body>
        <div class="topbar">
            <div class="fill">
                <div class="container">
                    <a class="brand" href="index.php">SimpleTODO</a>
                </div>
            </div>
        </div>
        <div id="main" class="container">
            <div class="textalignright marginbottom10">
                <span id="newtodo" class="btn info">Create a new TODO item</span>
                <div id="newtodo_window" title="Create a new TODO item" style="background-color:#D0E0F2">
                    <form method="POST" action="new_todo.php">
                        <p>Title:<br /><input type="text" class="title" name="title" placeholder="TODO title" /></p>
                        <p>Date Due:<br /><input type="text" class="datepicker" name="date_due" placeholder="MM/DD/YYYY" /></p>
                        <p>Description:<br /><textarea class="description" name="description"></textarea></p>
                        <div class="actions">
                            <input type="submit" value="Create" name="new_submit" class="btn primary" />
                        </div>
                    </form>
                </div>
            </div>
            <!--<div id="todolist">-->
            <div id="accordian" class="panel-group">
                <?php $cnt = 0; ?>
               <?php foreach ($todo_items as $key => $value) :?>
                <?php $cnt = $cnt+1; ?>
                
                <div class="panel panel-default">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cnt; ?>">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <?php echo $value['title']; ?>
                            </h4>
                        </div>
                    </a>
                    <div id="collapse<?php echo $cnt; ?>" class="panel-collapse collapse" style="border:1px solid #1f6377">
                        <div class="panel-body">
                            <form id="frm" method="POST" action="update_todo.php">
                                <div class="textalignright">
                                    <a style="border:10px solid #D2E0E6;border-radius: 10px"href="delete_todo.php?todo_id=<?php echo $value['todo_id']; ?>">Delete</a>
                                </div>
                                <div>
                                    <p>Date Due:<input type="text" id="datepicker_<?php echo $value['todo_id']; ?>" style='height:30px !important' class="datepicker" name="date_due" value="<?php echo $value['date_due']; ?>" /></p>
                                    <p>Title   :<br/><input type="text" id="title" style='width: 62%' name="title" value="<?php echo $value['title']; ?>" /></p>
                                    <p>Description:<br /><textarea class="span8" id="description_<?php echo $value['todo_id']; ?>"  rows="5" cols="80" class="description" name="description"><?php echo $value['description']; ?></textarea></p>
                                </div>
                                <div class="textalignright">
                                    <?php if( $value['is_done'] == '0' ): ?>
                                    <input type="hidden" id="is_done" value="mark" name="is_done" />
                                    <input type="submit" class="btn" value="Mark as Done?" name="markasdone_button" onclick="setisdone();"/>
                                    <?php else: ?>
                                    <!--<input type="hidden" value="<?php //echo $value['is_done']; ?>" name="is_done" />-->
                                    <input type="button" style="background: #32e915 !important;" class="btn success" value="Done!" name="done_button" />
                                    <?php endif; ?>
                                    <input type="hidden" value="<?php echo $value['todo_id']; ?>" name="todo_id" />
                                    <!--<input type="hidden" value="<?php //echo $value['title']; ?>" name="title" />-->
                                    <input type="submit" class="btn primary" value="Save Changes" name="update_button" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

                
                <?php //foreach($todo_items as $todo=>$val): ?><?php //echo $todo_items[$todo];?>
                <!--h3><a href="#"><?php //echo $todo->title; ?></a></h3>
                <div>
                    <form method="POST" action="update_todo.php">
                    <div class="textalignright">
                        <a href="delete_todo.php?todo_id=<?php //echo $todo->todo_id; ?>">Delete</a>
                    </div>
                    <div>
                        <p>Date Due:<br /><input type="text" id="datepicker_<?php //echo $todo->todo_id; ?>" class="datepicker" name="due_date" value="12/09/2011" /></p>
                        <p>Description:<br /><textarea class="span8" id="description_<?php //echo $todo->todo_id; ?>" class="description" name="description"><?php //echo $todo->description; ?></textarea></p>
                    </div>
                    <div class="textalignright">
                        <?php //if( $todo->is_done == 'false' ): ?>
                        <input type="hidden" value="false" name="is_done" />
                        <input type="submit" class="btn" value="Mark as Done?" name="markasdone_button" />
                        <?php //else: ?>
                        <input type="hidden" value="true" name="is_done" />
                        <input type="button" class="btn success" value="Done!" name="done_button" />
                        <?php //endif; ?>
                        <input type="hidden" value="<?php //echo $todo->todo_id; ?>" name="todo_id" />
                        <input type="hidden" value="<?php //echo $todo->title; ?>" name="title" />
                        <input type="submit" class="btn primary" value="Save Changes" name="update_button" />
                    </div>
                    </form>
                </div-->
                <?php //endforeach; ?>
            </div>
        </div>
    </body>
</html>
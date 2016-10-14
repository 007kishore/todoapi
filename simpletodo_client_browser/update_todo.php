<?php

session_start();
include_once 'apicaller.php';

$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', 'kishore.afixiindia.com/Kishore/todoapi/simpletodo_api/');
//$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', 'bhagyashree.afixiindia.com/simpletodo_api/');
    

//echo "<pre>";print_r($_POST);echo "</pre>";exit;

$isdone = isset($_POST['markasdone_button'])?'1':'0';

$new_item = $apicaller->sendRequest(array(
    'controller' => 'todo',
    'action' => 'update',
    'title' => $_POST['title'],
    'todo_id' => $_POST['todo_id'],
    'date_due' => date('Y-m-d', strtotime($_POST['date_due'])),
    'description' => $_POST['description'],
    'is_done' => $isdone
));

header('location: todo.php');
exit;

?>
<?php
session_start();
include_once 'apicaller.php';

//$apicaller = new ApiCaller('APP001','28e336ac6c9423d946ba02d19c6a2632','bhagyashree.afixiindia.com/simpletodo_api/');
$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', 'kishore.afixiindia.com/Kishore/todoapi/simpletodo_api/');
$delete_item = $apicaller->sendRequest(array(
    'controller'    => 'todo',
    'action'        => 'delete',
    'todo_id'       => $_GET['todo_id']
));

header('location: todo.php');
exit();
<?php

session_start();
include_once 'apicaller.php';

$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', 'kishore.afixiindia.com/Kishore/todoapi/simpletodo_api/');
//$apicaller = new ApiCaller('APP001', '28e336ac6c9423d946ba02d19c6a2632', 'bhagyashree.afixiindia.com/simpletodo_api/');
    
$new_item = $apicaller->sendRequest(array(
    'controller' => 'todo',
    'action' => 'create',
    'title' => $_POST['title'],
    'date_due' => date('Y-m-d', strtotime($_POST['date_due'])),
    'description' => $_POST['description'],
    'username' => $_SESSION['username'],
    'password' => $_SESSION['userpass']
));

header('location: todo.php');
exit;

?>
<?php

/* 
 * This file acts as the front controller of our applicatio.
 * Each request will be routed through this file.
 */
define('DATA_PATH', realpath(dirname(__FILE__).'/data'));

include_once('database.php');

//Define the ID-KEY pair
$applications = ['APP001'  => '28e336ac6c9423d946ba02d19c6a2632', //randomly generated app key
    ];


//echo "<pre>";print_r($conn);echo "</pre>";exit;
//Including our model
include_once('models/TodoItem.php');

//wrapping the whole thing in a try catch block
try{
    
    //Get the encrypted request
    $enc_request = $_REQUEST['enc_request'];
    
    //Get the provided app_id
    $app_id = $_REQUEST['app_id'];
    
    //Check first if the app_id is present in the list of applications
    if(!isset($applications[$app_id])){
        throw new Exception("Application Doesn't exist");
    }
    //return json_encode($_REQUEST);exit();
    //decrypt the request
    $params = json_decode(trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $applications[$app_id], base64_decode($enc_request), MCRYPT_MODE_ECB)));
    //check if the request is valid by checking if it's an array and looking for controller and action
    if($params == false || isset($params->controller) == false || isset($params->action) == false){
        throw new Exception('Request is not valid');
    }
    
    //$params = array($params);
    
    $params = json_decode(json_encode($params), true); //converting from stdClass object to array format
    
    //$params = $_REQUEST;
    //echo json_encode($params);exit();
    $controller = ucfirst(strtolower($params['controller']));
    
    $action = strtolower($params['action']).'Action';

    //check controller exists, if not, throw an exception
    if(file_exists("controllers/{$controller}.php")){
        include_once ("controllers/{$controller}.php");
    }else{
        throw new Exception('Controller is invalid');
    }
    
    //create a new instance of controller and pass the parameters from the request
    $controller = new $controller($params);
    
    //check the action exists in the contoller, if not, throw an exception
    if(method_exists($controller, $action)==false){
        throw new Exception("Action is invalid");
    }
    
    //execute the action
    $result['data'] = $controller->$action();
    $result['success'] = true;
    
}catch(Exception $e){
    //catch any exception and report the problem
    echo "<pre>";print_r($e);echo "</pre>";
    $result = array();
    $result['success'] = false;
    $result['errormsg'] = $e->getMessage();
}

echo json_encode($result);
exit();
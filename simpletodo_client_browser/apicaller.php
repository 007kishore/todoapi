<?php

class ApiCaller{
    private $_app_id;
    private $_app_key;
    private $_api_url;
    
    //construct ApiCaller object by taking the APP_ID, APP_KEY & API_URL parameters
    public function __construct($app_id, $app_key, $api_url) {
        $this->_app_id  = $app_id;
        $this->_app_key = $app_key;
        $this->_api_url = $api_url;
        
       //echo "1.<pre>"; print_r($this);echo "</pre><br>";
    }
    
    //send the request to API Server and also encrypt the request and checks if the results are valid
    public function sendRequest($request_params){
        //echo "2.<pre>"; print_r($request_params);echo "</pre><br>";
        
        //$enc = json_encode($request_params);
        //echo $enc;
        //$dec = json_decode($enc);exit;
        //echo $dec->controller;exit;
        
        //encrypt the request parameters
        $enc_request = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->_app_key, json_encode($request_params), MCRYPT_MODE_ECB));
        
//        echo $enc_request."<br>";
//        $paramas    = json_decode(trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->_app_key, base64_decode($enc_request), MCRYPT_MODE_ECB)));
//        if($paramas){print_r($paramas);echo "<br>";
//        $arr = array($paramas);echo "<br>";print_r($arr);
//        $array = json_decode(json_encode($paramas), true);
//        echo $array['controller'];
//        exit;}else{
//            echo "false";exit;
//        }
        
        //Creating the params array which will be the POST parameters
        $params = array();
        $params['enc_request'] = $enc_request;
        $params['app_id'] = $this->_app_id;
        //echo "<pre>";print_r($params);echo "</pre>";exit;
        //initialize and set up the curl handler
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        
        //execute the request
        $result = curl_exec($ch);

        //json_decode the result
        //$result = json_decode($result);    // without 'true' parameter it returns a stdClass object
        $result = json_decode($result, true);   // 'true' parameter is to return as an associative array
        //echo "1.<pre>";print_r($result);echo "</pre>";exit;
        //$result = json_decode(json_encode($result), true); //converting from stdClass object to array format
        
        //check if the json_decode the result correctly
        if($result == false || isset($result['success'])==false){
            throw new Exception("Request was not correct");
            //throw new Exception($result['errormsg']);
        }
        
        //if there was an error , throw an excepion
        if($result['success'] == false){
            throw new Exception($result['errormsg']);
        }
        //if everything done right then return the result
        return $result['data'];
    }
}
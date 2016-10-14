<?php

/* 
 * MySQL connection credentials created by Kishore Patra on 8th Aug 2016
 */
class db{
    protected $host;
    protected $user;
    protected $pass;
    protected $db;
    
    public function __construct() {
        $this->_host = 'localhost';
        $this->_user = 'root';
        $this->_pass = 'p455w0rd';
        $this->_db   = 'todoapi';
    }
    
    public function connect(){
        $conn = new mysqli($this->_host, $this->_user, $this->_pass, $this->_db);
        if($conn->connect_errno){   //or it can be if(mysqli_connect_errno){
            //echo "<pre>";print_r($conn);echo "</pre>";
            echo $conn->connect_error;exit;
        }else{
            //echo "<pre>";print_r($conn);echo "</pre>";
            return $conn;
        }
    }
}
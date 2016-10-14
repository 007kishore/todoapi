<?php
require_once './database.php';
class TodoItem{
    public $todo_id;
    public $title;
    public $description;
    public $date_due;
    public $is_done;
    
    public function save($username, $userpass){
        
        $db             = new db;
        $conn           = $db->connect();
        //get the user and password hash
        $userhash = sha1("{$username}_{$userpass}");
        
        //check directory present ,if not then create one
        if(is_dir(DATA_PATH."/{$userhash}")==false){
            mkdir(DATA_PATH."/{$userhash}");
        }
        
        //if $todo_id is not set, then we have to create a new todo item
        if(is_null($this->todo_id) || !is_numeric($this->todo_id)){
            $this->todo_id = time();
        }
        
        //get the array version of the todo item
        $todo_item_array = $this->toArray();
        
       // return DATA_PATH."/{$userhash}/{$this->todo_id}.txt";exit;
        //save the serialize version of array into file
        $success = file_put_contents(DATA_PATH."/{$userhash}/{$this->todo_id}.txt", serialize($todo_item_array));
        
        $todocreatesql = "insert into todo_master (`title`, `description`, `date_due`, `is_done`) values ('".$this->title."', '".$this->description."', '".$this->date_due."', $this->is_done)";
        $todocreateres = mysqli_query($conn, $todocreatesql);
        
        
        //if saving failed then throw an exception
        if($success == false){
            throw new Exception("problem in saving in file");
        }
        if(!$todocreateres){
            throw new Exception("problem in saving in db");
        }
        
        //return the array version
        return $todo_item_array;
    }
    
    public function lists(){
        $db             = new db;
        $conn           = $db->connect();
        
        $todolistsql    = "select * from todo_master where 1";
        $todolistres    = mysqli_query($conn, $todolistsql);
        while($todorow  = mysqli_fetch_array($todolistres)){
            $this->todo_id      = $todorow['todo_id'];
            $this->title        = $todorow['title'];
            $this->description  = $todorow['description'];
            $this->date_due     = $todorow['date_due'];
            $this->is_done      = $todorow['is_done'];
            
            $todo_item_list[] = $this->toArray();
            
         }
        
        return $todo_item_list;
        
        
    }
    public function update(){
        $db = new db();
        $conn = $db->connect();
        
        $todoupdatesql  = "update todo_master set title = '".$this->title."', description ='".$this->description."', date_due ='".$this->date_due."' where todo_id = '".$this->todo_id."'";
        $todoupdateres  = mysqli_query($conn, $todoupdatesql);
        if(mysqli_affected_rows($conn)>0){
            return array('message' => 'Record Successfully updated.');
        }else{
            return array('message' => 'Problem occurred during updation');
        }
    }
    public function delete(){
        $db         = new db;
        $conn       = $db->connect();
        
        $tododelsql = "delete from todo_master where todo_id = '".$this->todo_id."'";
        $tododelres = mysqli_query($conn, $tododelsql);
        if($tododelres){
            return array('message' => 'Record Successfully deleted.');
        }else{
            return array('message' => 'Problem occurred during deletion');
        }
    }
    public function toArray(){
        //return an array version of todo item
        return array(
            'todo_id'       => $this->todo_id,
            'title'         => $this->title,
            'description'   => $this->description,
            'date_due'      => $this->date_due,
            'is_done'       => $this->is_done
        );
    }
}
<?php

class Todo{
    private $params;
    public function __construct($params) {
        $this->_params = $params;
        //print_r($this->_params);
    }
    public function createAction(){
        //create new todo item
        $todo               = new TodoItem();
        $todo->title        = $this->_params['title'];
        $todo->description  = $this->_params['description'];
        $todo->date_due     = $this->_params['date_due'];
        $todo->is_done      = '0';

        //pass the username and password to authenticate the user
        $todo->save($this->_params['username'], $this->_params['password']);
        
        //return the todo items in array format
        return $todo->toArray();
    }
    public function readAction(){
        //echo "readAction";
        $todo               = new TodoItem();
        $todo->title        = 'new title';
        $todo->description  = 'new Description';
        $todo->date_due     = '2016-12-12';
        $todo->is_done      = '0';
        return $todo->toArray();
    }
    public function listAction(){
        $todo = new TodoItem();
        return $todo->lists();
    }
    public function updateAction(){
        $todo               = new TodoItem();
        $todo->todo_id      = $this->_params['todo_id'];
        $todo->title        = $this->_params['title'];
        $todo->description  = $this->_params['description'];
        $todo->date_due     = $this->_params['date_due'];
        return $todo->update();
    }
    public function deleteAction(){
        $todo = new TodoItem();
        $todo->todo_id = $this->_params['todo_id'];
        return $todo->delete();
    }
}
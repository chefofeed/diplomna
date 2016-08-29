<?php
require_once 'mysql_model.php';

class Answer extends Mysql_model {
    public function __construct() {
        $this->table = 'answers';
        parent::__construct();
    }
}
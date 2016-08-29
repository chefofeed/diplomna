<?php

require_once 'mysql_model.php';

class Question extends Mysql_model {
    public function __construct() {
        $this->table = 'question';
        parent::__construct();
    }
}
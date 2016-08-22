<?php

require_once 'mysql_model.php';

class Survey extends Mysql_model {
    public function __construct() {
        $this->table = 'survey';
        parent::__construct();
    } 
}

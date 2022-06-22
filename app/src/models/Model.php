<?php


namespace app\models;
use app\core\Database;

class Model
{
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }
}
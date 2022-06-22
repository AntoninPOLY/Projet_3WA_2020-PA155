<?php
// Source : http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/

namespace app\core;

use PDO;

class Database
{
    private $pdo;
    private $error;
    private $stmt;

    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host=' . $_ENV["MYSQL_HOST"] . ';dbname=' . $_ENV["MYSQL_DATABASE"];
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instance
        try{
            $this->pdo = new \PDO($dsn, $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"], $options);
        }
            // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
             var_dump($this->error);
        }
        $this->pdo->exec('SET NAMES UTF8');
    }

    public function query($query) {
        $this->stmt = $this->pdo->prepare($query);
    }

    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function resultset() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount(){
        return $this->stmt->rowCount();
    }

    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }

    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }

    public function beginTransaction(){
        return $this->pdo->beginTransaction();
    }

    public function endTransaction(){
        return $this->pdo->commit();
    }

    public function cancelTransaction(){
        return $this->pdo->rollBack();
    }
}
?>

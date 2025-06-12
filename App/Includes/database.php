<?php
include 'config.php';

class Database
{
    public $pdo;
    public function __construct()
    {
        try {
            $dsn = "mysql:host=" . host . ";dbname=" . dbname . ";port=" . port;
            $this->pdo = new PDO($dsn, user, password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connection Success!";
        } catch (PDOException $e) {
            die("Not connected: " . password . $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->pdo;

    }
}

// $obj = new Database();
// $obj->getConnection();


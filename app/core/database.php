<?php

class Database 
{
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $db_charset = DB_CHARSET;

    private $conn;
    private $stmt;
    private $error;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=' . $this->db_charset;

        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

    public function query($sql) { $this->stmt = $this->conn->prepare($sql); }

    public function execute() { return $this->stmt->execute(); }

    public function results() { return $this->stmt->fetchAll(PDO::FETCH_ASSOC); }
    
    public function result() { $this->execute(); return $this->stmt->fetch(PDO::FETCH_ASSOC); }

    public function bind($param, $value) { $this->stmt->bindValue($param, $value); }

}

?>
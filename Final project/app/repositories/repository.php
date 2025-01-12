<?php

class Repository {

    protected $connection;

    function __construct() {

        require __DIR__ . '/../dbconfig.php';

        try {
            $this->connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo "Connection failed";
          }
    }       
}
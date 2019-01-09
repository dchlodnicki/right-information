<?php

namespace Config {

    use PDO;
    use PDOException;

    class Database {

        private $host = '*****';
        private $username = '*****';
        private $password = '*****';
        private $db_name = '*****';
        public $conn;

        public function getConnection(): PDO
        {

            $this->conn = null;

            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->conn->exec('SET NAMES UTF8');
            }
            catch(PDOException $exception) {
                echo 'Connection error: ' . $exception->getMessage();
            }

            return $this->conn;
        }
    }
}


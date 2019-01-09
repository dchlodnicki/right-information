<?php

namespace Objects {

    class Website {

        private $conn;

        public $name;

        public function __construct($db) {
            $this->conn = $db;
        }

        function read() {

            $query = "SELECT 
                    website AS name
                FROM 
                    person_data 
                WHERE 
                    website != ''";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
    }
}
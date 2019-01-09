<?php

namespace Objects {

    class Person {

        private $conn;

        public $id;
        public $name;
        public $address;
        public $birth_date;
        public $color;
        public $website;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read($id) {

            if($id === 0) {

                $query = 'SELECT
                    person.id AS id,
                    person.name AS name, 
                    person.address AS address,
                    person.birth_date AS birth_date,
                    person_data.color AS color,
                    person_data.website AS website
                FROM 
                    person,
                    person_data
                WHERE
                    person.id = person_data.person_id';
            }
            else {

                $query = 'SELECT
                    person.id AS id,
                    person.name AS name, 
                    person.address AS address,
                    person.birth_date AS birth_date,
                    person_data.color AS color,
                    person_data.website AS website
                FROM 
                    person,
                    person_data
                WHERE
                    person.id = person_data.person_id
                AND
                    person.id = ' .$id;
            }

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        public function update(): bool
        {

            $query = 'UPDATE 
                    person, 
                    person_data 
                SET 
                    person.name = :name, 
                    person.address = :address, 
                    person.birth_date = :birth_date, 
                    person_data.color = :color,
                    person_data.website = :website
                WHERE 
                    person.id = person_data.person_id 
                AND 
                    person.id = :id';

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->birth_date = htmlspecialchars(strip_tags($this->birth_date));
            $this->color = htmlspecialchars(strip_tags($this->color));
            $this->website = htmlspecialchars(strip_tags($this->website));

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':birth_date', $this->birth_date);
            $stmt->bindParam(':color', $this->color);
            $stmt->bindParam(':website', $this->website);

            if($stmt->execute()){
                return true;
            }

            return false;
        }

        public function delete(): bool
        {

            $query = 'DELETE 
                    person, person_data
                FROM 
                    person
                JOIN 
                    person_data ON person_data.person_id = person.id
                WHERE 
                    person.id = :id';

            $stmt = $this->conn->prepare($query);

            $this->id=htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()){
                return true;
            }

            return false;

        }
    }
}
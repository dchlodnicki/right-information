<?php

namespace Model {

    use PDO;
    use PDOException;

    class Model {

        private $host = '*****';
        private $username = '*****';
        private $password = '*****';
        private $db_name = '*****';

        public $pdo;

        public $sort_by;
        public $born_from;
        public $born_to;
        public $with_color;
        public $with_website;
        public $limit;
        public $offset;

        public function __construct() {

            $this->sort_by = 2;
            $this->born_from = 1900;
            $this->born_to = (int)date('Y');
            $this->with_color = 'empty';
            $this->with_website = 'empty';
            $this->limit = 15;
            $this->offset = 0;
        }

        public function getConnection(): ?PDO
        {

            $this->pdo = null;

            try {
                $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->pdo->exec('SET NAMES UTF8');
            }
            catch(PDOException $exception) {
                echo 'Connection error: ' . $exception->getMessage();
            }

            return $this->pdo;
        }

        public function read() {

            $query = 'SELECT 
                        person.id AS id,
                        person.name AS name,
                        person.address AS address,
                        person.birth_date AS birth_date,
                        person_data.color AS color,
                        person_data.website AS website
                    FROM 
                        person, person_data 
                    WHERE 
                        person.id = person_data.person_id 
                    AND
                        person.birth_date > :born_from
                    AND
                        person.birth_date < :born_to
                    AND
                        person_data.color != :with_color
                    AND
                        person_data.website != :with_website
                    ORDER BY 
                        :sort
                    LIMIT 
                        :limit
                    OFFSET
                        :offset';

            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':sort', $this->sort_by, PDO::PARAM_INT);
            $stmt->bindValue(':born_from', $this->born_from.'-00-00 00:00:00');
            $stmt->bindValue(':born_to', $this->born_to.'-12-12 23:59:59');
            $stmt->bindValue(':with_color', $this->with_color);
            $stmt->bindValue(':with_website', $this->with_website);
            $stmt->bindValue(':limit', $this->limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $this->offset, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as $key => $row) {

                $id = $row['id'];

                $person[$id] = new Person();
                $person[$id]->id = $row['id'];
                $person[$id]->name = $row['name'];
                $person[$id]->address = $row['address'];
                $person[$id]->birth_date = $row['birth_date'];
                $person[$id]->color = $row['color'];
                $person[$id]->website = $row['website'];
            }

            if (!empty($person)) {
                return $person;
            }
        }

        public function addPerson($person): void
        {

            /* Adding data to the 'person' table */
            $birth_date = $person['date'].' '.$person['time'].':00';

            $query = 'INSERT INTO 
                    person(
                        name, 
                        address, 
                        birth_date)
                    VALUES (
                        :name,
                        :address,
                        :birth_date)';

            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':name', $person['name']);
            $stmt->bindParam(':address', $person['address']);
            $stmt->bindParam(':birth_date', $birth_date);

            $stmt->execute();

            /* Finding the last record */

            $query = 'SELECT id FROM person ORDER BY id DESC LIMIT 1';

            $stmt = $this->pdo->query($query);

            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach($result as $row) {

                $id = $row['id'];
            }

            /* Adding data to the 'person_data' table */

            $query = 'INSERT INTO 
                    person_data (
                        person_id, 
                        color, 
                        website) 
                    VALUES (
                        :id,
                        :color,
                        :website)';

            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':color', $person['color']);
            $stmt->bindParam(':website', $person['website']);

            $stmt->execute();
        }

        public function deletePerson($id): void
        {

            $query = 'DELETE 
                    person, person_data 
                FROM 
                    person 
                INNER JOIN 
                    person_data 
                WHERE 
                    person.id = person_data.person_id 
                AND 
                    person.id = :id';

            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
        }

        public function getNumPage(): float
        {

            $query = 'SELECT 
                        person.id AS id,
                        person.name AS name,
                        person.address AS address,
                        person.birth_date AS birth_date,
                        person_data.color AS color,
                        person_data.website AS website
                    FROM 
                        person, person_data 
                    WHERE 
                        person.id = person_data.person_id 
                    AND
                        person.birth_date > :born_from
                    AND
                        person.birth_date < :born_to
                    AND
                        person_data.color != :with_color
                    AND
                        person_data.website != :with_website';

            $stmt = $this->pdo->prepare($query);

            $stmt->bindValue(':born_from', $this->born_from.'-00-00 00:00:00');
            $stmt->bindValue(':born_to', $this->born_to.'-12-12 23:59:59');
            $stmt->bindValue(':with_color', $this->with_color);
            $stmt->bindValue(':with_website', $this->with_website);
            $stmt->execute();

            $num_rows = $stmt->rowCount();

            return ceil($num_rows / 15);
        }

        public function setNumberPage($num): void
        {

            $this->offset = ($num - 1) * 15;
        }

        public function setSortBy($value): void
        {

            $this->sort_by = $value;
        }

        public function setBornFrom($value): void
        {

            $this->born_from = $value;
        }

        public function setBornTo($value): void
        {

            $this->born_to = $value;
        }

        public function setWithColor($value): void
        {

            $this->with_color = $value === 'on' ? '' : 'empty';
        }

        public function setWithWebsite($value): void
        {

            $this->with_website = $value === 'on' ? '' : 'empty';
        }
    }
}


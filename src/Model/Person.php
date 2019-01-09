<?php

namespace Model {

    class Person {

        public $id;
        public $name;
        public $address;
        public $birth_date;
        public $color;
        public $website;

        public function __construct() {

            $this->id = null;
            $this->name = null;
            $this->address = null;
            $this->birth_date = null;
            $this->color = null;
            $this->website = null;
        }
    }
}



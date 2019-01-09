<?php

namespace View {

    class View {

        public $data;
        public $http_data;
        public $num_page;

        public function renderHTML($name): void
        {

            require $_SERVER['DOCUMENT_ROOT'].'/src/template/'.$name.'.php';
        }
    }
}


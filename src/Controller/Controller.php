<?php

namespace Controller {

    class Controller {

        public function redirect($url): void
        {

            header('Location: ' . $url);
        }
    }
}


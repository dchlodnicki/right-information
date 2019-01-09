<?php

namespace Controller {

    use Model\Model;
    use View\View;

    class PersonController extends Controller {

        public function index() {

            $number_page = $_GET['number_page'] ?? 1;
            $sort_by = $_GET['sort_by'] ?? 2;
            $born_from = $_GET['born_from'] ?? 1900;
            $born_to = $_GET['born_to'] ?? (int)date('Y');
            $with_color = $_GET['with_color'] ?? 'off';
            $with_website = $_GET['with_website'] ?? 'off';

            $number_page = htmlspecialchars(strip_tags($number_page));
            $sort_by = htmlspecialchars(strip_tags($sort_by));
            $born_from = htmlspecialchars(strip_tags($born_from));
            $born_to = htmlspecialchars(strip_tags($born_to));
            $with_color = htmlspecialchars(strip_tags($with_color));
            $with_website = htmlspecialchars(strip_tags($with_website));

            $http_data = array(
                'sort_by' => $sort_by,
                'born_from' => $born_from,
                'born_to' => $born_to,
                'with_color' => $with_color,
                'with_website' => $with_website
            );

            $http_data = http_build_query($http_data);

            $model = new Model();
            $model->getConnection();
            $model->setNumberPage($number_page);
            $model->setSortBy($sort_by);
            $model->setBornFrom($born_from);
            $model->setBornTo($born_to);
            $model->setWithColor($with_color);
            $model->setWithWebsite($with_website);
            $result = $model->read();
            $num_page = $model->getNumPage();

            $view = new View();
            $view->data = $result;
            $view->http_data = $http_data;
            $view->num_page = $num_page;
            $view->renderHTML('list');
        }
    }
}


<?php
session_start();
class Controller_Main extends Controller
{
    const TASKS_PER_PAGE = 3;

    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
        $this->api = new Api();
        $this->tasks = $this->model->get_tasks();
    }

    function action_index()
    {

        if (!empty($_GET['sortType']) && $_GET['sortType'] !== 'default')
        {
            $sort_type = $_GET['sortType'];
            $sort_direction = $_GET['sortDirection'];
            $tasks = $this->sort($this->tasks, $sort_type, $sort_direction);
        } else {
            $tasks = $this->tasks;
        }

        $data = $this->prepare_data($tasks);
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    private function prepare_data($data)
    {
        //получаем номер страницы и значение для лимита
        $cur_page = 1;

        if (isset($_GET['page']) && $_GET['page'] > 0)
        {
            $cur_page = $_GET['page'];
        }

        $start = ($cur_page - 1) * self::TASKS_PER_PAGE;
        $num_pages = ceil(count($data) / self::TASKS_PER_PAGE);

        // переменная, которую будем использовать для вывода номеров страниц
        $page = 0;

        return [
            'tasks' => array_slice($data, $start, self::TASKS_PER_PAGE),
            'TASKS_PER_PAGE' => self::TASKS_PER_PAGE,
            'pages' => $num_pages,
            'cur_page' => $cur_page,
            'page' => $page
        ];
    }

    private function sort($array, $sort_type, $sort_direction)
    {

        switch ($sort_direction) {
            case 'ascending':
                uasort($array, function ($a, $b) use($sort_type) {
                    return strnatcmp($a[$sort_type], $b[$sort_type]);
                });
                break;
            case 'descending':
                uasort($array, function ($a, $b) use($sort_type) {
                    return strnatcmp($b[$sort_type], $a[$sort_type]);
                });
                break;
        }

        return $array;
    }
}

<?php

class Controller_Add extends Controller
{
    function __construct()
    {
        $this->api = new Api();
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate('add_view.php', 'template_view.php');
    }

    function action_task()
    {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = esc($value);
        }

        $task = $_POST;
        $required = ['user', 'email', 'message'];
        $errors = [];

        foreach ($task as $key => $value) {
            $task[$key] = esc(trim($value));
        }

        // Проверка заполненности полей
        foreach ($required as $key) {
            if (empty($task[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        // Валидация
        if (!empty($task['email'])) {
            if (!filter_var($task['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Пожалуйста, введите валидный email';
            }
        }

        if (!count($errors)) {
            $this->api->add_task($task);
        }

        $this->view->generate('add_view.php', 'template_view.php', $errors);
    }

}

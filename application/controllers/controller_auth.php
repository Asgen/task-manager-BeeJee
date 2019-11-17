<?php
session_start();
class Controller_Auth extends Controller
{
    function __construct()
    {
        $this->api = new Api();
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate('auth_view.php', 'template_view.php');
    }

    function action_login()
    {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = esc($value);
        }

        $user = $_POST;
        $required = ['login', 'password'];
        $errors = [];

        foreach ($user as $key => $value) {
            $user[$key] = esc(trim($value));
        }

        // Проверка заполненности полей
        foreach ($required as $key) {
            if (empty($user[$key])) {
                $errors[$key] = 'Это поле надо заполнить';
            }
        }

        // Проверяем данные в БД
        if (!count($errors)) {
            $found_user = $this->api->check_user($user['login']);
        }
        if (isset($found_user)) {

            if (strcmp($found_user['password'], $user['password']) !== 0) {
                $errors['fired'] = 'Неверные данные для входа';
            } else {
                $_SESSION['user'] = $user;
            }
        } else {
            $errors['fired'] = 'Неверные данные для входа';
        }

        if (!count($errors)) {
            header("Location: /");
        } else {
            $this->view->generate('auth_view.php', 'template_view.php', $errors);
        }
    }

    function action_logout() {
        $_SESSION['user'] = null;
        header("Location: /");
    }

}

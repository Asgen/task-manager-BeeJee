<?php
session_start();
class Controller_Edit extends Controller
{
    function __construct()
    {
        $this->api = new Api();
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate('main_view.php', 'template_view.php');
    }

    function action_status()
    {
        if (isset($_SESSION['user'])) {
            $id = $_GET['id'];
            $status = $_GET['status'];
            $this->api->edit_task($id, $status);
        } else {
            header("Location: /");
        }
    }

    function action_task()
    {
        if (isset($_SESSION['user'])) {
            $id = esc($_POST['taskId']);
            $new_text = esc($_POST['editedMessage']);
            $this->api->edit_task($id, $new_text);
        } else {
            $this->view->generate('auth_view.php', 'template_view.php');
        }
    }
}

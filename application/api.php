<?php
class Api
{
    public function check_user($login) {
        $connection_resourse = connect_db();

        $sql = "SELECT * FROM users WHERE login = '$login'";
        $res = mysqli_query($connection_resourse, $sql);

        // Если запрос неудачен, то выводим ошибку
        if (!$res) {
            print("Ошибка в запросе к БД. Запрос $sql " . mysqli_error($connection_resourse));
            die();
        }

        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

        return $user;
    }

    public function get_tasks()
    {
        $connection_resourse = connect_db();

        // выполняем запрос и получаем данные для вывода
        $sql  = "SELECT * FROM tasks";
        $stmt = mysqli_prepare($connection_resourse, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $tasks = parse_result($result, $connection_resourse, $sql);

        return $tasks;
    }

    public function add_task($task)
    {
        $connection_resourse = connect_db();

        $sql = "INSERT INTO tasks SET name = ?, email = ?, content = ?";

        // Подготавливаем шаблон запроса
        $stmt = mysqli_prepare($connection_resourse, $sql);

        // Привязываем к маркеру значение переменных.
        $name = $task['user'];
        $email = $task['email'];
        $content = $task['message'];

        mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $content);

        // Выполняем подготовленный запрос.
        $result = mysqli_stmt_execute($stmt);

        // Если запрос неудачен, то выводим ошибку
        if (!$result) {
            print("Ошибка записи в БД. Запрос $sql " . mysqli_error($connection_resourse));
            die();
        }

        header("Location: /?success");
        die();
    }

    public function edit_task($id, $option)
    {
        $connection_resourse = connect_db();
        switch ($option === '0' || $option === '1') {
            case true:
                $sql = "UPDATE tasks
                    SET status = 1 - $option WHERE id = $id";
                break;
            case false:
                $sql = "UPDATE tasks
                    SET content = '$option',
                        edited = 1
                    WHERE id = $id";
                break;

            default:
                print("Что-то пошло не так.");
                die();
                break;
        }

        $result = mysqli_query($connection_resourse, $sql);
        if (!$result) {
            print("Ошибка в запросе к БД. Запрос $sql " . mysqli_error($connection_resourse));
            die();
        }

        $page = isset($_GET['page']) ? '?page=' . $_GET['page'] : '';

        header("Location: /" . $page);
        die();

    }
}

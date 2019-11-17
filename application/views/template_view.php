  <!DOCTYPE html>
  <html lang="ru">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Task Manager</title>
      <base href="http://task-manager-beejee/">
      <!-- Bootstrap -->
      <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" crossorigin="anonymous">
      <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
      <header class="d-flex justify-content-between p-3 align-items-center mb-4 bg-info text-right">
        <a class="logo" href="/">
            <h1 class="text-white">Менеджер задач</h1>
        </a>
        <a href="/add" class="btn btn-warning mr-4 ml-4">Создать задачу</a>
        <?php if (isset($_SESSION['user'])) : ?>
            <a href="/auth/logout" class="btn btn-light">Выйти</a>
        <?php else : ?>
            <a href="/auth" class="btn btn-light">Авторизация</a>
        <? endif ?>
      </header>

      <main>
        <div class="container">
          <?php include 'application/views/'.$content_view; ?>
        </div>
      </main>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
      <script>
        if(document.querySelector('#modal')) {
            $('#modal').modal('show');
            var new_url = "<?= $_SERVER["HTTP_HOST"] ?>".substring(0, "<?= $_SERVER["HTTP_HOST"] ?>".indexOf('?'));
            window.history.pushState("object or string", "Title", new_url + '/');
        }

      </script>
      <script src="js/main.js"></script>
    </body>
  </html>

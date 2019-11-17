<?php if (isset($_GET['success'])) : ?>
        <!-- Modal -->
        <div class="modal" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Поздравляю!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Ваша задача успешно добавлена.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
              </div>
            </div>
          </div>
        </div>
<?php endif; ?>
<div class="row">
  <div class="radio-set col-md-3 py-3 mx-3 mb-4 border border-secondary rounded-sm">
    <p>Сортировать по:</p>
    <form action="/" method="GET" id="sortForm">

      <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
        <label class="btn btn-secondary <?= !empty($_GET['sortType']) && $_GET['sortType'] === 'name' ? 'active' : '' ?>">
          <input type="radio" value="name" name="sortType" id="option1" <?= !empty($_GET['sortType']) && $_GET['sortType'] === 'name' ? 'checked' : '' ?> autocomplete="off" > Имя
        </label>
        <label class="btn btn-secondary <?= !empty($_GET['sortType']) && $_GET['sortType'] === 'email' ? 'active' : '' ?>">
          <input type="radio" value="email" name="sortType" id="option2" <?= !empty($_GET['sortType']) && $_GET['sortType'] === 'email' ? 'checked' : '' ?> autocomplete="off"> email
        </label>
        <label class="btn btn-secondary <?= !empty($_GET['sortType']) && $_GET['sortType'] === 'status' ? 'active' : '' ?>">
          <input type="radio" value="status" name="sortType" id="option3" <?= !empty($_GET['sortType']) && $_GET['sortType'] === 'status' ? 'checked' : '' ?> autocomplete="off"> статус
        </label>
        <label class="btn btn-secondary <?= empty($_GET['sortType']) || $_GET['sortType'] === 'default' ? 'active' : '' ?>">
          <input type="radio" value="default" id="option4" name="sortType" <?= empty($_GET['sortType']) || $_GET['sortType'] === 'default' ? 'checked' : '' ?> autocomplete="off" > Id
        </label>
      </div>
      <div class="input-group mb-4">
        <select class="custom-select" id="inputGroupSelect01" name="sortDirection">
          <option <?= empty($_GET['sortType']) || $_GET['sortType'] === 'ascending' ? 'selected' : '' ?> value="ascending">По возрастанию</option>
          <option <?= !empty($_GET['sortDirection']) && $_GET['sortDirection'] === 'descending' ? 'selected' : '' ?> value="descending">По убыванию</option>
        </select>
      </div>
      <button form="sortForm" type="submit" class="btn btn-sm btn-primary">Применить</button>
    </form>
  </div>
  <div class="col-lg-9">
    <ul class="list row mb-4">
      <?php if (isset($data['tasks'])): ?>
        <?php foreach ($data['tasks'] as $key => $task) : ?>
          <li class="list__item col-md">
            <div class="card">
              <div class="card-body">
                <?php if ($task['edited'] == 1) : ?>
                    <span class="badge badge-pill badge-warning">Отредактировано</span>
                    <span class="mb-3 badge badge-pill badge-warning">Администратором</span>
                <? endif ?>
                <h5 class="card-title"><?= esc($task['name']) ?></h5>
                <p class="card-email"><?= esc($task['email']) ?></p>
                <p class="card-text"><?= esc($task['content']) ?></p>
                <div class="custom-control custom-checkbox">
                  <input <?= isset($_SESSION['user']) ? '' : 'disabled' ?> type="checkbox" class="custom-control-input" id="<?= $task['id'] ?>" <?= $task['status'] === 1 ? 'checked' : '' ?>>
                  <label class="custom-control-label" for="<?= $task['id'] ?>">Выполнено</label>
                </div>
              </div>
              <?php if (isset($_SESSION['user'])) : ?>
                <!-- Button trigger modal -->
                <button type="button" class="edit-button btn btn-primary" data-toggle="modal" data-target="#modal<?= $key ?>">
                  Редактировать
                </button>

                <!-- Modal -->
                <div class="modal fade" id="modal<?= $key ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <form method="POST" action="edit/task" id="form<?= $key ?>" class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Изменение текста задачи</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <textarea class="form-control" id="message<?= $key ?>" name="editedMessage" rows="3"><?= esc($task['content']) ?></textarea>
                      </div>
                      <div class="modal-footer">
                        <input name="taskId" value="<?= $task['id'] ?>" type="text" hidden>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button form="form<?= $key ?>" value="Submit" type="submit" id="<?= $key ?>" class="save-button btn btn-primary">Сохранить</button>
                      </div>
                    </form>
                  </div>
                </div>
              <? endif ?>
            </div>
          </li>
        <?php endforeach ?>
      <?php else : ?>
        <p>Задачи отсутствуют. Можете создать парочку;)</p>
      <?php endif ?>
    </ul>
  </div>
</div>
<?php if (isset($data['tasks']) && $data['pages'] > 1): ?>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item"><a class="page-link" href="?page=<?= $data['cur_page'] - 1 ?>">Назад</a></li>
    <?php for ($i = ++$data['page']; $i <= $data['pages']; $i++) : ?>
          <li class="page-item <?= $data['cur_page'] == $i ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?><?php if(isset($_GET)) : ?><?php foreach ($_GET as $key => $value): ?><?php if ($key === 'page') {continue;} ?>&<?= $key . '=' . $value ?><?php endforeach ?><? endif ?>"><?= $i ?></a>
          </li>
    <?php endfor ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $data['cur_page'] + 1 > $data['pages'] ? $data['pages'] : $data['cur_page'] + 1 ?>">Вперед</a></li>
      </ul>
    </nav>
<?php endif ?>

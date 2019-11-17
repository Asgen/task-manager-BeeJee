<h2 class="mb-4">Форма создания новой задачи</h2>
<form action="/add/task/" method="POST">
  <div class="form-group">
    <label for="userName">Имя</label>
    <input id="userName" class="form-control" type="text" name="user" placeholder="Введите имя" value="<?= isset($_POST['user']) ? esc($_POST['user']) : '' ?>">
    <?php if (isset($data['user'])) : ?>
        <small class="form-text text-danger"><?= $data['user'] ?></small>
    <?php endif; ?>
  </div>
  <div class="form-group">
    <label for="userEmail">Email</label>
    <input id="userEmail" class="form-control" type="text" name="email" placeholder="Введите email" value="<?= isset($_POST['email']) ? esc($_POST['email']) : '' ?>">
    <?php if (isset($data['email'])) : ?>
        <small class="form-text text-danger"><?= $data['email'] ?></small>
    <?php endif; ?>
  </div>
  <div class="form-group">
    <label for="userTask">Задача</label>
    <textarea class="form-control" name="message" id="userTask" rows="3"><?= isset($_POST['message']) ? esc($_POST['message']) : '' ?></textarea>
    <?php if (isset($data['message'])) : ?>
        <small class="form-text text-danger"><?= $data['message'] ?></small>
    <?php endif; ?>
  </div>
  <button type="submit" class="btn btn-warning">Создать</button>
</form>

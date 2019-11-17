<h2 class="mb-4">Форма авторизации</h2>
<?php if(isset($data['fired'])) : ?>
    <small class="form-text text-danger mb-3"><?= $data['fired'] ?></small>
<? endif ?>
<form action="/auth/login/" method="POST">
  <div class="form-group">
    <label for="login">Логин</label>
    <input id="login" class="form-control" type="text" name="login" placeholder="Введите логин" value="<?= isset($_POST['login']) ? esc($_POST['login']) : '' ?>">
    <?php if (isset($data['login'])) : ?>
        <small class="form-text text-danger"><?= $data['login'] ?></small>
    <?php endif; ?>
  </div>
  <div class="form-group">
    <label for="password">Пароль</label>
    <input id="password" class="form-control" type="text" name="password" placeholder="Введите пароль" autocomplete="off">
    <?php if (isset($data['password'])) : ?>
        <small class="form-text text-danger"><?= $data['password'] ?></small>
    <?php endif; ?>
  </div>
  <button type="submit" class="btn btn-warning">Войти</button>
</form>

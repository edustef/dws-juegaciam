<?php

/**
 * @var $model \app\models\LoginUser
 */

use app\components\FormField;

?>

<div class="container">
  <h1>Login page</h1>
  <form action="" method="POST">
    <?= FormField::render($model, 'username', 'Username') ?>
    <?= FormField::render($model, 'password', 'Password', FormField::TYPE_PASSWORD) ?>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
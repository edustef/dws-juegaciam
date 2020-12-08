<?php

/**
 * @var $model \app\models\RegisterUser
 */

use app\views\components\FormField;

?>

<div class="container">
  <h1>Sign Up</h1>
  <form action="" method="POST">
    <?= FormField::render($model, 'username', 'Username') ?>
    <?= FormField::render($model, 'password', 'Password', FormField::TYPE_PASSWORD) ?>
    <?= FormField::render($model, 'passwordConfirm', 'Password Confirm', FormField::TYPE_PASSWORD) ?>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<?php

/**
 * @var app\models\RegisterUser $model
 */

use app\views\components\forms\Form;
use app\views\components\forms\FormField;

?>

<div class="container max-w-sm mx-auto flex-1 flex flex-col items-center justify-center px-2">
  <div class="bg-white px-6 py-8 rounded shadow-md text-black w-full">
    <h1 class="mb-8 text-3xl text-center">Sign up</h1>
    <?=
      new Form([
        'fields' => [
          new FormField($model, 'username'),
          new FormField($model, 'password'),
          new FormField($model, 'passwordConfirm'),
        ]
      ], Form::METHOD_POST)
    ?>
    <div class="text-grey-dark mt-6">
      Already have an account?
      <a class="no-underline border-b border-blue text-blue" href="/login">
        Log in
      </a>.
    </div>
  </div>
</div>
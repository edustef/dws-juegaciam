<?php

/**
 * Variables passed from the Controller
 * @var app\models\LoginUser $model
 */

use app\views\components\forms\FormField;
use app\views\components\forms\Form;

?>

<div class="grid place-items-center h-full">
  <div class="bg-white mx-2 max-w-sm px-6 py-8 rounded shadow-md text-black w-full">
    <h1 class="mb-8 text-3xl text-center">Login</h1>
    <?=
      new Form([
        new FormField($model, 'username'),
        new FormField($model, 'password', FormField::TYPE_PASSWORD),
        '<button class="p-3 text-white font-semibold bg-green-500 hover:bg-green-600 rounded w-full">Log in</button>'
      ], Form::METHOD_POST)
    ?>
>
  </div>
</div>
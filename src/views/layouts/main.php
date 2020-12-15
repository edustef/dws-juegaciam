<?php

use app\views\components\Flash;
use edustef\mvcFrame\Application;

$app = Application::$app;
$successFlash = $app->session->getFlashSession('success');
$errorFlash = $app->session->getFlashSession('error');

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Juegaciam</title>
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex flex-col h-screen">
  <header class="w-full bg-gray-800 p-4 flex justify-between items-center">
    <nav class="flex items-center">
      <div><a href="/" class="text-white font-bold text-lg">Juegaciam</a></div>
      <div class="text-white text-xs hidden sm:block ml-2">
        <a href="#" class="bg-gray-900 hover:bg-gray-700 p-2 rounded cursor-pointer">Cargar Partida</a>
      </div>
    </nav>
  </header>

  <main class="flex w-full flex-grow">
    <aside class="w-80 bg-gray shadow-md w-fulll h-full hidden sm:block">
      <div class="flex flex-col justify-between h-full p-4 bg-gray-800">
        <div class="text-sm">
          <div class="bg-gray-900 text-white p-2 rounded mt-2 cursor-pointer hover:bg-gray-700 hover:text-blue-300">Backlog</div>
          <div class="bg-gray-900 text-white p-2 rounded mt-2 cursor-pointer hover:bg-gray-700 hover:text-blue-300">Repository</div>
        </div>

        <?php if ($app->isGuest()) : ?>
          <a href="/login" class="p-3 text-white bg-green-500 hover:bg-green-600 rounded rounded w-full flex justify-between items-center">
            <span class="font-semibold">Login</span>
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
          </a>
        <?php else : ?>
          <a href="/logout" class="p-3 text-white bg-red-500 hover:bg-red-600 rounded w-full flex justify-between items-center">
            <span class="font-semibold">Logout</span>
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
          </a>
        <?php endif ?>
      </div>
    </aside>

    <section class="w-full p-4">
      <?php
      if ($successFlash) {
        echo new Flash($successFlash, 'green');
      }

      if ($errorFlash) {
        echo new Flash($errorFlash, 'red');
      }
      ?>
      {{content}}
    </section>
  </main>
</body>

</html>
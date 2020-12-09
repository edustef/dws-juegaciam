<?php

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
  <link rel="stylesheet" href="css/style.css">
</head>

<nav class="">

</nav>
<main class="mt-4 mx-auto container">
  <?php if ($successFlash) : ?>
    <div class="p-4 bg-green-200 font-semibold rounded-md">
      <?php echo $successFlash ?>
    </div>
  <?php endif; ?>
  <?php if ($errorFlash) : ?>
    <div class="p-4 bg-red-200 font-semibold rounded-md">
      <?php echo $errorFlash ?>
    </div>
  <?php endif; ?>
  {{content}}
</main>
</body>

</html>
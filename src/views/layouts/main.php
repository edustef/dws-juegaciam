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
  <title>PHP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Juegaciam</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php if ($app->isGuest()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="/login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/signup">Sign Up</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="/Play">Play</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/logout">Logout</a>
            </li>
          <?php endif ?>
        </ul>
      </div>
    </div>
  </nav>
  <main>
    <?php if ($successFlash) : ?>
      <div class="container">
        <div class="alert alert-success">
          <?php echo $successFlash ?>
        </div>
      </div>
    <?php endif; ?>
    <?php if ($errorFlash) : ?>
      <div class="container">
        <div class="alert alert-danger">
          <?php echo $errorFlash ?>
        </div>
      </div>
    <?php endif; ?>
    {{content}}
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>
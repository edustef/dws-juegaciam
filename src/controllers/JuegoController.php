<?php

namespace app\controllers;

use edustef\mvcFrame\Application;
use edustef\mvcFrame\Controller;
use edustef\mvcFrame\middlewares\AuthMiddleware;
use edustef\mvcFrame\Request;
use edustef\mvcFrame\Response;

class JuegoController extends Controller
{

  public function juegaciam(Request $request, Response $response)
  {
    if (!Application::$app->isGuest()) {

      return $this->render('juegaciam');
    } else {
      Application::$app->session->setFlashSession('error', 'You tried to access a page without permission. Please login!');
      $response->redirect('/login');
    }
  }
}

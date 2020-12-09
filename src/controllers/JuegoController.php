<?php

namespace app\controllers;

use edustef\mvcFrame\Application;
use edustef\mvcFrame\Controller;
use edustef\mvcFrame\Request;
use edustef\mvcFrame\Response;

class JuegoController extends Controller
{

  public function juegaciam(Request $request, Response $response)
  {
    Application::$app->view->layout = 'juegaciamLayout';
    if (Application::$app->isGuest()) {
      Application::$app->session->setFlashSession('error', 'You tried to access a page without permission. Please login!');
      $response->redirect('/login');
    }

    if ($request->isAjax()) {
      echo json_encode($this->resolveAjax($request->getBody()));
    }
    Application::$app->session->setFlashSession('success', 'Logged in successfully');
    return $this->render('juegaciam');
  }

  private function resolveAjax(array $body): array
  {
    return [];
  }
}

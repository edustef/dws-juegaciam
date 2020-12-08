<?php

namespace app\controllers;

use edustef\mvcFrame\Application;
use edustef\mvcFrame\Controller;
use edustef\mvcFrame\Request;
use edustef\mvcFrame\Response;
use edustef\mvcFrame\middlewares\AuthMiddleware;
use app\models\RegisterUser;
use app\models\LoginUser;

class UserController extends Controller
{


  public function login(Request $request, Response $response)
  {
    $user = new LoginUser();
    if ($request->isPost()) {
      $user->loadData($request->getBody());

      if ($user->validate() && $user->login()) {
        Application::$app->session->setFlashSession('success', 'Welcome back!');
        $response->redirect('/');
      }
    }

    return $this->render('login', [
      'model' => $user
    ]);
  }

  public function signup(Request $request, Response $response)
  {
    $user = new RegisterUser();
    if ($request->isPost()) {
      $user->loadData($request->getBody());

      if ($user->validate() && $user->save()) {
        Application::$app->session->setFlashSession('success', 'Thanks for registering!');
        $response->redirect('/');
      }
    }

    return $this->render('signup', [
      'model' => $user
    ]);
  }

  public function logout(Request $request, Response $response)
  {
    Application::$app->logout();
    Application::$app->session->setFlashSession('success', 'You have logged out!');
    $response->redirect('/');
  }
}

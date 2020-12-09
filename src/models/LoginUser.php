<?php

namespace app\models;

use edustef\mvcFrame\Application;

class LoginUser extends UserModel
{
  public function login()
  {
    $user = self::findOne(['username' => $this->username]);
    if (!$user) {
      $this->addErrorMessage('username', 'User with this username does not exist');
      return false;
    }
    if (!password_verify($this->password, $user->password)) {
      $this->addErrorMessage('password', 'Password incorrect!');
      return false;
    }

    return Application::$app->login($user);
  }

  public function save()
  {
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    return parent::save();
  }
}

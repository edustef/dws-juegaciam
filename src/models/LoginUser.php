<?php

namespace app\models;

use edustef\mvcFrame\Application;

class LoginUser extends UserModel
{
  public function login()
  {
    $user = self::findOne(['username' => $this->username]);
    if (!$user) {
      $this->addErrorMessage('username', 'User does not exist with this email address');
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

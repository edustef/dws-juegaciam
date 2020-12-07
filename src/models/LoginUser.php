<?php

namespace app\models;

use edustef\mvcFrame\DatabaseModel;
use edustef\mvcFrame\Application;

class LoginUser extends UserModel
{
  public function rules(): array
  {
    return [
      'username' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4]],
      'password' => [self::RULE_REQUIRED]
    ];
  }

  public function attributes(): array
  {
    return ['username' => 'Username', 'password' => 'Password'];
  }

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

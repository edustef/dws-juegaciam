<?php

namespace app\models;

use edustef\mvcFrame\Application;
use edustef\mvcFrame\DatabaseModel;

abstract class UserModel extends DatabaseModel
{
  public string $username = '';
  public string $password = '';

  public static function tableName(): string
  {
    return 'Usuario';
  }

  public function primaryKey(): string
  {
    return 'id';
  }
}
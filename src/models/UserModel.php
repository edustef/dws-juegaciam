<?php

namespace app\models;

use edustef\mvcFrame\DatabaseModel;

class UserModel extends DatabaseModel
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

  public function rules(): array
  {
    return [
      'username' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4]],
      'password' => [self::RULE_REQUIRED]
    ];
  }

  public function attributes(): array
  {
    return [
      'username' => ['isSaved' => true, 'label' => 'Username'],
      'password' => ['isSaved' => true, 'label' => 'Password']
    ];
  }
}

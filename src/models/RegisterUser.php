<?php

namespace app\models;

class RegisterUser extends UserModel
{
  public string $passwordConfirm = '';

  public function rules(): array
  {
    return [
      'username' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => parent::class]],
      'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
      'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
    ];
  }

  public function attributes(): array
  {
    return ['username' => 'username', 'password' => 'Password', 'passwordConfirm' => 'Password Confirm'];
  }

  public function save()
  {
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    return parent::save();
  }
}

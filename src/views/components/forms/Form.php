<?php

namespace app\views\components\forms;

use edustef\mvcFrame\Component;

class Form extends Component
{
  public const METHOD_POST = 'POST';
  public const METHOD_GET = 'GET';
  private array $children;

  public function __construct(array $children, string $method = self::METHOD_GET)
  {
    $this->children = $children;
    $this->method = $method;
  }
  public function render(): string
  {
    return '
      <form action="" method="POST">
        ' . implode('', $this->children['fields']) . '
        <button type="submit" class="w-full text-center py-3 rounded bg-green text-white hover:bg-green-dark focus:outline-none my-1">Create Account</button>

        <div class="text-center text-sm text-grey-dark mt-4">
          By signing up, you agree to the
          <a class="no-underline border-b border-grey-dark text-grey-dark" href="#">
            Terms of Service
          </a> and
          <a class="no-underline border-b border-grey-dark text-grey-dark" href="#">
            Privacy Policy
          </a>
        </div>
      </form>
    ';
  }
}

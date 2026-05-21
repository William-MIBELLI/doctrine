<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
  private array $errors;

  public function __construct(array $errors)
  {
    parent::__construct("Input validation failed", 400);
    $this->errors = $errors;
  }

  public function getErrors(): array
  {
    return $this->errors;
  }
}
<?php

namespace App\Validation;

use App\Exceptions\ValidationException;
use Rakit\Validation\Validator;

abstract class AbstractValidation
{
  abstract protected static function getRules(): array;

  protected static function getAvailabilitiesRules(): array
  {
    return [
      'availabilities' => 'array',
      'availabilities.*.dayOfWeek' => 'required|integer|between:1,7',
      'availabilities.*.openTime' => 'required|date:H:i',
      'availabilities.*.closeTime' => 'required|date:H:i'
    ];
  }

  public static function validateInput(array $payload)
  {
    $validator = new Validator();

    $validation = $validator->make($payload, static::getRules());

    $validation->validate();

    if ($validation->fails()) {
      $errors = $validation->errors()->firstOfAll();

      throw new ValidationException($errors);
    }
  }
}
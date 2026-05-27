<?php

namespace App\Validation;

use App\Exceptions\ValidationException;
use Rakit\Validation\Validator;

class InvestigatorValidation
{
  public static function validateInput(array $payload)
  {
    $validator = new Validator();

    $validation = $validator->make($payload, [
      'code' => 'required',
      'firstname' => 'required',
      'lastname' => 'required',
      'address' => 'required',
      'postalCode' => 'required|digits:5',
      'city' => 'required',
      'country' => 'required',
      'phone' => 'required|numeric',
      'lat' => 'required|numeric|min:-90|max:90',
      'lng' => 'required|numeric|min:-180|max:180',
    ]);

    $validation->validate();

    if ($validation->fails()) {
      $errors = $validation->errors()->firstOfAll();

      throw new ValidationException($errors);
    }
  }
}
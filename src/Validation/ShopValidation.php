<?php

namespace App\Validation;

use App\DTO\SaveShopDTO;
use App\Exceptions\ValidationException;
use Exception;
use InvalidArgumentException;
use Rakit\Validation\Validator;

class ShopValidation
{
  public static function validateInput(array $payload)
  {
    $validator = new Validator();

    $validation = $validator->make($payload, [
      'placeName' => 'required',
      'placeCode' => 'required',
      'address' => 'required',
      'postalCode' => 'required|digits:5',
      'city' => 'required',
      'country' => 'required',
      'phone' => 'nullable|numeric',
      'visitCode' => 'required',
      'visitName' => 'required',
      'startDate' => 'nullable',
      'endDate' => 'nullable',
      'type' => 'required',
      'cost' => 'required|numeric',
      'lat' => 'required|numeric|min:-90|max:90',
      'lng' => 'required|numeric|min:-180|max:180',
      'canBeLunchBreak' => 'required|boolean',
      'canBeMorning' => 'required|boolean',
      'canBeAfternoon' => 'required|boolean'
    ]);
    $validation->validate();

    if ($validation->fails()) {
      $errors = $validation->errors()->firstOfAll();

      throw new ValidationException($errors);
    }
  }
}

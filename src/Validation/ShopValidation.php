<?php

namespace App\Validation;

class ShopValidation extends AbstractValidation
{
  protected static function getRules(): array
  {
    return 
      [
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
        'canBeAfternoon' => 'required|boolean',
        'availabilities' => 'array',
        ...self::getAvailabilitiesRules()
      ]
      
    ;
  }

}

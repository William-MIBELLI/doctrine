<?php

namespace App\Validation;

class InvestigatorValidation extends AbstractValidation
{

  protected static function getRules(): array
  {
    return
      [
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
        ...self::getAvailabilitiesRules()
      ];
  }

}
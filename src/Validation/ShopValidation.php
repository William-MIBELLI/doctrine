<?php

namespace App\Validation;

use App\DTO\SaveShopDTO;
use InvalidArgumentException;

class ShopValidation
{
  public static function validateInputAndGetDTO()
  {
    $payload = json_decode(file_get_contents("php://input"), true) ?? $_POST;

    try {

      return new SaveShopDTO(...$payload);
      
    } catch (InvalidArgumentException $e) {

      header('HTTP/1.1 400 Bad Request');
      header('Content-Type: application/json');
      echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
      ]);

      exit();
    }
  }

}

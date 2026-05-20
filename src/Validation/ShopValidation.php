<?php

namespace App\Validation;

use App\DTO\CreateShopDTO;
use InvalidArgumentException;

class ShopValidation
{
  public static function validateCreate()
  {
    $payload = json_decode(file_get_contents("php://input"), true) ?? $_POST;

    try {

      return new CreateShopDTO(...$payload);
      
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

  public static function validateUpdate() {}
}

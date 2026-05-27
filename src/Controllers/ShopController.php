<?php

namespace App\Controllers;

use App\DTO\SaveShopDTO;
use App\DTO\ShopDTO;
use App\Services\ShopService;
use App\Validation\ShopValidation;
use Exception;
use Throwable;

class ShopController extends AbstractController
{
  private ShopService $shopService;

  public function __construct(ShopService $service)
  {
    $this->shopService = $service;
  }

  public function list()
  {
    try {
      $shopsDTO = $this->shopService->getAllShops();
      $this->JSONResponse($shopsDTO, 200);
    } catch (Throwable $e) {
      $this->ErrorResponse($e);
    }
  }

  public function show(string $id)
  {
    try {
      $shop = $this->shopService->getShopDetails($id);
      $this->JSONResponse($shop, 200);
    } catch (Throwable $e) {
      $this->ErrorResponse($e);
    }
  }

  public function create()
  {
    try {
      $payload = json_decode(file_get_contents("php://input"), true) ?? [];
      ShopValidation::validateInput($payload);

      $createdDTO = SaveShopDTO::createFromArray($payload);

      $shop = $this->shopService->createShop($createdDTO);
      $this->JSONResponse($shop, 201);

    } catch (Throwable $e) {
      $this->ErrorResponse($e);
    }
  }

  public function delete(string $id)
  {
    try {
      $this->shopService->deleteStore($id);
      $this->JSONResponse(null, 204);
    } catch (Throwable $e) {
      $this->ErrorResponse($e);
    }
  }

  public function update(string $id)
  {
    try {
      $payload = json_decode(file_get_contents("php://input"), true) ?? [];
      ShopValidation::validateInput($payload);

      $dto = SaveShopDTO::createFromArray($payload);

      $shop = $this->shopService->updateShop($id, $dto);
      $this->JSONResponse($shop, 201);

    } catch (Throwable $e) {
      $this->ErrorResponse($e);
    }
  }
}
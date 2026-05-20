<?php

namespace App\Controllers;

use App\DTO\ShopDTO;
use App\Services\ShopService;
use App\Validation\ShopValidation;

class ShopController extends AbstractController
{
  private ShopService $shopService;
  
  public function __construct(ShopService $service)
  {
    $this->shopService = $service;
  }

  public function list()
  {
    $shopsDTO = $this->shopService->getAllShops();
    $this->JSONResponse($shopsDTO, 200);
  }

  public function show(string $id)
  {
    $shop = $this->shopService->getShopDetails($id);
    $this->JSONResponse($shop, 200);
  }

  public function create()
  {
    $createdDTO = ShopValidation::validateInputAndGetDTO();

    $shop = $this->shopService->createShop($createdDTO);

    $this->JSONResponse($shop, 201);
  }

  public function delete(string $id)
  {
    $isDeleted = $this->shopService->deleteStore($id);

    $this->JSONResponse(null, 204);
  }

  public function update(string $id)
  {
    $dto = ShopValidation::validateInputAndGetDTO();

    $isUpdated = $this->shopService->updateShop($id, $dto);

    $this->JSONResponse(null, 201);
  }
}
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
    $this->json($shopsDTO, 200);
  }

  public function show(string $id): ShopDTO | null
  {
    $shop = $this->shopService->getShopDetails($id);
    return $shop;
  }

  public function create()
  {
    $createdDTO = ShopValidation::validateInputAndGetDTO();

    $shop = $this->shopService->createShop($createdDTO);

    $this->json($shop, 201);
  }

  public function delete(string $id)
  {
    $isDeleted = $this->shopService->deleteStore($id);

    echo "Shop {$id} is deleted : {$isDeleted}";
  }

  public function update(string $id)
  {
    $dto = ShopValidation::validateInputAndGetDTO();

    $isUpdated = $this->shopService->updateShop($id, $dto);

    echo "Shop {$id} is updated : {$isUpdated}";
  }
}
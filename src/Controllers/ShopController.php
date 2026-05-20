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

  public function getById(string $id): ShopDTO | null
  {
    $shop = $this->shopService->getShopById($id);
    return $shop;
  }

  public function create()
  {
    $createdDTO = ShopValidation::validateCreate();

    $shop = $this->shopService->createShop($createdDTO);

    $this->json($shop, 201);
  }
}
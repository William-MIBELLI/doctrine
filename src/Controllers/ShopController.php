<?php

namespace App\Controllers;

use App\Services\ShopService;

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
    $this->json($shopsDTO, 201);
  }
}
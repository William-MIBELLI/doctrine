<?php

namespace App\Controllers;

use App\Services\ShopService;
use App\Controllers\AbstractController;

class ShopController extends AbstractController
{
  private ShopService $shopService;
  
  public function __construct(ShopService $service)
  {
    $this->shopService = $service;
  }

  public function list()
  {
    $shops = $this->shopService->getAllShops();
    $this->json($shops, 201);
  }
}
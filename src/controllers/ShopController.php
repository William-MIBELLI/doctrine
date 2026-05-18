<?php

namespace App\Controllers;

use App\Services\ShopService;

class ShopController
{
  private ShopService $shopService;
  
  public function __construct(ShopService $service)
  {
    $this->shopService = $service;
  }
}
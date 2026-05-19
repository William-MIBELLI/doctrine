<?php

namespace App\Controllers;

use App\Services\ShopAvailabilityService;

class ShopAvailabilityController extends AbstractController
{
  private ShopAvailabilityService $service;

  public function __construct(ShopAvailabilityService $service)
  {
    $this->service = $service;
  }

  public function list()
  {
   
  }
}
<?php

namespace App\Controllers;

use App\Services\CircuitService;

class CircuitController
{
  private CircuitService $service;

  public function __construct(CircuitService $service)
  {
    $this->service = $service;
  }

  
}
<?php

namespace App\Controllers;

use App\Services\CircuitService;
use Throwable;

class CircuitController extends AbstractController
{
  private CircuitService $service;

  public function __construct(CircuitService $service)
  {
    $this->service = $service;
  }

  public function list()
  {
    try {
      $circuits = $this->service->getAllCircuits();
    } catch (Throwable $th) {
      $this->ErrorResponse($th);
    }
  }
}
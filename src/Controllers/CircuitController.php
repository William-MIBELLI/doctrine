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
      $investigatorId = filter_input(INPUT_GET, 'investigatorId', FILTER_VALIDATE_INT);

      $circuits = $this->service->getCircuits($investigatorId);

      $this->JSONResponse($circuits, 200);
    } catch (Throwable $th) {
      $this->ErrorResponse($th);
    }
  }

  public function show(int $id)
  {
    try {
      $circuit = $this->service->getCircuitDetails($id);

      $this->JSONResponse($circuit, 200);
    } catch (Throwable $th) {
      $this->ErrorResponse($th);
    }
  }

  public function delete(int $id)
  {
    try {
      $this->service->deleteCircuit($id);

      $this->JSONResponse(null, 204);
    } catch (Throwable $th) {
      $this->ErrorResponse($th);
    }
  }
}
<?php

namespace App\Controllers;

use App\Services\InvestigatorService;
use Throwable;

class InvestigatorController extends AbstractController
{
  private InvestigatorService $investigatorService;

  public function __construct(InvestigatorService $service)
  {
    $this->investigatorService = $service;
  }

  public function list()
  {
    try {
      $data = $this->investigatorService->getAllInvestigators();
      $this->JSONResponse($data);
    } catch (Throwable $e){
      $this->ErrorResponse($e);
    }
  }

  public function show(string $id)
  {
    try {
      $shop = $this->investigatorService->getInvestigatorDetails($id);
      $this->JSONResponse($shop, 200);
    } catch (Throwable $e) {
      $this->ErrorResponse($e);
    }
  }
}
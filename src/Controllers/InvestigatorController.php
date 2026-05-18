<?php

namespace App\Controllers;

use App\Services\InvestigatorService;

class InvestigatorController extends AbstractController
{
  private InvestigatorService $service;

  public function __construct(InvestigatorService $service)
  {
    $this->service = $service;
  }

  public function list()
  {
    $data = $this->service->getAllInvestigators();
    return $this->json($data, 201);
  }
}
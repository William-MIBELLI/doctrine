<?php

namespace App\Controllers;

use App\Services\InvestigatorService;

class InvestigatorController
{
  private InvestigatorService $service;

  public function __construct(InvestigatorService $service)
  {
    $this->service = $service;
  }
}
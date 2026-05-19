<?php

namespace App\Controllers;

use App\Services\InvestigatorAvailabilityService;

class InvestigatorAvailabilityController extends AbstractController
{
  private InvestigatorAvailabilityService $service;

  public function __construct(InvestigatorAvailabilityService $service)
  {
    $this->service = $service;
  }
}
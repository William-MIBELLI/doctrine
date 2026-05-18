<?php

class InvestigatorController
{
  private InvestigatorService $service;

  public function __construct(InvestigatorService $service)
  {
    $this->service = $service;
  }
}
<?php

namespace App\Services;

use Google\Maps\RouteOptimization\V1\Client\RouteOptimizationClient;
use Google\Maps\RouteOptimization\V1\OptimizeToursRequest;
use Google\Maps\RouteOptimization\V1\OptimizeToursResponse;

class GoogleService
{
  private RouteOptimizationClient $client;

  public function __construct()
  {
    $this->client = new RouteOptimizationClient();
  }

  public function sendRequest(string $parent): OptimizeToursResponse
  {
    $request = new OptimizeToursRequest();
    $request->setParent($parent);

    $response = $this->client->optimizeTours($request);

    return $response;
  }

}
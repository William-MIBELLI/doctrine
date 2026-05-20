<?php

namespace App\Controllers;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractController
{
  protected function json(mixed $data): string
  {
    $encoders = [new JsonEncoder()];
    $normalizers = [new ObjectNormalizer()];
    $serializer = new Serializer($normalizers, $encoders);

    $jsonContent = $serializer->serialize($data, 'json');

    return $jsonContent;
  }

  protected function JSONResponse(mixed $data, int $statusCode = 200)
  {
    http_response_code($statusCode);
    header('Content-Type: application/json');

    $body = [
      'status' => 'success',
      'data' => $data
    ];

    $jsonResponse = $this->json($body);

    echo $jsonResponse;
  }

  protected function ErrorResponse(string $message, int $statusCode = 404)
  {
    http_response_code($statusCode);
    header('Content-Type: application/json');

    $body = [
      'status' => 'error',
      'message' => $message
    ];

    $jsonResponse = $this->json($body);

    echo $jsonResponse;
  }
}
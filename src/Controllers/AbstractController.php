<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use Throwable;
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
      'data' => $data,
      'errors' => null
    ];

    $jsonResponse = $this->json($body);

    echo $jsonResponse;
  }

  protected function ErrorResponse(Throwable $e)
  {
    $code = $e->getCode();
    $statusCode = (is_numeric($code) && $code >= 100 && $code <= 599) ? (int)$code : 500;

    http_response_code($statusCode);
    header('Content-Type: application/json');

    $errorContent = $e instanceof ValidationException
      ? $e->getErrors()
      : $e->getMessage();

    $body = [
      'status' => 'error',
      'data' => null,
      'errors' => $errorContent
    ];

    echo $this->json($body);
  }
}
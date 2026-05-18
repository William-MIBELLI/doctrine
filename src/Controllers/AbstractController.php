<?php

namespace App\Controllers;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractController
{
  protected function json(mixed $data, int $status = 200)
  {
    $encoders = [new JsonEncoder()];
    $normalizers = [new ObjectNormalizer()];
    $serializer = new Serializer($normalizers, $encoders);

    $jsonContent = $serializer->serialize($data, 'json');

    http_response_code($status);
    header('Content-type: application/json');

    echo $jsonContent;
  }
}
<?php

require_once __DIR__ . '/bootstrap.php';
// require_once __DIR__ . '/class/Shop.php';

$csvData = [];
$headers = [
  'placeCode',
  'placeName',
  'address',
  'postalCode',
  'city',
  'country',
  'phone',
  'visitCode',
  'visitName',
  'startDate',
  'endDate',
  'comments',
  'type',
  'lng',
  'lat',
];

if (($handler = fopen(__DIR__ . '/data/visits_proxi.csv', 'r')) !== false) {

  $skipped = fgetcsv($handler, null, ";", "\"", "\\");

  while (($rowData = fgetcsv($handler, null, ';', "\"", "\\")) !== false) {
    if (count($headers) === count($rowData)) {
      $csvData[] = array_combine($headers, $rowData);
    }
  }
  fclose($handler);
}
// $shopManager = $entityManager->getRepository('Shop');

foreach ($csvData as $row) {

  $row['placeCode'] = (int) $row['placeCode'];
  $row['postalCode'] = (int) $row['postalCode'];
  $row['phone'] = (int) $row['phone'];
  $row['lng'] = (float) $row['lng'];
  $row['lat'] = (float) $row['lat'];
  $row['cost'] = (int) 30;

  $row['startDate'] = empty($row['startDate']) ? null : new DateTime($row['startDate']);
  $row['endDate'] = empty($row['endDate']) ? null : new DateTime($row['endDate']);

  switch ($row['comments']){
    case "Visite à faire l'après-midi":
      $row['canBeAfternoon'] = true;
      break;
    case "Période libre - pas entre 12h et 14h":
      $row['canBeAfternoon'] = true;
      $row['canBeMorning'] = true;
      break;
    case "Visite à faire le matin":
      $row['canBeMorning'] = true;
      break;
    default:
      $row['canBeAfternoon'] = true;
      $row['canBeMorning'] = true;
      $row['canBeLunchBreak'] = true;
  }

  unset($row['comments']);
  
  $shop = new Shop(...$row);
  $entityManager->persist($shop);
}

$entityManager->flush();
echo "All good 👍";

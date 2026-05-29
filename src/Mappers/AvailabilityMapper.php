<?php

namespace App\Mappers;

use DateTime;
use App\DTO\AvailabilityDTO;
use App\DTO\CreateAvailabilityDTO;
use App\Entities\Interfaces\AvailabilityInterface;


class AvailabilityMapper
{

  public function toDTO(AvailabilityInterface $avail): AvailabilityDTO
  {
    $dto = new AvailabilityDTO(
      id: $avail->getId(),
      dayOfWeek: $avail->getDayOfWeek(),
      openTime: $avail->getOpenTime()->format('H:i'),
      closeTime: $avail->getCloseTime()->format('H:i')
    );
    return $dto;
  }

  public function fromDTO(AvailabilityInterface $avail, CreateAvailabilityDTO $dto): void
  {
    $avail->setDayOfWeek($dto->dayOfWeek);
    $avail->setOpenTime(new DateTime($dto->openTime));
    $avail->setCloseTime(new DateTime($dto->closeTime));
  }
}
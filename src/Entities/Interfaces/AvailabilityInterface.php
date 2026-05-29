<?php

namespace App\Entities\Interfaces;

use DateTime;

interface AvailabilityInterface
{
  public function getId(): ?int;
  public function getDayOfWeek(): int;
  public function getOpenTime(): DateTime;
  public function getCloseTime(): DateTime;

  public function setDayOfWeek(int $value): void;
  public function setOpenTime(DateTime $value): void;
  public function setCloseTime(DateTime $value): void;
}
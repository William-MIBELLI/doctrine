<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\MappedSuperclass]
abstract class AbstractAvailability
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  #[ORM\GeneratedValue]
  private int|null $id = null;

  #[ORM\Column(type: 'integer', name: 'day_of_week')]
  private int $dayOfWeek;

  #[ORM\Column(type: 'time', name: 'open_time')]
  private DateTime $openTime;

  #[ORM\Column(type: 'time', name: 'close_time')]
  private DateTime $closeTime;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getDayOfWeek(): int
  {
    return $this->dayOfWeek;
  }

  public function getOpenTime(): DateTime
  {
    return $this->openTime;
  }

  public function getCloseTime(): DateTime
  {
    return $this->closeTime;
  }


	public function setCloseTime(DateTime $value) {
		$this->closeTime = $value;
	}


	public function setOpenTime(DateTime $value) {
		$this->openTime = $value;
	}


	public function setDayOfWeek(int $value) {
		$this->dayOfWeek = $value;
	}
}
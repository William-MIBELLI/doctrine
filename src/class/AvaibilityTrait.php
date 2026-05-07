<?php

use Doctrine\ORM\Mapping as ORM;

trait AvaibilityTrait
{
  
  #[ORM\Column(type: 'integer', name: 'day_of_week')]
  private int $dayOfWeek;

  #[ORM\Column(type: 'time', name: 'open_time')]
  private DateTime $openTime;

  #[ORM\Column(type: 'time', name: 'close_time')]
  private DateTime $closeTime;
}